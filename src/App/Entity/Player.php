<?php

namespace App\Entity;

use App\Entity\User;

class Player extends User
{
    private string $color;
    private int $position;

    public function __construct()
    {
    }
    /*set */
    public function setColor(string $color)
    {
        $this->color = $color;
    }

    public function setPosition(string $position)
    {
        $this->position = $position;
    }


    /*get */
    public function getColor(): string
    {
        return $this->color;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
}
