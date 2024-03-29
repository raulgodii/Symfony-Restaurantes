<?php

namespace App\Repository;

use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categoria>
 *
 * @method Categoria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoria[]    findAll()
 * @method Categoria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }


    public function getCategorias(): array
    {
        $categorias = $this->findAll();
        $categoriasArray = [];
        foreach ($categorias as $categoria) {
            $categoriasArray[] = [
                'id' => $categoria->getId(),
                'nombre' => $categoria->getNombre(),
                'descripcion' => $categoria->getDescripcion(),
            ];
        }
        return $categoriasArray;
    }

    public function addCategoria($nombre, $descripcion): Categoria
    {
        $categoria = new Categoria();
        $categoria->setNombre($nombre);
        $categoria->setDescripcion($descripcion);

        $this->getEntityManager()->persist($categoria);
        $this->getEntityManager()->flush();

        return $categoria;
    }

    public function updateCategoria($id, $nombre, $descripcion): Categoria
    {
        $categoria = $this->find($id);
        $categoria->setNombre($nombre);
        $categoria->setDescripcion($descripcion);

        $this->getEntityManager()->flush();

        return $categoria;
    }

    public function deleteCategoria(int $id): void
    {
        $categoria = $this->find($id);

        $this->getEntityManager()->remove($categoria);
        $this->getEntityManager()->flush();
    }



//    /**
//     * @return Categoria[] Returns an array of Categoria objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Categoria
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
