<?php

declare(strict_types=1);

namespace Proteus\Internal;

class CodeWriter
{
    private string $output;

    private int $indentLevel;

    private string $indent;

    public function __construct()
    {
        $this->output = '';
        $this->indentLevel = 0;
        $this->indent = str_repeat(' ', 4);
    }

    public function in(): void
    {
        $this->indentLevel++;
    }

    public function out(): void
    {
        $this->indentLevel--;
        if ($this->indentLevel < 0) {
            throw new \Exception('Indent level cannot be negative');
        }
    }

    public function comment(string $comment): void
    {
        $indent = str_repeat($this->indent, $this->indentLevel);
        $this->output .= "{$indent}/** {$comment} */\n";
    }

    public function docblock(string $comment): void
    {
        $indent = str_repeat($this->indent, $this->indentLevel);
        $this->output .= "{$indent}/**\n";
        foreach (explode("\n", $comment) as $line) {
            $this->output .= "{$indent} * $line\n";
        }
        $this->output .= "{$indent} */\n";
    }

    public function line(string $line): void
    {
        $this->output .= str_repeat($this->indent, $this->indentLevel) . $line . "\n";
    }

    public function lines(string $lines): void
    {
        $indent = str_repeat($this->indent, $this->indentLevel);
        foreach (explode("\n", $lines) as $line) {
            $this->output .= "{$indent}$line\n";
        }
    }

    public function newline(): void
    {
        $this->output .= "\n";
    }

    public function getOutput(): string
    {
        return $this->output;
    }
}
