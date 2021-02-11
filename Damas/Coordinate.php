<?php

class Coordinate
{
    private int $row;
    private int $column;

    function __construct(int $row, int $column)
    {
        $this->row = $row;
        $this->column = $column;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function sameRow(Coordinate $coordinate): bool
    {
        return $this->row == $coordinate->getRow();
    }

    public function sameColumn(Coordinate $coordinate): bool
    {
        return $this->column == $coordinate->getColumn();
    }

    public function equals(Coordinate $coordinate): bool
    {
        return $this->sameRow($coordinate) && $this->sameColumn($coordinate);
    }

    public function inDiagonal(Coordinate $coordinate): bool
    {
        $coord_row = $coordinate->getRow();
        $coord_column = $coordinate->getColumn();

        return
            $this->row + 1 == $coord_row && $this->column + 1 == $coord_column ||
            $this->row - 1 == $coord_row && $this->column + 1 == $coord_column ||
            $this->row + 1 == $coord_row && $this->column - 1 == $coord_column ||
            $this->row - 1 == $coord_row && $this->column - 1 == $coord_column;
    }

    public function nextTo(Coordinate $coordinate): bool
    {
        return
            abs($this->row - $coordinate->getRow()) == 1 ||
            abs($this->column - $coordinate->getColumn()) == 1;
    }

    public function isOver(Coordinate $coordinate): bool
    {
        return $this->row < $coordinate->getRow();
    }

    public function isUnder(Coordinate $coordinate): bool
    {
        return !$this->sameRow($coordinate) && !$this->isOver($coordinate);
    }
}
