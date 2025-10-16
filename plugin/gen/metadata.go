package gen

import (
	"strings"

	"github.com/LeTamanoir/Proteus/plugin/phpgen"
	"google.golang.org/protobuf/types/descriptorpb"
)

// populateMsg extracts metadata (comments, FQNs) from a message and its nested messages
func (g *generator) populateMsg(file *descriptorpb.FileDescriptorProto, msg *descriptorpb.DescriptorProto, phpNamespace string, protoPackage string, msgIndex int) error {
	// Skip map entries
	if msg.GetOptions().GetMapEntry() {
		return nil
	}

	phpMsgFqn := "\\" + strings.TrimLeft(phpNamespace, "\\") + "\\" + phpgen.GetSafeName(msg.GetName())

	protoMsgFqn := msg.GetName()
	if protoPackage != "" {
		protoMsgFqn = "." + strings.TrimLeft(protoPackage, ".") + "." + protoMsgFqn
	}

	for _, loc := range file.SourceCodeInfo.GetLocation() {
		var comment string
		if loc.LeadingComments != nil {
			comment = strings.TrimSpace(loc.GetLeadingComments())
		}
		if loc.TrailingComments != nil {
			trailing := strings.TrimSpace(loc.GetTrailingComments())
			if trailing != "" {
				if comment != "" {
					comment += "\n" + trailing
				} else {
					comment = trailing
				}
			}
		}
		if comment == "" {
			continue
		}

		// descriptorpb.FileDescriptorProto.MessageType -> field number 4
		if len(loc.Path) == 2 && loc.Path[0] == 4 && int32(msgIndex) == loc.Path[1] {
			g.commentByFqn[protoMsgFqn] = comment

		}
		// descriptorpb.FileDescriptorProto.MessageType -> field number 4
		// descriptorpb.DescriptorProto.Field -> field number 2
		if len(loc.Path) == 4 && loc.Path[0] == 4 && int32(msgIndex) == loc.Path[1] && loc.Path[2] == 2 {
			g.commentByFqn[protoMsgFqn+":"+msg.GetField()[loc.Path[3]].GetName()] = comment
		}
	}

	if _, ok := g.msgByFqn[protoMsgFqn]; !ok {
		g.msgByFqn[protoMsgFqn] = &message{
			phpFqn:        phpMsgFqn,
			protoFqn:      protoMsgFqn,
			msg:           msg,
			protoFilePath: file.GetName(),
		}
	}

	for i, nested := range msg.GetNestedType() {
		if err := g.populateMsg(file, nested, phpMsgFqn, protoMsgFqn, i); err != nil {
			return err
		}
	}

	return nil
}
