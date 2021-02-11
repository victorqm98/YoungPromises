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

    public function isLegalMove(Coordinate $origin, Coordinate $target): bool
    {
        $origin_cell = $this->find($origin);
        $target_cell = $this->find($target);

        return $origin_cell->correctMove($target_cell);
    }

    private function contains(Coordinate $coordinate)
    {
        
    }

    public function correct(Coordinate $coordinate, Turn $turn): bool
    {
        return $this->contains($coordinate) && //no es pieza del otro
    }
}
