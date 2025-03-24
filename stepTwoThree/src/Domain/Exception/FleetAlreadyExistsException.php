<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class FleetAlreadyExistsException extends \Exception
{
    public function __construct(string $message = 'Fleet already exists.')
    {
        parent::__construct($message);
    }
}
