<?php

abstract class AbstractCoordinate
{
    private int $row;
    private int $column;

    function __construct(int $row, int $column)
    {
        $this->row      = $row;
        $this->column   = $column;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function sameRow(self $coordinate): bool
    {
        return $this->getRow() == $coordinate->getRow();
    }

    public function sameColumn(self $coordinate): bool
    {
        return $this->getColumn() == $coordinate->getColumn();
    }

    public function equals(self $coordinate): bool
    {
        return $this->sameRow($coordinate) && $this->sameColumn($coordinate);
    }

    public function inDiagonal(self $coordinate): bool
    {
        return abs($coordinate->getRow() - $this->getRow()) == abs($coordinate->getColumn() - $this->getColumn());
    }

    public function nextTo(self $coordinate): bool
    {
        return
            abs($this->getRow() - $coordinate->getRow()) == 1 ||
            abs($this->getColumn() - $coordinate->getColumn()) == 1;
    }

    public function isOver(self $coordinate): bool
    {
        return $this->getRow() < $coordinate->getRow();
    }

    public function isUnder(self $coordinate): bool
    {
        return !$this->sameRow($coordinate) && !$this->isOver($coordinate);
    }

    private function isLeft(self $coordinate): bool
    {
        return $this->getColumn() < $coordinate->getColumn();
    }

    public function getBetweenColumn(self $coordinate): int
    {
        $column = $coordinate->getColumn();

        if ($this->isLeft($coordinate)) {
            return $column + 1;
        }

        return $column - 1;
    }

    public function getBetweenRow(self $coordinate): int
    {
        $row = $coordinate->getRow();

        if ($this->isUnder($coordinate)) {
            return $row - 1;
        }

        return $row + 1;
    }
}
