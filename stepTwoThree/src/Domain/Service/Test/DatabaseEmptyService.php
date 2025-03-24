<?php

declare(strict_types=1);

namespace App\Domain\Service\Test;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseEmptyService
{
    private EntityManagerInterface $entityManager;
    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->connection = $this->entityManager->getConnection();
    }

    public function emptyDB() : void
    {
        $this->connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0');

        $metadatas = $this->entityManager->getMetadataFactory()->getAllMetadata();

        foreach ($metadatas as $metadata) {
            $tableName = $metadata->table['name'];
            $this->connection->executeQuery("TRUNCATE TABLE $tableName");
        }

        $this->connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1');
    }
}
