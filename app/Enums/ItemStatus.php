<?php

namespace App\Enums;

enum ItemStatus: string
{
    case Available = 'available';
    case Rented = 'rented';
    case UnderMaintenance = 'under_maintenance';
}