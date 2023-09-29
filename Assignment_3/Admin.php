<?php

class Admin extends User
{
    public function __construct(string $name = null, string $email = null, string $password = null) {
        parent::__construct($name, $email, $password,  UserType::ADMIN);
    }
}