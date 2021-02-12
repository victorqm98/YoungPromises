<?php

include 'Cell.php';
include 'Token.php';
include 'Coordinate.php';

class Board
{
    private array $cells;
    private static $DIMENSION = 8;

    private static $LINE_BREAK = "\n";
    private static $SPACE = " ";

    function __construct()
    {
        $this->cells = [];

        for ($row = 0; $row < static::$DIMENSION; $row++) {
            for ($column = 0; $column < static::$DIMENSION; $column++) {
                $coordinate = new Coordinate($row, $column);
                $new_cell = new Cell($coordinate);
                $this->cells[] = $new_cell;

                if ($new_cell->hasInitialToken()) {
                    $this->fill($coordinate, new Token($row > 4 ? 1 : 0));
                }
            }
        }
    }

    public function fill(Coordinate $coordinate, Token $token): void
    {
        $this->find($coordinate)->fill($token);
    }

    public function empty(Coordinate $coordinate): Token
    {
        return $this->find($coordinate)->empty();
    }

    private function showLetters(): void
    {
        echo static::$SPACE . static::$SPACE;
        $letter = "A";

        for ($i = 0; $i < static::$DIMENSION; $i++) {
            echo $letter;
            $letter++;
        }

        echo static::$LINE_BREAK;
    }

    public function show(): void
    {
        $this->showLetters();

        $row = 1;
        echo $row . static::$SPACE;

        foreach ($this->cells as $key => $cell) {
            $cell->show();

            if (isset($this->cells[$key + 1])) {
                $next_cell = $this->cells[$key + 1];

                if ($cell->differentRow($next_cell)) {
                    $row++;
                    echo static::$LINE_BREAK . $row . static::$SPACE;
                }
            }
        }

        echo static::$LINE_BREAK . static::$LINE_BREAK;
    }

    public function isGameFinished(): bool
    {
        $tokens = [0, 0];

        foreach ($this->cells as $cell) {
            if ($cell->hasToken()) {
                $tokens[$cell->getToken()->getColor()]++;

                if ($tokens[0] > 0 && $tokens[1] > 0) {
                    return false;
                }
            }
        }

        return true;
    }

    public function find(Coordinate $coordinate): Cell
    {
        foreach ($this->cells as $cell) {
            if ($cell->inCoordinate($coordinate)) {
                return $cell;
            }
        }
    }

    public function isLegalMove(Coordinate $origin, Coordinate $target, Turn $turn): bool
    {
        $origin_cell = $this->find($origin);
        $target_cell = $this->find($target);

        if ($origin->nextTo($target)) {

            if ($origin_cell->getToken()->isQueen()) {
                return $origin_cell->inDiagonal($target_cell);
            }

            return $origin_cell->inDiagonal($target_cell) && $origin_cell->rightDirection($target_cell);
        }

        if ($origin_cell->getToken()->isQueen()) {
            return $this->canKill($origin, $target, $turn);
        }

        return $this->canKill($origin, $target, $turn) && $origin_cell->rightDirection($target_cell);
    }

    public function canKill(Coordinate $origin, Coordinate $target, Turn $turn): bool
    {
        if ($this->find($origin)->inDiagonal($this->find($target))) {

            if (abs($target->getRow() - $origin->getRow()) == 2) {
                $enemyCoordinate = $origin->coordinateBetween($target);

                if ($this->find($enemyCoordinate)->hasColor($turn->notCurrent())) {
                    return true;
                }
            }
        }

        return false;
    }

    public function isLegalOrigin(Coordinate $origin, Turn $turn): bool
    {
        if ($this->contains($origin)) {
            $cell = $this->find($origin);
            return $cell->hasToken() && $cell->hasColor($turn->current());
        }

        return false;
    }

    public function isLegalTarget(Coordinate $target): bool
    {
        if ($this->contains($target)) {
            return $this->find($target)->isEmpty();
        }

        return false;
    }

    private function contains(Coordinate $coordinate): bool
    {
        $column = $coordinate->getColumn();
        $row    = $coordinate->getRow();
        return $column < static::$DIMENSION && $column >= 0 && $row < static::$DIMENSION && $row >= 0;
    }

    public function canTransform(Token $token, Coordinate $coordinate): bool
    {
        return !$token->isQueen() && $this->inEdgeRow($coordinate);
    }

    private function inEdgeRow(Coordinate $coordinate): bool
    {
        return $coordinate->getRow() == 0 || $coordinate->getRow() == static::$DIMENSION - 1;
    }
}
