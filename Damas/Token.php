<?php

class Token
{
    private Player $player;
    private bool $is_queen;

    function __construct(Player $player)
    {
        $this->player = $player;
        $this->is_queen = false;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getColor(): string
    {
        return $this->player->getColor();
    }

    public function isBlack(): bool
    {
        return $this->getPlayer()->isBlack();
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
        $icon = $this->getColor();

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
