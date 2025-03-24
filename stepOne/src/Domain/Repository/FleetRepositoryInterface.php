<?php

namespace Fulll\Domain\Repository;

use Fulll\Domain\Model\Fleet;

interface FleetRepositoryInterface
{
    public function findById(string $id): ?Fleet;

    public function save(Fleet $fleet): void;
}
