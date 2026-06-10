<?php

namespace App\Exceptions;

use Exception;

class BookDeleteException extends Exception
{
    protected $message =
        'Published books cannot be deleted.';
}