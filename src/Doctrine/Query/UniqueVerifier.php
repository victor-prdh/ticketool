<?php

namespace App\Doctrine\Query;

use Doctrine\ORM\EntityManagerInterface;

final readonly class UniqueVerifier
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    /**
     * Check if a given value exist in a specific column of table
     */
    public function valueAlreadyExist(
        string $table, 
        string $column, 
        string|int|float $value
    ): bool 
    {
        $query = <<<SQL
        SELECT $column FROM $table WHERE $column = ?;
        SQL;

        $result = $this->em->getConnection()
                ->executeQuery($query, [$value])
                ->fetchOne();

        return !(false === $result);
    }
}
