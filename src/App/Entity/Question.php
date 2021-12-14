<?php

namespace App\Entity;

class Question
{
    private int $id;

    public function __construct()
    {
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
