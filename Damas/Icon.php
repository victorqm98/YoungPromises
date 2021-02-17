<?php

class Icon
{
    private static $OPTIONS = ["O", "X"];
    private int $player_index;

    public function __construct(int $index)
    {
        $this->player_index = $index;
    }

    public function isBlack(): bool
    {
        return $this->player_index == 1;
    }

    public function getSymbol(): string
    {
        return static::$OPTIONS[$this->player_index];
    }

    public function show(): void
    {
        echo $this->getSymbol();
    }
}
