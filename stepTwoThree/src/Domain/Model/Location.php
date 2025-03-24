<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Infra\Persistence\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $lat = null;

    #[ORM\Column]
    private ?float $lng = null;

    #[ORM\OneToOne(mappedBy: 'location', cascade: ['persist', 'remove'])]
    private ?Vehicle $vehicle = null;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getLat() : ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat) : static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng() : ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng) : static
    {
        $this->lng = $lng;

        return $this;
    }

    public function getVehicle() : ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle) : static
    {
        // unset the owning side of the relation if necessary
        if (null === $vehicle && null !== $this->vehicle) {
            $this->vehicle->setLocation(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $vehicle && $vehicle->getLocation() !== $this) {
            $vehicle->setLocation($this);
        }

        $this->vehicle = $vehicle;

        return $this;
    }

    public function equals(float $lat, float $lng) : bool
    {
        return $this->lat === $lat && $this->lng === $lng;
    }
}
