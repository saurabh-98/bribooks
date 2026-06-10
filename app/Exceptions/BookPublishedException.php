<?php

namespace App\Exceptions;

use Exception;

class BookPublishedException extends Exception
{
    protected $message =
        'Published books are read only.';
}