<?php

declare(strict_types=1);

namespace App\Infra\Persistence;

use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 */
class VehicleRepository extends ServiceEntityRepository implements VehicleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findByLicensePlate(string $licensePlate) : ?Vehicle
    {
        /** @var Vehicle|null $vehicle */
        $vehicle = $this->findOneBy(['licensePlate' => $licensePlate]);

        return $vehicle;
    }

    public function save(Vehicle $vehicle) : void
    {
        $this->getEntityManager()->persist($vehicle);
        $this->getEntityManager()->flush();
    }
}
