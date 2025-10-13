<?php

declare(strict_types=1);

namespace Proteus\Internal;

use Proteus\Antlr4\Context\FieldContext;
use Proteus\Antlr4\Context\MapFieldContext;
use Proteus\Antlr4\Context\MessageDefContext;
use Proteus\Antlr4\Context\OptionStatementContext;
use Proteus\Antlr4\Protobuf3BaseVisitor;

class Protobuf3Visitor extends Protobuf3BaseVisitor
{
    public null|string $phpNamespace = null;

    /**
     * @var Message[]
     */
    public array $messages = [];

    private null|Message $currentMessage = null;

    public function visitOptionStatement(OptionStatementContext $context)
    {
        if ($context->optionName()->getText() === 'php_namespace') {
            $this->phpNamespace = str_replace('\\\\', '\\', trim($context->constant()->getText(), '"\''));
        }
    }

    public function visitMapField(MapFieldContext $context)
    {
        $this->currentMessage->addField(new Field(
            name: $context->mapName()->getText(),
            type: new Type(
                protoType: ProtoType::Map,
                keyType: new Type(protoType: ProtoType::from($context->keyType()->getText())),
                valueType: $context->type_()->messageType()
                    ? new Type(
                        protoType: ProtoType::Message,
                        message: $context->type_()->messageType()->getText(),
                    )
                    : new Type(protoType: ProtoType::from($context->type_()->getText())),
            ),
            label: null,
            number: $context->fieldNumber()->getText(),
        ));
    }

    public function visitField(FieldContext $context)
    {
        $this->currentMessage->addField(new Field(
            name: $context->fieldName()->getText(),
            type: $context->type_()->messageType()
                ? new Type(
                    protoType: ProtoType::Message,
                    message: $context->type_()->messageType()->getText(),
                )
                : new Type(protoType: ProtoType::from($context->type_()->getText())),
            label: $context->fieldLabel() ? FieldLabel::from($context->fieldLabel()->getText()) : null,
            number: $context->fieldNumber()->getText(),
        ));
    }

    public function visitMessageDef(MessageDefContext $context)
    {
        $this->currentMessage = new Message(name: $context->messageName()->getText());

        parent::visitChildren($context);

        $this->messages[] = $this->currentMessage;
        unset($this->currentMessage);
    }
}
