package gen

import (
	"strings"
)

func (e *message) PhpNamespace() string {
	parts := strings.Split(string(e.phpFqn), "\\")
	return strings.Trim(strings.Join(parts[:len(parts)-1], "\\"), "\\")
}
