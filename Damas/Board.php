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
                $this->fill($coordinate, $coordinate->initialToken(static::$DIMENSION));
            }
        }
    }

    public function move(Coordinate $origin, Coordinate $target, Turn $turn)
    {
        if ($this->canKill($origin, $target, $turn)) {
            $this->empty($origin->coordinateBetween($target));
        }

        $token = $this->empty($origin);
        $this->fill($target, $token);

        if ($this->canTransform($token, $target)) {
            $token->transform();
        }
    }

    public function fill(Coordinate $coordinate, ?Token $token): void
    {
        $this->find($coordinate)->fill($token);
    }

    public function empty(Coordinate $coordinate): Token
    {
        return $this->find($coordinate)->empty();
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
        assert($coordinate->isValid(static::$DIMENSION));

        foreach ($this->cells as $cell) {
            if ($cell->inCoordinate($coordinate)) {
                return $cell;
            }
        }

        assert(false);
    }

    public function isLegalMove(Coordinate $origin, Coordinate $target, Turn $turn): bool
    {
        $origin_cell = $this->find($origin);
        $target_cell = $this->find($target);

        if ($origin_cell->getToken()->isQueen() || $origin_cell->rightDirection($target_cell)) {
            return $this->canKill($origin, $target, $turn) || $origin->nextTo($target) && $origin_cell->inDiagonal($target_cell);
        }

        return false;
    }

    public function canKill(Coordinate $origin, Coordinate $target, Turn $turn): bool
    {        
        $origin_cell = $this->find($origin);
        $target_cell = $this->find($target);

        if ($origin_cell->inDiagonal($target_cell) && abs($target->getRow() - $origin->getRow()) == 2) {
            $enemyCoordinate = $origin->coordinateBetween($target);

            return $this->find($enemyCoordinate)->hasColor($turn->notCurrent());
        }

        return false;
    }

    public function isLegalOrigin(Coordinate $origin, Turn $turn): bool
    {
        if ($origin->isValid(static::$DIMENSION)) {
            $cell = $this->find($origin);
            return $cell->hasToken() && $cell->hasColor($turn->current());
        }

        return false;
    }

    public function isLegalTarget(Coordinate $target): bool
    {
        return $target->isValid(static::$DIMENSION) && $this->find($target)->isEmpty();
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
