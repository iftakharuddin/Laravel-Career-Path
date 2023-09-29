<?php

declare(strict_types=1);

enum TransactionType
{
    case DEPOSIT;
    case WITHDRAW;
    case TRANSFER;
}