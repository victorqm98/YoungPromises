<?php

include 'AbstractCoordinate.php';

class Coordinate extends AbstractCoordinate
{
    public function isValid(int $dimension): bool
    {
        $column = $this->column();
        $row    = $this->row();
        
        return $column < $dimension && $column >= 0 && $row < $dimension && $row >= 0;
    }

    public function hasInitialToken(int $dimension): bool
    {
        $row            = $this->row();
        $column         = $this->column();
        $middle_row     = $dimension / 2;
        $in_down_side   = $row > $middle_row;

        return ($row < $middle_row - 1 || $in_down_side) && ($row + $column) % 2 == 0;
    }

    public function initialPlayerIndex(int $dimension): int
    {
        assert($this->hasInitialToken($dimension)); 

        return $this->row() > $dimension / 2 ? 1 : 0;
    }

    public function coordinateBetween(self $target, int $dimension): self
    {
        assert($target->isValid($dimension));

        return new self($this->betweenRow($target), $this->betweenColumn($target));
    }
}
