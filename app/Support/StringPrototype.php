<?php

namespace App\Support;

class StringPrototype
{
    private $string;

    private $length = null;

    private $letters = [];

    public function __construct(string $string)
    {
        $this->string = $string;
        $this->length = mb_strlen($string);
        $this->letters = mb_str_split($string);
    }

    public function length(): int
    {
        return $this->length;
    }

    public function letter(int $position): ?string
    {
        return $this->letters[$position] ?? null;
    }

    public function getLetters(): array
    {
        return $this->letters;
    }

    public function filter(callable $callback): array
    {
        return array_filter($this->letters, $callback);
    }

    public function each(callable $callback): self
    {
        foreach ($this->letters as $letter) {
            $callback($letter);
        }

        return $this;
    }
}
