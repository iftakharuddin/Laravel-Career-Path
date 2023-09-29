<?php

class Customer extends User
{
    public BankAccount $account;

    public function __construct(string $name = null, string $email = null, string $password = null) {
       parent::__construct($name, $email, $password, UserType::CUSTOMER);
       $this->account = new BankAccount();
    }

    public function viewTransactions() {
        foreach($this->account->transactions as $transaction) {
            printf("Type: %s Amount: %0.2f\n", $transaction->type->name, $transaction->amount);
        }
    }

}