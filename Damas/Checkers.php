<?php

include "Board.php";
include "Turn.php";

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
            $this->turn->move($this->board);
            $this->board->show();
            $winner = $this->board->getWinner($this->turn);
            $this->turn->change();
        } while (!$winner);

        $winner->claimVictory();
    }
}

(new Checkers())->play();
