<?php

declare(strict_types=1);

namespace Proteus\Internal;

use Proteus\Antlr4\Context\FieldContext;
use Proteus\Antlr4\Context\ImportStatementContext;
use Proteus\Antlr4\Context\MapFieldContext;
use Proteus\Antlr4\Context\MessageDefContext;
use Proteus\Antlr4\Context\OptionStatementContext;
use Proteus\Antlr4\Protobuf3BaseVisitor;

class Protobuf3Visitor extends Protobuf3BaseVisitor
{
    public null|string $phpNamespace = null;

    /**
     * @var string[] List of imported proto files
     */
    public array $imports = [];

    /**
     * @var Message[]
     */
    public array $messages = [];

    /**
     * @var Message[]
     */
    private array $messageStack = [];

    /**
     * @var string[]
     */
    private array $messageNameStack = [];

    private null|Message $currentMessage = null;

    public function visitOptionStatement(OptionStatementContext $context)
    {
        if ($context->optionName()->getText() === 'php_namespace') {
            $this->phpNamespace = str_replace('\\\\', '\\', trim($context->constant()->getText(), '"\''));
        }
    }

    public function visitImportStatement(ImportStatementContext $context)
    {
        $importPath = trim($context->strLit()->getText(), '"\'');
        $this->imports[] = $importPath;
    }

    public function visitMapField(MapFieldContext $context)
    {
        $keyType = new ScalarType(protoType: ProtoType::from($context->keyType()->getText()));

        $valueType = $context->type_()->messageType()
            ? new MessageType(message: $context->type_()->messageType()->getText())
            : new ScalarType(protoType: ProtoType::from($context->type_()->getText()));

        $this->currentMessage->addField(new Field(
            name: $context->mapName()->getText(),
            type: new MapType(
                keyType: $keyType,
                valueType: $valueType,
            ),
            label: null,
            number: (int) $context->fieldNumber()->getText(),
        ));
    }

    public function visitField(FieldContext $context)
    {
        $type = $context->type_()->messageType()
            ? new MessageType(message: $context->type_()->messageType()->getText())
            : new ScalarType(protoType: ProtoType::from($context->type_()->getText()));

        $this->currentMessage->addField(new Field(
            name: $context->fieldName()->getText(),
            type: $type,
            label: $context->fieldLabel() ? FieldLabel::from($context->fieldLabel()->getText()) : null,
            number: (int) $context->fieldNumber()->getText(),
        ));
    }

    public function visitMessageDef(MessageDefContext $context)
    {
        $messageName = $context->messageName()->getText();

        // Build the full name with parent prefixes
        if (!empty($this->messageNameStack)) {
            $fullName = implode('_', $this->messageNameStack) . '_' . $messageName;
        } else {
            $fullName = $messageName;
        }

        // Save the parent message if we're nesting
        if ($this->currentMessage !== null) {
            $this->messageStack[] = $this->currentMessage;
        }

        // Push current message name to the stack for children
        $this->messageNameStack[] = $messageName;

        $this->currentMessage = new Message();
        $this->currentMessage->name = $fullName;

        parent::visitChildren($context);

        // Add all messages (top-level and nested) to the messages array
        $this->messages[] = $this->currentMessage;

        // Pop the name stack
        array_pop($this->messageNameStack);

        // Restore parent message if we were nesting
        if (!empty($this->messageStack)) {
            $this->currentMessage = array_pop($this->messageStack);
        } else {
            $this->currentMessage = null;
        }
    }
}
