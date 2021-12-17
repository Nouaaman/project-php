<?php

namespace App\Entity;

class Reponse
{
    private int $id;
    private string $label;
    private int $idquestion;
    private int $isValid;

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
    public function setIdquestion(int $idquestion)
    {
        $this->idquestion = $idquestion;
    }
    public function setIsValid(bool $isValid)
    {
        $this->isValid = $isValid;
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
    public function getIdquestion(): int
    {
        return $this->idquestion;
    }
    public function getIsValid(): bool
    {
        return $this->isValid;
    }
}
