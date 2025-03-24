<?php

namespace Fulll\Domain\Model;

class Location
{
    private string $id;
    private float $lat;
    private float $lng;
    private ?Vehicle $vehicle = null;

    public function __construct(float $lat, float $lng)
    {
        $this->id = uniqid('loc_');
        $this->lat = $lat;
        $this->lng = $lng;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function getLng()
    {
        return $this->lng;
    }

    public function equals(Location $location): bool
    {
        return $this->lat === $location->getLat() && $this->lng === $location->getLng();
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
    }
}
