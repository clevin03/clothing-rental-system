<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Reserved = 'reserved';
    case Active = 'active';
    case Returned = 'returned';
    case Cancelled = 'cancelled';
}