<?php

class Cell
{
    private Coordinate $coordinate;
    private ?Token $token;
    private const EMPTY = '-';

    function __construct(Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;
    }

    private function coordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function token(): Token
    {
        return $this->token;
    }

    public function fill(?Token $token): void
    {
        $this->token = $token;
    }

    public function empty(): Token
    {
        $token          = $this->token();
        $this->token    = null;
        return $token;
    }

    public function inCoordinate(Coordinate $coordinate): bool
    {
        return $this->coordinate->equals($coordinate);
    }

    public function differentRow(self $cell): bool
    {
        return !$this->coordinate->sameRow($cell->coordinate());
    }

    public function show(): void
    {
        if ($this->hasToken()) {
            $this->token->show();
        } else {
            echo self::EMPTY;
        }
    }

    public function hasToken(): bool
    {
        return isset($this->token);
    }

    public function hasColor(string $color): string
    {
        return $this->hasToken() && $this->token()->sameColor($color);
    }

    public function isEmpty(): bool
    {
        return !$this->hasToken();
    }

    public function inDiagonal(self $target_cell): bool
    {
        return $this->coordinate->inDiagonal($target_cell->coordinate());
    }

    public function rightDirection(self $target_cell): bool
    {
        if ($this->token()->isBlack()) {
            return $this->coordinate->isUnder($target_cell->coordinate());
        }

        return $this->coordinate->isOver($target_cell->coordinate());
    }
}
