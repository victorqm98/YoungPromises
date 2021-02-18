<?php

class Player
{
    protected static $BLACK = "X";
    protected static $WHITE = "O";
    
    protected string $color;

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public static function getWhiteColor(): string
    {
        return static::$WHITE;
    }

    public static function getBlackColor(): string
    {
        return static::$BLACK;
    }

    public function isBlack(): bool
    {
        return $this->getColor() == static::getBlackColor();
    }

    public function getOppositeColor(): string
    {
        return $this->isBlack() ? static::getWhiteColor() : static::getBlackColor();
    }

    public function move(Board $board): void
    {
        do {
            $origin = $this->askOrigin($board);
            $target = $this->askTarget($board);
        } while (!$board->isLegalMove($origin, $target, $this));

        $board->move($origin, $target, $this);
    }

    private function askOrigin(Board $board): Coordinate
    {
        do {
            $origin = $this->askCoordinate("¿Fila origen?", "¿Columna origen?");
        } while (!$origin->isValid(Board::getDimension()) || !$board->find($origin)->hasColor($this->getColor()));

        return $origin;
    }

    private function askTarget(Board $board): Coordinate
    {
        do {
            $target = $this->askCoordinate("¿Fila destino?", "¿Columna destino?");
        } while (!$target->isValid(Board::getDimension()) || !$board->find($target)->isEmpty());

        return $target;
    }

    private function askCoordinate(string $row_question, string $column_question): Coordinate
    {
        $row    = (int) $this->askToUser($row_question) - 1;
        $column = $this->letterToNumber($this->askToUser($column_question)) - 1;

        return new Coordinate($row, $column);
    }

    private function letterToNumber(string $letter): int
    {
        return ord(strtolower($letter)) - 96;
    }

    private function askToUser(string $question): string
    {
        echo $question;
        echo "\n";

        $handle = fopen("php://stdin", "r");
        $line   = fgets($handle);

        fclose($handle);

        return $line;
    }

    public function claimVictory(): void
    {
        echo "\n¡Jugador " . $this->getColor() . ' gana!';
    }
}
