<?php

declare(strict_types=1);

class User
{
    protected string $name;
    protected string $email;
    protected string $password;
    protected UserType $type;

    public function __construct(string $name = null, string $email = null, string $password = null, UserType $type) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->type = $type;
    }

    public function getName() : string {
        return $this->name;
    }

    public function setName(string $name) : void {
        $this->name = $name;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function setEmail(string $email) : void {
        $this->email = $email;
    }

    public function getPassword() : string {
        return $this->password;
    }

    public function setPassword(string $password) : void {
        $this->password = $password;
    }

    public function getType() : UserType {
        return $this->type;
    }

}