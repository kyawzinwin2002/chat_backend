<?php

namespace App\Enums;

enum Status : string
{
    case Pending = "pending";
    case Deciding = "deciding";
    case Friend = "friend";
}
