<?php

namespace App\Enums;

enum DocumentFlagType: int
{
    case NONE = 0;
    case IMPORTANT = 1;
    case REVISE = 2;
}
