<?php

namespace App\Entity;

class User
{
  private int $id;
  private string $firstName;
  private string $lastName;
  private string $username;
  private string $email;
  private string $password;
  private string $role;

  public function __construct()
  {
  }
  /*set */
  public function setId(int $id)
  {
    $this->id = $id;
  }

  public function setFirstName(string $firstName)
  {
    $this->firstName = $firstName;
  }

  public function setLastName(string $lastName)
  {
    $this->lastName = $lastName;
  }

  public function setUsername(string $username)
  {
    $this->username = $username;
  }

  public function setEmail(string $email)
  {
    $this->email = $email;
  }

  public function setPassword(string $password)
  {
    $this->password = $password;
  }

  public function setRole(string $role)
  {
    $this->role = $role;
  }

  /*get */
  public function getFirstName(): string
  {
    return $this->firstName;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getLastName(): string
  {
    return $this->lastName;
  }

  public function getUsername(): string
  {
    return $this->username;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getPassword(): string
  {
    return $this->password;
  }

  public function getRole(): string
  {
    return $this->role;
  }
}
