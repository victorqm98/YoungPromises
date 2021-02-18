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

    function __construct(Turn $turn)
    {
        $this->cells = [];
        $dimension = static::getDimension();
        for ($row = 0; $row < $dimension; $row++) {
            for ($column = 0; $column < $dimension; $column++) {
                $coordinate = new Coordinate($row, $column);
                $new_cell = new Cell($coordinate);
                $this->cells[] = $new_cell;
                $this->putToken($dimension, $turn, $coordinate);
            }
        }
    }

    public function putToken(int $dimension, Turn $turn, Coordinate $coordinate): void
    {
        if ($coordinate->hasInitialToken($dimension)) {
            $player = $turn->getPlayer($coordinate->getInitialPlayerIndex(static::getDimension()));
            $this->fill($coordinate, new Token($player));
        }
    }

    public static function getDimension(): int
    {
        return static::$DIMENSION;
    }

    public function move(Coordinate $origin, Coordinate $target, Player $player)
    {
        if ($this->canKill($origin, $target, $player)) {
            $this->empty($origin->coordinateBetween($target, static::getDimension()));
        }

        $token = $this->empty($origin);
        $this->fill($target, $token);

        if ($this->canTransform($token, $target)) {
            $token->transform();
        }
    }

    private function fill(Coordinate $coordinate, Token $token): void
    {
        $this->find($coordinate)->fill($token);
    }

    private function empty(Coordinate $coordinate): Token
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
        $dimension = static::getDimension();

        for ($i = 0; $i < $dimension; $i++) {
            echo $letter;
            $letter++;
        }

        echo static::$LINE_BREAK;
    }

    public function isGameFinished(Turn $turn): bool
    {
        foreach ($turn->getPlayers() as $player) {
            $tokens[$player->getColor()] = 0;
        }

        foreach ($this->cells as $cell) {
            if ($cell->hasToken()) {
                $tokens[$cell->getToken()->getColor()]++;

                if ($tokens[$turn->getPlayer(0)->getColor()] > 0 && $tokens[$turn->getPlayer(1)->getColor()] > 0) {
                    return false;
                }
            }
        }

        return true;
    }

    public function find(Coordinate $coordinate): Cell
    {
        assert($coordinate->isValid(static::getDimension()));

        foreach ($this->cells as $cell) {
            if ($cell->inCoordinate($coordinate)) {
                return $cell;
            }
        }

        assert(false);
    }

    public function isLegalMove(Coordinate $origin, Coordinate $target, Player $player): bool
    {
        $origin_cell = $this->find($origin);
        $target_cell = $this->find($target);

        if ($origin_cell->getToken()->isQueen() || $origin_cell->rightDirection($target_cell)) {
            return $this->canKill($origin, $target, $player) || $origin->nextTo($target) && $origin_cell->inDiagonal($target_cell);
        }

        return false;
    }

    private function canKill(Coordinate $origin, Coordinate $target, Player $player): bool
    {
        $origin_cell = $this->find($origin);
        $target_cell = $this->find($target);

        if ($origin_cell->inDiagonal($target_cell) && abs($target->getRow() - $origin->getRow()) == 2) {
            $enemyCoordinate = $origin->coordinateBetween($target, static::getDimension());
            return $this->find($enemyCoordinate)->hasColor($player->getOppositeColor());;
        }

        return false;
    }

    private function canTransform(Token $token, Coordinate $coordinate): bool
    {
        return !$token->isQueen() && ($coordinate->getRow() == 0 || $coordinate->getRow() == static::getDimension() - 1);
    }
}
