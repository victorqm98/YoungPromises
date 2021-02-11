<?php

class Token
{
    private int $color;
    private bool $is_queen;

    private static $BLACK = "X";
    private static $WHITE = "O";

    function __construct(int $color)
    {
        $this->color = $color;
        $this->is_queen = false;
    }

    public function getColor(): int
    {
        return $this->color;
    }

    public function isBlack(): bool
    {
        return $this->getColor() == 1;
    }

    public function isWhite(): bool
    {
        return !$this->isBlack();
    }

    public function isQueen(): bool
    {
        return $this->is_queen;
    }

    public function sameColor(int $color): bool
    {
        return $this->getColor() == $color;
    }

    public function show(): void
    {
        if ($this->isBlack()) {
            echo static::$BLACK;
        } else {
            echo static::$WHITE;
        }
    }
}
