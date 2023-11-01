<?php

namespace App\Enums;

enum CustomerTableStatus : string {
    case Available = 'available';
    case Occupied = 'occupied';
    case Closed = 'closed';

}