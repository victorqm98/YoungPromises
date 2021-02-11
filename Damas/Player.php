<?php

class Player
{
    function __construct()
    {
        //
    }

    public function move(Board $board, Turn $turn): void
    {
        do {
            $origin = $this->askOrigin($board, $turn);
            $target = $this->askTarget($board);
        } while (!$board->isLegalMove($origin, $target, $turn));

        //si esta matando entonces vaciamos la casilla del enemigo
        $token = $board->empty($origin);
        $board->fill($target, $token);
    }

    private function askOrigin(Board $board, Turn $turn): Coordinate
    {
        do {
            $origin = $this->askCoordinate("¿Fila origen?", "¿Columna origen?");
        } while (!$board->isLegalOrigin($origin, $turn));

        return $origin;
    }

    private function askTarget(Board $board): Coordinate
    {
        do {
            $target = $this->askCoordinate("¿Fila destino?", "¿Columna destino?");
        } while (!$board->isLegalTarget($target));

        return $target;
    }

    public function letterToNumber(string $letter): int
    {
        return ord(strtolower($letter)) - 96;
    }

    private function askCoordinate(string $row_question, string $column_question): Coordinate
    {
        $row = (int) $this->askToUser($row_question) - 1;
        $column = $this->letterToNumber($this->askToUser($column_question)) - 1;

        return new Coordinate($row, $column);
    }

    private function askToUser(string $question): string
    {
        echo $question;
        echo "\n";

        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);

        fclose($handle);

        return $line;
    }
}
