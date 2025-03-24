<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Infra\Persistence\FleetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FleetRepository::class)]
class Fleet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fleetId = null;

    /**
     * @var Collection<int, Vehicle>
     */
    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: 'fleet')]
    private Collection $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getFleetId() : ?string
    {
        return $this->fleetId;
    }

    public function setFleetId(string $fleetId) : static
    {
        $this->fleetId = $fleetId;

        return $this;
    }

    public function hasVehicle(Vehicle $vehicle) : bool
    {
        return $this->vehicles->contains($vehicle);
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles() : Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle) : static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->setFleet($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle) : static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getFleet() === $this) {
                $vehicle->setFleet(null);
            }
        }

        return $this;
    }
}
