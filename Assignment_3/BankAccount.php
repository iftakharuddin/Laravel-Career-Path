<?php

class BankAccount
{
    public float $balance;
    public array $transactions = [];

    public function __construct() {
        $this->balance = 0;
    }

    public function getBalance() : float {
        return $this->balance;
    }

    public function deposit(float $amount) {
        $this->balance += $amount;
        $this->addTransaction(TransactionType::DEPOSIT, $amount);
    }

    public function withdraw(float $amount) {
        $this->balance -= $amount;
        $this->addTransaction(TransactionType::WITHDRAW, $amount);
    }

    public function transfer(Customer $customer, float $amount) {
        $this->balance -= $amount;
        $customer->account->balance += $amount;
        $this->addTransaction(TransactionType::TRANSFER, -$amount);
        $customer->account->addTransaction(TransactionType::TRANSFER, $amount);
    }

    public function addTransaction(TransactionType $type, float $amount) {
        $this->transactions[] = new Transaction($type, $amount, $this);
    }
}