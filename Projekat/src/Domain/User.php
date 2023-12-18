<?php

namespace Cinema\Domain;

class User{
    private $id;
    private $email;
    private $password;
    private $type;

    public function getId()
    {
        return $this->id;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getType()
    {
        return $this->type;
    }
}
