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
        return $this->distanceInRows($coordinate) == $this->distanceInColumns($coordinate);
    }

    public function nextTo(self $coordinate): bool
    {
        return $this->distanceInRows($coordinate) == 1 || $this->distanceInColumns($coordinate) == 1;
    }

    public function distanceInRows(self $coordinate): int
    {
        return abs($coordinate->getRow() - $this->getRow());
    }

    public function distanceInColumns(self $coordinate): int
    {
        return abs($coordinate->getColumn() - $this->getColumn());
    }

    public function isOver(self $coordinate): bool
    {
        return $this->getRow() < $coordinate->getRow();
    }

    public function isUnder(self $coordinate): bool
    {
        return !$this->sameRow($coordinate) && !$this->isOver($coordinate);
    }

    public function isLeft(self $coordinate): bool
    {
        return $this->getColumn() < $coordinate->getColumn();
    }

    public function getBetweenColumn(self $coordinate): int
    {
        $column = $this->getColumn();

        if ($this->isLeft($coordinate)) {
            return $column + 1;
        }

        return $column - 1;
    }

    public function getBetweenRow(self $coordinate): int
    {
        $row = $this->getRow();

        if ($this->isUnder($coordinate)) {
            return $row - 1;
        }

        return $row + 1;
    }
}
