<?php

namespace App\Enums;

enum UserRole: string
{
    case AUTHOR = 'author';

    case REVIEWER = 'reviewer';

    case ADMIN = 'admin';
}