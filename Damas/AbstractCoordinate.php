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

    public function row(): int
    {
        return $this->row;
    }

    public function column(): int
    {
        return $this->column;
    }

    public function sameRow(self $coordinate): bool
    {
        return $this->row() == $coordinate->row();
    }

    public function sameColumn(self $coordinate): bool
    {
        return $this->column() == $coordinate->column();
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
        return abs($coordinate->row() - $this->row());
    }

    public function distanceInColumns(self $coordinate): int
    {
        return abs($coordinate->column() - $this->column());
    }

    public function isOver(self $coordinate): bool
    {
        return $this->row() < $coordinate->row();
    }

    public function isUnder(self $coordinate): bool
    {
        return !$this->sameRow($coordinate) && !$this->isOver($coordinate);
    }

    public function isLeft(self $coordinate): bool
    {
        return $this->column() < $coordinate->column();
    }

    public function betweenColumn(self $coordinate): int
    {
        $column = $this->column();

        if ($this->isLeft($coordinate)) {
            return $column + 1;
        }

        return $column - 1;
    }

    public function betweenRow(self $coordinate): int
    {
        $row = $this->row();

        if ($this->isUnder($coordinate)) {
            return $row - 1;
        }

        return $row + 1;
    }
}
