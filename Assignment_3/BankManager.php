<?php

class BankManager
{
    public array $users;
    public array $transactions;
    private Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;

        $this->users = $this->storage->load("users");
    }

    public function showAllTransactions() {
        foreach($this->users as $user) {
            if($user->getType() === UserType::CUSTOMER) {
                printf("User Name: %s, Email: %s\nTransactions:\n", $user->getName(), $user->getEmail());
                $user->viewTransactions();
            }
        }
    }

    public function showTransactionByUser(string $email) {
        $user = $this->getUserByEmail($email);
        $user->viewTransactions();
    }

    public function showCustomers() {
        foreach($this->users as $user) {
            if($user->getType() === UserType::CUSTOMER) {
                printf("Name: %s, Email: %s\n", $user->getName(), $user->getEmail());
            }
        }
    }

    public function login(string $email, string $password) : bool {
        foreach($this->users as $user) {
            if($user->getEmail() ===  $email && $user->getPassword() === $password) {
                return true;
            }
        }
        return false;
    }

    public function getUserByEmail(string $email) {
        foreach($this->users as $user) {
            if($user->getEmail() ===  $email) {
                return $user;
            }
        }
        return null;
    }

    public function registerCustomer($name, $email, $password) {
        $user = new Customer($name, $email, $password);
        $this->users[] = $user;
        $this->saveUsers();
    }

    public function registerAdmin($name, $email, $password) {
        $user = new Admin($name, $email, $password);
        $this->users[] = $user;
        $this->saveUsers();
    }

    public function saveUsers() : void {
        $this->storage->save("users", $this->users);
    }
}