<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class VehicleAlreadyRegisteredException extends \Exception
{
    public function __construct(string $message = 'Vehicle already registered in this fleet.')
    {
        parent::__construct($message);
    }
}
