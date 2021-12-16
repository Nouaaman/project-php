<?php

namespace App\Entity;

class Question
{
    private int $id;
    private string $label;
    private int $level;

    public function __construct()
    {
    }
    //SET
    public function setId(int $id)
    {
        $this->id = $id;
    }
    public function setLabel(string $label)
    {
        $this->label = $label;
    }
    public function setLevel(int $level)
    {
        $this->level = $level;
    }
    //GET
    public function getId(): int
    {
        return $this->id;
    }
    public function getLabel(): string
    {
        return $this->label;
    }
    public function getLevel(): int
    {
        return $this->level;
    }
}
