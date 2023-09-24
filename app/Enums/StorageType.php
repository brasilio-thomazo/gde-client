<?php

namespace App\Enums;

enum StorageType: int
{
    case NONE = 0;
    case LOCAL = 1;
    case S3 = 2;
}
