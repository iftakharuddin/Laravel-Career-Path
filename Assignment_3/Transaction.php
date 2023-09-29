<?php

class Transaction 
{
    public TransactionType $type;
    public float $amount;
    public BankAccount $account;

    public function __construct($type, $amount, $account)
    {
        $this->type = $type;
        $this->amount = $amount;
        $this->account = $account;
    }
}