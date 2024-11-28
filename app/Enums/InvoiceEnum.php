<?php
namespace App\Enums;
enum InvoiceEnum {
    case UNPAID;
    case PAID;

    const DEFAULT_STATUS = self::UNPAID;

}
