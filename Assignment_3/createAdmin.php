<?php

require_once 'Storage.php';
require_once 'User.php';
require_once 'UserType.php';
require_once 'BankApp.php';
require_once 'Admin.php';
require_once 'BankAccount.php';
require_once 'BankManager.php';
require_once 'Customer.php';
require_once 'FileStorage.php';
require_once 'Transaction.php';
require_once 'TransactionType.php';

$bankManager = new BankManager(new FileStorage());

printf("Register Admin\n");

$name = readline("Enter your name: ");
$email = readline("Enter your email: ");
$password = readline("Enter your password: ");

$bankManager->registerAdmin($name, $email, $password);