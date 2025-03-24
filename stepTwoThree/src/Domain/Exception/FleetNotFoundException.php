<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class FleetNotFoundException extends \Exception
{
    public function __construct(string $message = 'Fleet not found.')
    {
        parent::__construct($message);
    }
}
