<?php

include 'AbstractCoordinate.php';

class Coordinate extends AbstractCoordinate
{
    public function isValid(int $dimension): bool
    {
        $column = $this->getColumn();
        $row = $this->getRow();
        
        return $column < $dimension && $column >= 0 && $row < $dimension && $row >= 0;
    }

    public function hasInitialToken(int $dimension): bool
    {
        $row = $this->getRow();
        $column = $this->getColumn();
        $middle_row = $dimension / 2;
        $in_down_side = $row > $middle_row;

        return ($row < $middle_row - 1 || $in_down_side) && ($row + $column) % 2 == 0;
    }

    public function getInitialPlayerIndex(int $dimension): int
    {
        assert($this->hasInitialToken($dimension)); 

        return $this->getRow() > $dimension / 2 ? 1 : 0;
    }

}
