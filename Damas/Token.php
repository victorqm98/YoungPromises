<?php

class Token
{
    private bool $is_queen;

    private static $BLACK = "X";
    private static $WHITE = "O";

    function __construct(Player $player)
    {
        $this->player = $player;
        $this->is_queen = false;
    }

    public function getColor(): string
    {
        return $this->player->getColor();
    }

    public function isBlack(): bool
    {
        return $this->getColor() == static::$BLACK;
    }

    public function isQueen(): bool
    {
        return $this->is_queen;
    }

    public function transform(): void
    {
        $this->is_queen = true;
    }

    public function sameColor(string $color): bool
    {
        return $this->getColor() == $color;
    }

    public function show(): void
    {
        $icon = $this->getIcon();

        if ($this->isQueen()) {
            echo $this->showQueen($icon);
        } else {
            echo $icon;
        }
    }

    private function getIcon(): string
    {
        if ($this->isBlack()) {
            return static::$BLACK;
        }
        
        return static::$WHITE;        
    }

    private function showQueen(string $icon): string
    {
        return "\033[33m" . $icon . "\033[0m";
    }
}
