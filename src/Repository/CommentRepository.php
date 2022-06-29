<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Result;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
    * @return Comment[] Returns an array of Comment objects
    */
    public function findNextComments(Int $id, Int $limit, Int $offset): array
    {
        /* Get trick next comments */
        return $this->createQueryBuilder('c')
            ->andWhere('c.trick = :id')
            ->andWhere('c.status = true')
            ->setParameter('id', $id)
            ->orderBy('c.createdAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function count($id)
    {
        /* Count comments on a trick */
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->where('t.trick = :trick')
            ->setParameter('trick', $id)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    /**
     * @param int $comment_id
     * @return Result
     * @throws Exception
     */
    public function toggleCommentStatus(int $comment_id): Result
    {
        $conn = $this->getEntityManager()->getConnection();

        /* Toggle the status on a comment */
        $sql = 'UPDATE comment
            SET status = !status
            WHERE id = :id';
        $stmt = $conn->prepare($sql);
        return $stmt->executeQuery(['id' => $comment_id]);
    }

}
