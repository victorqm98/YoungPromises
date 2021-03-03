<?php

class Icon
{
    private const OPTIONS = ["O", "X"];
    private int $player_index;

    public function __construct(int $index)
    {
        $this->player_index = $index;
    }

    public function isBlack(): bool
    {
        return $this->player_index === 1;
    }

    public function symbol(): string
    {
        return self::OPTIONS[$this->player_index];
    }

     public function show(): void
     {
         echo $this->symbol();
     }
}
