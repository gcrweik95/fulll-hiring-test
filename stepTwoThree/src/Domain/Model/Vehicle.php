<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Infra\Persistence\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $licensePlate = null;

    #[ORM\OneToOne(inversedBy: 'vehicle', cascade: ['persist', 'remove'])]
    private ?Location $location = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?Fleet $fleet = null;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getLicensePlate() : ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(string $licensePlate) : static
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    public function getLocation() : ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location) : static
    {
        $this->location = $location;

        return $this;
    }

    public function getFleet() : ?Fleet
    {
        return $this->fleet;
    }

    public function setFleet(?Fleet $fleet) : static
    {
        $this->fleet = $fleet;

        return $this;
    }
}
