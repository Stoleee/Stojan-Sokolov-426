<?php

namespace Cinema\Domain;

class Admin{
    private $id;
    private $name;
    private $surname;
    private $user_id;

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getSurname(): string
    {
        return $this->surname;
    }
  
    public function getUserId(): int
    {
        return $this->user_id;
    }
}
