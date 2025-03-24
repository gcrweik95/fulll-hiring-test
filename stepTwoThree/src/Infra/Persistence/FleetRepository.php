<?php

declare(strict_types=1);

namespace App\Infra\Persistence;

use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fleet>
 */
class FleetRepository extends ServiceEntityRepository implements FleetRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fleet::class);
    }

    public function findById(string $id) : ?Fleet
    {
        $query = $this->createQueryBuilder('f')
            ->where('f.fleetId = :fleetId')
            ->setParameter('fleetId', $id)
            ->getQuery();
        /** @var Fleet|null $fleet */
        $fleet = $query->getOneOrNullResult();

        return $fleet;
    }

    public function save(Fleet $fleet) : void
    {
        $this->getEntityManager()->persist($fleet);
        $this->getEntityManager()->flush();
    }
}
