<?php

namespace App\Entity;

class User
{
  protected $name = 'Boris';


  public function getName(): string
  {
    return $this->name;
  }


  public function __toString(): string
  {
    return 'toto';
  }
}

