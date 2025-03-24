<?php

namespace Fulll\Domain\Exception;

class VehicleNotFoundInFleetException extends \Exception
{
    public function __construct(string $message = "Vehicle not found in fleet.")
    {
        parent::__construct($message);
    }
}
