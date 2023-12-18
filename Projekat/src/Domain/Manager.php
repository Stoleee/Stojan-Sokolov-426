<?php

namespace Cinema\Domain;

class Manager{
    private $id;
    private $name;
    private $surname;
    private $user_id;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}
