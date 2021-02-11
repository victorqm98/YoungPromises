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
        return $this->getRow() == $coordinate->getRow();
    }

    public function sameColumn(Coordinate $coordinate): bool
    {
        return $this->getColumn() == $coordinate->getColumn();
    }

    public function equals(Coordinate $coordinate): bool
    {
        return $this->sameRow($coordinate) && $this->sameColumn($coordinate);
    }

    public function inDiagonal(Coordinate $coordinate): bool
    {
        return abs($coordinate->getRow() - $this->getRow()) == abs($coordinate->getColumn() - $this->getColumn());
    }

    public function nextTo(Coordinate $coordinate): bool
    {
        return
            abs($this->getRow() - $coordinate->getRow()) == 1 ||
            abs($this->getColumn() - $coordinate->getColumn()) == 1;
    }

    public function isOver(Coordinate $coordinate): bool
    {
        return $this->getRow() < $coordinate->getRow();
    }

    public function isUnder(Coordinate $coordinate): bool
    {
        return !$this->sameRow($coordinate) && !$this->isOver($coordinate);
    }

    private function isLeft(Coordinate $coordinate): bool
    {
        return $this->getColumn() < $coordinate->getColumn();
    }

    public function coordinateBetween(Coordinate $target): Coordinate
    {   
        $row = $this->getRow();
        $column = $this->getColumn();

        if ($this->isUnder($target)) {
            $row -= 1;
        } else {
            $row += 1;
        }

        if ($this->isLeft($target)) {
            $column += 1;
        } else {
            $column -= 1;
        }

        return new Coordinate($row, $column);
    }
}
