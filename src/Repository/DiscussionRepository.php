<?php

namespace App\Repository;

use App\Entity\Discussion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Discussion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discussion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discussion[]    findAll()
 * @method Discussion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscussionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discussion::class);
    }

    public function findTop3()
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT u.pseudo, u.avatar, COUNT(d.id) AS nombre_de_discussion
                FROM discussion d, user u
                WHERE d.user_id = u.id
                GROUP BY d.user_id
                ORDER BY nombre_de_discussion DESC
                LIMIT 3";

        $statement = $connection->prepare($sql);

        $statement->executeStatement();

        return $statement->fetchAllAssociative();
    }
}
