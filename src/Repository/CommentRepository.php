<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findTop3()
    {
        return $this->createQueryBuilder('c')
            ->select("u.pseudo, u.avatar, COUNT(c.id) AS nombre_de_commentaires")
            ->join('c.user', 'u')
            ->groupBy('c.user')
            ->orderBy('nombre_de_commentaires', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}
