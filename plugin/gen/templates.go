package gen

import (
	"github.com/LeTamanoir/Proteus/plugin/writer"
	"google.golang.org/protobuf/types/descriptorpb"
)

// inlineReadCode returns inline code for reading a specific protobuf type
// inspired by gogoproto: https://github.com/cosmos/gogoproto/blob/main/plugin/unmarshal/unmarshal.go#L345
func (g *generator) inlineReadCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto, varName string) {
	switch field.GetType() {
	case descriptorpb.FieldDescriptorProto_TYPE_INT32:
		w.InlineReadInt32(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_SINT32:
		w.InlineReadSint32(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_SINT64:
		w.InlineReadSint64(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_UINT32,
		descriptorpb.FieldDescriptorProto_TYPE_INT64:
		w.InlineReadVarint(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_UINT64:
		w.InlineReadUint64(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_BOOL:
		w.InlineReadBool(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_FIXED32:
		w.InlineReadFixed32(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_SFIXED32:
		w.InlineReadSfixed32(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_FIXED64:
		w.InlineReadFixed64(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_SFIXED64:
		w.InlineReadSfixed64(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_FLOAT:
		w.InlineReadFloat(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_DOUBLE:
		w.InlineReadDouble(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_STRING:
		w.InlineReadString(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_BYTES:
		w.InlineReadBytes(varName)

	case descriptorpb.FieldDescriptorProto_TYPE_MESSAGE:
		w.InlineReadVarint("$_len")
		phpType := g.getPhpType(field)
		w.Line("%s = %s::__decode($bytes, $i, $i + $_len);", varName, phpType)
		w.Line("$i += $_len;")
	}
}

// inlineWriteCode generates inline code for writing a specific protobuf type
func (g *generator) inlineWriteCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto, varName, dest string) {
	switch field.GetType() {

	case descriptorpb.FieldDescriptorProto_TYPE_SINT32:
		w.InlineWriteSint32(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_SINT64:
		w.InlineWriteSint64(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_INT32,
		descriptorpb.FieldDescriptorProto_TYPE_UINT32,
		descriptorpb.FieldDescriptorProto_TYPE_INT64:
		w.InlineWriteInt64(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_UINT64:
		w.InlineWriteVarintGmp(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_BOOL:
		w.InlineWriteBool(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_FIXED32:
		w.InlineWriteFixed32(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_SFIXED32:
		w.InlineWriteSfixed32(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_FIXED64:
		w.InlineWriteFixed64(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_SFIXED64:
		w.InlineWriteSfixed64(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_FLOAT:
		w.InlineWriteFloat(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_DOUBLE:
		w.InlineWriteDouble(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_STRING:
		w.InlineWriteString(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_BYTES:
		w.InlineWriteBytes(varName, dest)

	case descriptorpb.FieldDescriptorProto_TYPE_MESSAGE:
		w.Line("$_msgBuf = %s->__encode();", varName)
		w.InlineWritePositiveInt64("strlen($_msgBuf)", dest)
		w.Line("%s .= $_msgBuf;", dest)
	}
}
