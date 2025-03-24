<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class VehicleAlreadyParkedAtLocationException extends \Exception
{
    public function __construct(string $message = 'Vehicle already parked in this location.')
    {
        parent::__construct($message);
    }
}
