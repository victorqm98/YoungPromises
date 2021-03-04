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

    public static function play(): void
    {
        $checkers = new self();
        $checkers->board->show();

        do {
            $checkers->claimTurn($checkers->turn->currentPlayer());
            $checkers->turn->move($checkers->board);
            $checkers->board->show();
            $winner = $checkers->board->winner($checkers->turn);
            $checkers->turn->change();
        } while (!$winner);

        $checkers->claimVictory($winner);
    }

    private function claimTurn(Player $player): void
    {  
        Utils::printLn("Turno del Jugador " . $player->color());
    }

    private function claimVictory(Player $player): void
    {
        Utils::printLn("\n¡Jugador " . $player->color() . ' gana!');
    }
}

Checkers::play();