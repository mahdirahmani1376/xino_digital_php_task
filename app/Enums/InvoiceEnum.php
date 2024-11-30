<?php
namespace App\Enums;
enum InvoiceEnum: string {
    case UNPAID = 'unpaid';
    case PAID = 'paid';

    const DEFAULT_STATUS = self::UNPAID;

}
