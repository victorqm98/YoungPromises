<?php

class Cell
{
    private Coordinate $coordinate;
    private Token $token;
    private static $EMPTY = '-';

    function __construct(Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function fill(Token $token): void
    {
        $this->token = $token;
    }

    public function empty(): Token
    {
        $token = $this->getToken();
        unset($this->token);

        return $token;
    }

    public function inCoordinate(Coordinate $coordinate): bool
    {
        return $this->coordinate->equals($coordinate);
    }

    public function differentRow(Cell $cell): bool
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

    public function hasColor(int $color): int
    {
        return $this->hasToken() && $this->getToken()->sameColor($color);
    }

    public function isEmpty(): bool
    {
        return !$this->hasToken();
    }

    public function inDiagonal(Cell $target_cell): bool
    {
        return $this->coordinate->inDiagonal($target_cell->getCoordinate());
    }

    public function hasInitialToken(): bool
    {
        $coordinate = $this->getCoordinate();
        $row = $coordinate->getRow();
        $column = $coordinate->getColumn();

        return $row != 3 && $row != 4 && ($row + $column) % 2 == 0;
    }

    public function rightDirection(Cell $target_cell): bool
    {
        if ($this->token->isBlack()) {
            return $this->coordinate->isUnder($target_cell->getCoordinate());
        }

        return $this->coordinate->isOver($target_cell->getCoordinate());
    }
}
