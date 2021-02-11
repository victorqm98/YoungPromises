<?php

include "Player.php";
include "Board.php";
include "Turn.php";

class Damas
{
    private array $players; //TODO
    private Board $board;
    private Turn $turn;

    function __construct()
    {
        $this->players  = [new Player(), new Player()];
        $this->board    = new Board();
        $this->turn     = new Turn(0);
    }

    public function play()
    {
        $this->board->show();

        do {
            $current_turn = $this->turn->current();
            echo "Turno del Jugador " . $current_turn . "\n";

            $this->players[$current_turn]->move($this->board, $this->turn);
            $this->board->show();

            $this->turn->change();
        } while (!$this->board->isGameFinished());
    }
}

(new Damas())->play();

//CESC::Aunque algunos se rian, es más facil reir que hacer!!!