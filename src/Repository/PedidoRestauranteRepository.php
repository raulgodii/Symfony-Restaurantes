<?php

namespace App\Repository;

use App\Entity\PedidoRestaurante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PedidoRestaurante>
 *
 * @method PedidoRestaurante|null find($id, $lockMode = null, $lockVersion = null)
 * @method PedidoRestaurante|null findOneBy(array $criteria, array $orderBy = null)
 * @method PedidoRestaurante[]    findAll()
 * @method PedidoRestaurante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidoRestauranteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PedidoRestaurante::class);
    }

//    /**
//     * @return PedidoRestaurante[] Returns an array of PedidoRestaurante objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PedidoRestaurante
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
