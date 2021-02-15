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

    public function initialToken(int $dimension): ?Token
    {
        $row = $this->getRow();
        $column = $this->getColumn();
        $middle_row = $dimension / 2;
        $in_down_side = $row > $middle_row;

        if (($row < $middle_row - 1 || $in_down_side) && ($row + $column) % 2 == 0) {
            return new Token($in_down_side ? 1 : 0);
        }

        return null;
    }
}
