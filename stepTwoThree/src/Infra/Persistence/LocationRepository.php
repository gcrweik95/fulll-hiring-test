<?php

declare(strict_types=1);

namespace App\Infra\Persistence;

use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\LocationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository implements LocationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function findByLatLngVehicle(float $lat, float $lng, Vehicle $vehicle) : ?Location
    {
        $query = $this->createQueryBuilder('l')
            ->andWhere('l.lat = :lat')
            ->andWhere('l.lng = :lng')
            ->setParameter('lat', $lat)
            ->setParameter('lng', $lng)
            ->innerJoin('l.vehicle', 'v')
            ->andWhere('v.id = :id')
            ->setParameter('id', $vehicle->getId())
            ->getQuery();
        /** @var Location|null $location */
        $location = $query->getOneOrNullResult();

        return $location;
    }

    public function save(Location $location) : void
    {
        $this->getEntityManager()->persist($location);
        $this->getEntityManager()->flush();
    }
}
