<?php

/*
 * Generated from ./src/Antlr4/Protobuf3.g4 by ANTLR 4.13.2
 */

namespace Proteus\Antlr4;
use Antlr\Antlr4\Runtime\Tree\ParseTreeListener;

/**
 * This interface defines a complete listener for a parse tree produced by
 * {@see Protobuf3Parser}.
 */
interface Protobuf3Listener extends ParseTreeListener {
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::proto()}.
	 * @param $context The parse tree.
	 */
	public function enterProto(Context\ProtoContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::proto()}.
	 * @param $context The parse tree.
	 */
	public function exitProto(Context\ProtoContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::syntax()}.
	 * @param $context The parse tree.
	 */
	public function enterSyntax(Context\SyntaxContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::syntax()}.
	 * @param $context The parse tree.
	 */
	public function exitSyntax(Context\SyntaxContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::importStatement()}.
	 * @param $context The parse tree.
	 */
	public function enterImportStatement(Context\ImportStatementContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::importStatement()}.
	 * @param $context The parse tree.
	 */
	public function exitImportStatement(Context\ImportStatementContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::packageStatement()}.
	 * @param $context The parse tree.
	 */
	public function enterPackageStatement(Context\PackageStatementContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::packageStatement()}.
	 * @param $context The parse tree.
	 */
	public function exitPackageStatement(Context\PackageStatementContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::optionStatement()}.
	 * @param $context The parse tree.
	 */
	public function enterOptionStatement(Context\OptionStatementContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::optionStatement()}.
	 * @param $context The parse tree.
	 */
	public function exitOptionStatement(Context\OptionStatementContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::optionName()}.
	 * @param $context The parse tree.
	 */
	public function enterOptionName(Context\OptionNameContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::optionName()}.
	 * @param $context The parse tree.
	 */
	public function exitOptionName(Context\OptionNameContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::fieldLabel()}.
	 * @param $context The parse tree.
	 */
	public function enterFieldLabel(Context\FieldLabelContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::fieldLabel()}.
	 * @param $context The parse tree.
	 */
	public function exitFieldLabel(Context\FieldLabelContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::field()}.
	 * @param $context The parse tree.
	 */
	public function enterField(Context\FieldContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::field()}.
	 * @param $context The parse tree.
	 */
	public function exitField(Context\FieldContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::fieldOptions()}.
	 * @param $context The parse tree.
	 */
	public function enterFieldOptions(Context\FieldOptionsContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::fieldOptions()}.
	 * @param $context The parse tree.
	 */
	public function exitFieldOptions(Context\FieldOptionsContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::fieldOption()}.
	 * @param $context The parse tree.
	 */
	public function enterFieldOption(Context\FieldOptionContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::fieldOption()}.
	 * @param $context The parse tree.
	 */
	public function exitFieldOption(Context\FieldOptionContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::fieldNumber()}.
	 * @param $context The parse tree.
	 */
	public function enterFieldNumber(Context\FieldNumberContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::fieldNumber()}.
	 * @param $context The parse tree.
	 */
	public function exitFieldNumber(Context\FieldNumberContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::oneof()}.
	 * @param $context The parse tree.
	 */
	public function enterOneof(Context\OneofContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::oneof()}.
	 * @param $context The parse tree.
	 */
	public function exitOneof(Context\OneofContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::oneofField()}.
	 * @param $context The parse tree.
	 */
	public function enterOneofField(Context\OneofFieldContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::oneofField()}.
	 * @param $context The parse tree.
	 */
	public function exitOneofField(Context\OneofFieldContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::mapField()}.
	 * @param $context The parse tree.
	 */
	public function enterMapField(Context\MapFieldContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::mapField()}.
	 * @param $context The parse tree.
	 */
	public function exitMapField(Context\MapFieldContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::keyType()}.
	 * @param $context The parse tree.
	 */
	public function enterKeyType(Context\KeyTypeContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::keyType()}.
	 * @param $context The parse tree.
	 */
	public function exitKeyType(Context\KeyTypeContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::type_()}.
	 * @param $context The parse tree.
	 */
	public function enterType_(Context\Type_Context $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::type_()}.
	 * @param $context The parse tree.
	 */
	public function exitType_(Context\Type_Context $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::reserved()}.
	 * @param $context The parse tree.
	 */
	public function enterReserved(Context\ReservedContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::reserved()}.
	 * @param $context The parse tree.
	 */
	public function exitReserved(Context\ReservedContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::ranges()}.
	 * @param $context The parse tree.
	 */
	public function enterRanges(Context\RangesContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::ranges()}.
	 * @param $context The parse tree.
	 */
	public function exitRanges(Context\RangesContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::range_()}.
	 * @param $context The parse tree.
	 */
	public function enterRange_(Context\Range_Context $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::range_()}.
	 * @param $context The parse tree.
	 */
	public function exitRange_(Context\Range_Context $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::reservedFieldNames()}.
	 * @param $context The parse tree.
	 */
	public function enterReservedFieldNames(Context\ReservedFieldNamesContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::reservedFieldNames()}.
	 * @param $context The parse tree.
	 */
	public function exitReservedFieldNames(Context\ReservedFieldNamesContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::topLevelDef()}.
	 * @param $context The parse tree.
	 */
	public function enterTopLevelDef(Context\TopLevelDefContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::topLevelDef()}.
	 * @param $context The parse tree.
	 */
	public function exitTopLevelDef(Context\TopLevelDefContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::enumDef()}.
	 * @param $context The parse tree.
	 */
	public function enterEnumDef(Context\EnumDefContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::enumDef()}.
	 * @param $context The parse tree.
	 */
	public function exitEnumDef(Context\EnumDefContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::enumBody()}.
	 * @param $context The parse tree.
	 */
	public function enterEnumBody(Context\EnumBodyContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::enumBody()}.
	 * @param $context The parse tree.
	 */
	public function exitEnumBody(Context\EnumBodyContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::enumElement()}.
	 * @param $context The parse tree.
	 */
	public function enterEnumElement(Context\EnumElementContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::enumElement()}.
	 * @param $context The parse tree.
	 */
	public function exitEnumElement(Context\EnumElementContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::enumField()}.
	 * @param $context The parse tree.
	 */
	public function enterEnumField(Context\EnumFieldContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::enumField()}.
	 * @param $context The parse tree.
	 */
	public function exitEnumField(Context\EnumFieldContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::enumValueOptions()}.
	 * @param $context The parse tree.
	 */
	public function enterEnumValueOptions(Context\EnumValueOptionsContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::enumValueOptions()}.
	 * @param $context The parse tree.
	 */
	public function exitEnumValueOptions(Context\EnumValueOptionsContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::enumValueOption()}.
	 * @param $context The parse tree.
	 */
	public function enterEnumValueOption(Context\EnumValueOptionContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::enumValueOption()}.
	 * @param $context The parse tree.
	 */
	public function exitEnumValueOption(Context\EnumValueOptionContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::messageDef()}.
	 * @param $context The parse tree.
	 */
	public function enterMessageDef(Context\MessageDefContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::messageDef()}.
	 * @param $context The parse tree.
	 */
	public function exitMessageDef(Context\MessageDefContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::messageBody()}.
	 * @param $context The parse tree.
	 */
	public function enterMessageBody(Context\MessageBodyContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::messageBody()}.
	 * @param $context The parse tree.
	 */
	public function exitMessageBody(Context\MessageBodyContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::messageElement()}.
	 * @param $context The parse tree.
	 */
	public function enterMessageElement(Context\MessageElementContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::messageElement()}.
	 * @param $context The parse tree.
	 */
	public function exitMessageElement(Context\MessageElementContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::extendDef()}.
	 * @param $context The parse tree.
	 */
	public function enterExtendDef(Context\ExtendDefContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::extendDef()}.
	 * @param $context The parse tree.
	 */
	public function exitExtendDef(Context\ExtendDefContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::serviceDef()}.
	 * @param $context The parse tree.
	 */
	public function enterServiceDef(Context\ServiceDefContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::serviceDef()}.
	 * @param $context The parse tree.
	 */
	public function exitServiceDef(Context\ServiceDefContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::serviceElement()}.
	 * @param $context The parse tree.
	 */
	public function enterServiceElement(Context\ServiceElementContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::serviceElement()}.
	 * @param $context The parse tree.
	 */
	public function exitServiceElement(Context\ServiceElementContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::rpc()}.
	 * @param $context The parse tree.
	 */
	public function enterRpc(Context\RpcContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::rpc()}.
	 * @param $context The parse tree.
	 */
	public function exitRpc(Context\RpcContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::constant()}.
	 * @param $context The parse tree.
	 */
	public function enterConstant(Context\ConstantContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::constant()}.
	 * @param $context The parse tree.
	 */
	public function exitConstant(Context\ConstantContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::blockLit()}.
	 * @param $context The parse tree.
	 */
	public function enterBlockLit(Context\BlockLitContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::blockLit()}.
	 * @param $context The parse tree.
	 */
	public function exitBlockLit(Context\BlockLitContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::emptyStatement_()}.
	 * @param $context The parse tree.
	 */
	public function enterEmptyStatement_(Context\EmptyStatement_Context $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::emptyStatement_()}.
	 * @param $context The parse tree.
	 */
	public function exitEmptyStatement_(Context\EmptyStatement_Context $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::ident()}.
	 * @param $context The parse tree.
	 */
	public function enterIdent(Context\IdentContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::ident()}.
	 * @param $context The parse tree.
	 */
	public function exitIdent(Context\IdentContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::fullIdent()}.
	 * @param $context The parse tree.
	 */
	public function enterFullIdent(Context\FullIdentContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::fullIdent()}.
	 * @param $context The parse tree.
	 */
	public function exitFullIdent(Context\FullIdentContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::messageName()}.
	 * @param $context The parse tree.
	 */
	public function enterMessageName(Context\MessageNameContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::messageName()}.
	 * @param $context The parse tree.
	 */
	public function exitMessageName(Context\MessageNameContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::enumName()}.
	 * @param $context The parse tree.
	 */
	public function enterEnumName(Context\EnumNameContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::enumName()}.
	 * @param $context The parse tree.
	 */
	public function exitEnumName(Context\EnumNameContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::fieldName()}.
	 * @param $context The parse tree.
	 */
	public function enterFieldName(Context\FieldNameContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::fieldName()}.
	 * @param $context The parse tree.
	 */
	public function exitFieldName(Context\FieldNameContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::oneofName()}.
	 * @param $context The parse tree.
	 */
	public function enterOneofName(Context\OneofNameContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::oneofName()}.
	 * @param $context The parse tree.
	 */
	public function exitOneofName(Context\OneofNameContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::mapName()}.
	 * @param $context The parse tree.
	 */
	public function enterMapName(Context\MapNameContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::mapName()}.
	 * @param $context The parse tree.
	 */
	public function exitMapName(Context\MapNameContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::serviceName()}.
	 * @param $context The parse tree.
	 */
	public function enterServiceName(Context\ServiceNameContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::serviceName()}.
	 * @param $context The parse tree.
	 */
	public function exitServiceName(Context\ServiceNameContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::rpcName()}.
	 * @param $context The parse tree.
	 */
	public function enterRpcName(Context\RpcNameContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::rpcName()}.
	 * @param $context The parse tree.
	 */
	public function exitRpcName(Context\RpcNameContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::messageType()}.
	 * @param $context The parse tree.
	 */
	public function enterMessageType(Context\MessageTypeContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::messageType()}.
	 * @param $context The parse tree.
	 */
	public function exitMessageType(Context\MessageTypeContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::enumType()}.
	 * @param $context The parse tree.
	 */
	public function enterEnumType(Context\EnumTypeContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::enumType()}.
	 * @param $context The parse tree.
	 */
	public function exitEnumType(Context\EnumTypeContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::intLit()}.
	 * @param $context The parse tree.
	 */
	public function enterIntLit(Context\IntLitContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::intLit()}.
	 * @param $context The parse tree.
	 */
	public function exitIntLit(Context\IntLitContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::strLit()}.
	 * @param $context The parse tree.
	 */
	public function enterStrLit(Context\StrLitContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::strLit()}.
	 * @param $context The parse tree.
	 */
	public function exitStrLit(Context\StrLitContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::boolLit()}.
	 * @param $context The parse tree.
	 */
	public function enterBoolLit(Context\BoolLitContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::boolLit()}.
	 * @param $context The parse tree.
	 */
	public function exitBoolLit(Context\BoolLitContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::floatLit()}.
	 * @param $context The parse tree.
	 */
	public function enterFloatLit(Context\FloatLitContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::floatLit()}.
	 * @param $context The parse tree.
	 */
	public function exitFloatLit(Context\FloatLitContext $context): void;
	/**
	 * Enter a parse tree produced by {@see Protobuf3Parser::keywords()}.
	 * @param $context The parse tree.
	 */
	public function enterKeywords(Context\KeywordsContext $context): void;
	/**
	 * Exit a parse tree produced by {@see Protobuf3Parser::keywords()}.
	 * @param $context The parse tree.
	 */
	public function exitKeywords(Context\KeywordsContext $context): void;
}