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

    public function getPlayers()
    {
        return $this->players;
    }

    public function move(Board $board): void
    {
        $current_player = $this->getPlayer($this->current());
        echo "Turno del Jugador " . $current_player->getColor() . "\n";
        $current_player->move($board);
    }

    public function writeWinner(): void
    {
        echo "\n¡Jugador " . $this->getPlayer($this->notCurrent())->getColor() . ' gana!';
    }

    public function getPlayer(int $player): Player
    {
        return $this->players[$player];
    }

    private function current(): int
    {
        return $this->current;
    }

    private function notCurrent(): int
    {
        return ($this->current() + 1) % 2;
    }
}
