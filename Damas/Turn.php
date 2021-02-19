<?php

include "Player.php";

class Turn
{
    private array $players;
    private int $current;

    function __construct()
    {
        $this->current = 0;
        $this->players = [new Player(Player::getWhiteColor()), new Player(Player::getBlackColor())];
    }

    public function change(): void
    {
        $this->current = $this->notCurrent();
    }

    public function move(Board $board): void
    {
        $current_player = $this->currentPlayer();
        $this->claimTurn($current_player);
        $current_player->move($board);
    }

    private function claimTurn(Player $player): void
    {  
        echo "Turno del Jugador " . $player->getColor() . "\n";
    }

    public function getPlayer(int $player): Player
    {
        return $this->players[$player];
    }

    public function currentPlayer(): Player
    {
        return $this->getPlayer($this->current);
    }

    public function notCurrentPlayer(): Player
    {
        return $this->getPlayer($this->notCurrent());
    }

    private function notCurrent(): int
    {
        return !$this->current;
    }
}
