<?php

namespace App\Enums;

enum TransactionEnum: string
{
    case PENDING = 'PENDING';
    case FAILED = 'FAILED';
    case SUCCESS = 'SUCCESS';

}
