<?php

include "Player.php";

class Turn
{
    private array $players;
    private int $current = 0;

    function __construct()
    {
        $this->players = [
            Player::createWhitePlayer(),
            Player::createBlackPlayer()
        ];
    }

    public function change(): void
    {
        $this->current = $this->notCurrent();
    }

    public function move(Board $board): void
    {
        $current_player = $this->currentPlayer();
        $current_player->move($board);
    }

    public function player(int $player): Player
    {
        return $this->players[$player];
    }

    public function currentPlayer(): Player
    {
        return $this->player($this->current);
    }

    public function notCurrentPlayer(): Player
    {
        return $this->player($this->notCurrent());
    }

    private function notCurrent(): int
    {
        return !$this->current;
    }
}
