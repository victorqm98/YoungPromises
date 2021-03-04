<?php

class Token
{
    private Player $player;
    private bool $is_queen;

    function __construct(Player $player)
    {
        $this->player   = $player;
        $this->is_queen = false;
    }

    public function player(): Player
    {
        return $this->player;
    }

    public function color(): string
    {
        return $this->player()->color();
    }

    public function isBlack(): bool
    {
        return $this->player()->isBlack();
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
        return $this->color() == $color;
    }

    public function show(): void
    {
        $icon = $this->color();

        if ($this->isQueen()) {
            echo $this->showQueen($icon);
        } else {
            echo $icon;
        }
    }

    private function showQueen(string $icon): string
    {
        return "\033[33m" . $icon . "\033[0m";
    }
}
