<?php

include "Player.php";
include "Board.php";
include "Turn.php";

class Checkers
{
    private Board $board;
    private Turn $turn;

    function __construct()
    {
        $this->board    = new Board();
        $this->turn     = new Turn();
    }

    public function play()
    {
        $this->board->show();

        do {
            $this->turn->move($this->board);
            $this->board->show();
            $this->turn->change();
        } while (!$this->board->isGameFinished());

        $this->turn->writeWinner();
    }
}

(new Checkers())->play();