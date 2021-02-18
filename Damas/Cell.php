<?php

class Cell
{
    private Coordinate $coordinate;
    private ?Token $token;
    private static $EMPTY = '-';

    function __construct(Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;
    }

    private function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function fill(?Token $token): void
    {
        $this->token = $token;
    }

    public function empty(): Token
    {
        $token          = $this->getToken();
        $this->token    = null;
        return $token;
    }

    public function inCoordinate(Coordinate $coordinate): bool
    {
        return $this->coordinate->equals($coordinate);
    }

    public function differentRow(self $cell): bool
    {
        return !$this->coordinate->sameRow($cell->getCoordinate());
    }

    public function show(): void
    {
        if ($this->hasToken()) {
            $this->token->show();
        } else {
            echo static::$EMPTY;
        }
    }

    public function hasToken(): bool
    {
        return isset($this->token);
    }

    public function hasColor(string $color): string
    {
        return $this->hasToken() && $this->getToken()->sameColor($color);
    }

    public function isEmpty(): bool
    {
        return !$this->hasToken();
    }

    public function inDiagonal(self $target_cell): bool
    {
        return $this->coordinate->inDiagonal($target_cell->getCoordinate());
    }

    public function rightDirection(self $target_cell): bool
    {
        if ($this->getToken()->isBlack()) {
            return $this->coordinate->isUnder($target_cell->getCoordinate());
        }

        return $this->coordinate->isOver($target_cell->getCoordinate());
    }
}
