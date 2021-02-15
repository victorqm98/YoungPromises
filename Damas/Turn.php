<?php

class Turn
{
    private int $color;

    function __construct(int $color)
    {
        $this->color = $color;
    }

    public function current(): int
    {
        return $this->color;
    }

    public function notCurrent(): int
    {
        return ($this->color + 1) % 2;
    }

    public function change(): void
    {
        $this->color = $this->notCurrent();
    }
}