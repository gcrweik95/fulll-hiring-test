<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class VehicleNotFoundInFleetException extends \Exception
{
    public function __construct(string $message = 'Vehicle not found in fleet.')
    {
        parent::__construct($message);
    }
}
