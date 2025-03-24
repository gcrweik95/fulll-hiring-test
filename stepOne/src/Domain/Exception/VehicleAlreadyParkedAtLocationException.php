<?php

namespace Fulll\Domain\Exception;

class VehicleAlreadyParkedAtLocationException extends \Exception
{
    public function __construct(string $message = "Vehicle already parked in this location.")
    {
        parent::__construct($message);
    }
}
