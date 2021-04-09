<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Product\Entity\Product;
use App\Domain\Product\Value\ProductId;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Repository\ReviewRepository;
use App\Domain\Review\Value\ReviewId;
use App\Domain\User\Entity\User;
use App\Domain\User\Value\UserId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewDoctrineRepository extends ServiceEntityRepository implements ReviewRepository
{
    private EntityManagerInterface $em;

    private Connection $connection;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
        $this->connection = $this->getEntityManager()->getConnection();
        $this->em = $this->getEntityManager();
    }

    public function findOneByGtinAndUser(string $gtin, User $user): ?Review
    {
        $result = $this->createQueryBuilder('rating')
            ->join(Product::class, 'product', 'WITH', 'product.id = rating.productId')
            ->andWhere('product.gtin = :gtin')
            ->andWhere('rating.userId = :userId')
            ->setParameter('gtin', $gtin)
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();

        if ([] === $result) {
            return null;
        }

        return current($result);
    }

    public function nextId(): ReviewId
    {
        return ReviewId::fromInt((int)$this->connection->fetchColumn('SELECT setval(\'review_id_seq\', nextval(\'review_id_seq\'::regclass))'));
    }

    public function saveReview(Review $review): void
    {
        $this->em->persist($review);
        $this->em->flush();
    }

    public function reviewExists(ProductId $productId, UserId $userId): bool
    {
        return null !== $this->findOneBy(['productId' => $productId->toInt(), 'userId' => $userId->toInt()]);
    }

    public function findReview(ReviewId $reviewId): Review
    {
        return $this->find($reviewId->toInt());
    }

    public function findReviews(): array
    {
        return $this->findAll();
    }
}
