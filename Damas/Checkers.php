<?php

include "Board.php";
include "Turn.php";
include "Utils.php";

class Checkers
{
    private Board $board;
    private Turn $turn;

    function __construct()
    {
        $this->turn     = new Turn();
        $this->board    = new Board($this->turn);
    }

    public function play(): void
    {
        $this->board->show();

        do {
            $this->claimTurn($this->turn->currentPlayer());
            $this->turn->move($this->board);
            $this->board->show();
            $winner = $this->board->winner($this->turn);
            $this->turn->change();
        } while (!$winner);

        $this->claimVictory($winner);
    }

    private function claimTurn(Player $player): void
    {
        StandardOutputPrinter::printLn("Turno del Jugador " . $player->color());
    }

    private function claimVictory(Player $player): void
    {
        StandardOutputPrinter::printLn("\n¡Jugador " . $player->color() . ' gana!');
    }
}

(new Checkers())->play();