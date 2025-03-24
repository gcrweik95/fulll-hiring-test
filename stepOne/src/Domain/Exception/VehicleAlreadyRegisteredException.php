<?php

namespace Fulll\Domain\Exception;

class VehicleAlreadyRegisteredException extends \Exception
{
    public function __construct(string $message = "Vehicle already registered in this fleet.")
    {
        parent::__construct($message);
    }
}
