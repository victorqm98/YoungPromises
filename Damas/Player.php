<?php
// include "Utils.php";

class Player
{
    private const BLACK = "X";
    private const WHITE = "O";
    
    protected string $color;

    private function __construct(string $color)
    {
        $this->color = $color;
    }

    public static function initPlayerBlack(): Player
    {
        return new self(self::BLACK);
    }

    public static function initPlayerWhite(): Player
    {
        return new self(self::WHITE);
    }

    public function color(): string
    {
        return $this->color;
    }

    public function isBlack(): bool
    {
        return $this->color() == self::BLACK;
    }

    public function oppositeColor(): string
    {
        return $this->isBlack() ? self::WHITE : self::BLACK;
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
        } while (!$origin->isValid(Board::dimension()) || !$board->find($origin)->hasColor($this->color()));

        return $origin;
    }

    private function askTarget(Board $board): Coordinate
    {
        do {
            $target = $this->askCoordinate("¿Fila destino?", "¿Columna destino?");
        } while (!$target->isValid(Board::dimension()) || !$board->find($target)->isEmpty());

        return $target;
    }

    private function askCoordinate(string $row_question, string $column_question): Coordinate
    {
        $row    = (int) $this->askToUser($row_question) - 1;
        $column = Utils::letterToNumber($this->askToUser($column_question)) - 1;

        return new Coordinate($row, $column);
    }

    private function askToUser(string $question): string
    {
        return Utils::printLnAndInput($question);
    }
}
