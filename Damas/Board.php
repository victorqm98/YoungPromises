<?php

include 'Cell.php';
include 'Token.php';
include 'Coordinate.php';

class Board
{
    private array $cells;
    public const DIMENSION      = 8;

    private const LINE_BREAK    = "\n";
    private const SPACE         = " ";

    function __construct(Turn $turn)
    {
        $this->cells = [];
        $dimension = static::dimension();
        for ($row = 0; $row < $dimension; $row++) {
            for ($column = 0; $column < $dimension; $column++) {
                $coordinate     = new Coordinate($row, $column);
                $new_cell       = new Cell($coordinate);
                $this->cells[]  = $new_cell;
                $this->putToken($dimension, $turn, $coordinate);
            }
        }
    }

    public function putToken(int $dimension, Turn $turn, Coordinate $coordinate): void
    {
        if ($coordinate->hasInitialToken($dimension)) {
            $player = $turn->player($coordinate->initialPlayerIndex(static::dimension()));
            $this->fill($coordinate, new Token($player));
        }
    }

    public static function dimension(): int
    {
        return self::DIMENSION;
    }

    public function move(Coordinate $origin, Coordinate $target, Player $player): void
    {
        if ($this->canKill($origin, $target, $player)) {
            $this->empty($origin->coordinateBetween($target, static::dimension()));
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
        echo $row . self::SPACE;

        foreach ($this->cells as $key => $cell) {
            $cell->show();

            if (isset($this->cells[$key + 1])) {
                $next_cell = $this->cells[$key + 1];

                if ($cell->differentRow($next_cell)) {
                    $row++;
                    echo self::LINE_BREAK . $row . self::SPACE;
                }
            }
        }

        echo self::LINE_BREAK . self::LINE_BREAK;
    }

    private function showLetters(): void
    {
        echo self::SPACE . self::SPACE;

        $letter     = "A";
        $dimension  = static::dimension();

        for ($i = 0; $i < $dimension; $i++) {
            echo $letter;
            $letter++;
        }

        echo self::LINE_BREAK;
    }

    public function winner(Turn $turn): ?Player
    {
        $tokens = 0;
        $enemy = $turn->notCurrentPlayer();

        foreach ($this->cells as $cell) {
            if ($cell->hasToken() && $cell->token()->sameColor($enemy->color())) {
                $tokens++;
                if ($tokens > 0) {
                    return null;
                }
            }
        }

        return $turn->currentPlayer();
    }

    public function find(Coordinate $coordinate): Cell
    {
        assert($coordinate->isValid(static::dimension()));

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

        if ($origin_cell->token()->isQueen() || $origin_cell->rightDirection($target_cell)) {
            return $this->canKill($origin, $target, $player) || $origin->nextTo($target) && $origin_cell->inDiagonal($target_cell);
        }

        return false;
    }

    private function canKill(Coordinate $origin, Coordinate $target, Player $player): bool
    {
        $origin_cell = $this->find($origin);
        $target_cell = $this->find($target);

        if ($origin_cell->inDiagonal($target_cell) && $target->distanceInRows($origin) == 2) {
            $enemyCoordinate = $origin->coordinateBetween($target, static::dimension());
            return $this->find($enemyCoordinate)->hasColor($player->oppositeColor());
        }

        return false;
    }

    private function canTransform(Token $token, Coordinate $coordinate): bool
    {
        return !$token->isQueen() && ($coordinate->row() == 0 || $coordinate->row() == static::dimension() - 1);
    }
}
