<?php

class BankApp
{
    public BankManager $bankManager;

    private const SEE_ALL_TRANSACTIONS = 1;
    private const DEPOSIT = 2;
    private const WITHDRAW = 3;
    private const TRANSFER = 4;
    private const CUR_BALANCE = 5;
    private const TRANSACTIONS_BY_ALL_USERS = 6;
    private const TRANSACTIONS_BY_SPECIFIC_USERS = 7;
    private const ALL_CUSTOMERS = 8;
    private const EXIT_APP = 9;

    private array $customer_options = [
        self::SEE_ALL_TRANSACTIONS => 'See all transactions',
        self::DEPOSIT => 'Deposit money',
        self::WITHDRAW => 'Withdraw money',
        self::TRANSFER => 'Transfer money to another account',
        self::CUR_BALANCE => 'See current balance',
        self::EXIT_APP => 'Exit'
    ];

    private array $admin_options = [
        self::TRANSACTIONS_BY_ALL_USERS => 'See transactions of all users',
        self::TRANSACTIONS_BY_SPECIFIC_USERS => 'See transactions by specific users',
        self::ALL_CUSTOMERS => 'View all customers',
        self::EXIT_APP => 'Exit'
    ];

    private array $options = ["Register", "Login"];

    public function __construct()
    {
        $this->bankManager = new BankManager(new FileStorage());
    }

    public function run(): void
    {
        foreach ($this->options as $i => $option) {
            echo ($i + 1) . ". {$option} \n";
        }

        $entered_option = (int)readline("Enter your option: ");

        switch($entered_option) {
            case 1: 
                $this->register();
                break;
            case 2: 
                $this->login();
                break;
            default:
                echo "wrong input.\n";
            }
    }

    public function register() {
        $name = readline("Enter your name: ");
        $email = readline("Enter your email: ");
        $password = readline("Enter your password: ");

        $this->bankManager->registerCustomer($name, $email, $password);
    }

    public function login() {
        $email = readline("Enter your email: ");
        $password = readline("Enter your password: ");

        if($this->bankManager->login($email, $password)) {
            $user = $this->bankManager->getUserByEmail($email);
            if($user->getType() === UserType::ADMIN) {
                $this->runAsAdmin();
            }
            else {
                $this->runAsCustomer($user);
            }
        }
        else {
            echo "wrong input.\n";
        }
    }

    public function runAsAdmin() : void {
        while (true) {
            foreach ($this->admin_options as $option => $label) {
                printf("%d. %s\n", $option, $label);
            }

            $choice = intval(readline("Enter your option: "));

            switch ($choice) {
                case self::TRANSACTIONS_BY_ALL_USERS:
                    $this->bankManager->showAllTransactions();
                    break;
                case self::TRANSACTIONS_BY_SPECIFIC_USERS:
                    $email = readline("Enter user email: ");
                    $this->bankManager->showTransactionByUser($email);
                    break;
                case self::ALL_CUSTOMERS:
                    $this->bankManager->showCustomers();
                    break;
                case self::EXIT_APP:
                    return;
                default:
                    echo "Invalid option.\n";
            }
        }
    }

    public function runAsCustomer($user) : void {
        while (true) {
            foreach ($this->customer_options as $option => $label) {
                printf("%d. %s\n", $option, $label);
            }

            $choice = intval(readline("Enter your option: "));
            
            switch ($choice) {
                case self::SEE_ALL_TRANSACTIONS:
                    $user->viewTransactions();
                    break;
                case self::DEPOSIT:
                    $amount = intval(readline("Enter deposit amount: "));
                    $user->account->deposit($amount);
                    $this->bankManager->saveUsers();
                    break;
                case self::WITHDRAW:
                    $amount = intval(readline("Enter withdraw amount: "));
                    $user->account->withdraw($amount);
                    $this->bankManager->saveUsers();
                    break;
                case self::TRANSFER:
                    $amount = intval(readline("Enter transfer amount: "));
                    $email = readline("Enter account email: ");
                    $user->account->transfer($this->bankManager->getUserByEmail($email), $amount);
                    $this->bankManager->saveUsers();
                    break;
                case self::CUR_BALANCE:
                    echo $user->account->getBalance() . "\n";
                    break;
                case self::EXIT_APP:
                    return;
                default:
                    echo "Invalid option.\n";
            }
        }
    }
}