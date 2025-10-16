<?php

namespace App\Contracts;

interface NotifierInterface
{
    public function notify(string $message, string $type): void;
}
