<?php

class Turn
{
    private array $players;
    private int $current;

    function __construct()
    {
        $this->current = 0;
        $this->players = [new Player("O"), new Player("X")];
    }

    public function change(): void
    {
        $this->current = $this->notCurrent();
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

    private function getPlayer(int $player): Player
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
