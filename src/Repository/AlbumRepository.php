<?php

namespace App\Repository;

use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    public function findWithTracksAndSongs(int $id)
    {
        // Création d'un constructeur de requêtes pour l'entité concernée
        $queryBuilder = $this->createQueryBuilder('a');

        // Construction de la requête
        $queryBuilder
            // Jointure et sélection des track
            ->join('a.tracks', 't')->addSelect('t')
            // Jointure et sélection de chaque song
            ->join('t.song', 's')->addSelect('s')
            // Restriction à l'identifiant d'album cherché
            ->where('a.id = :id')
            ->setParameter('id', $id);

        // Retourner un résultat unique après construction de la requête
        return $queryBuilder->getQuery()->getSingleResult();
    }

    // /**
    //  * @return Album[] Returns an array of Album objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Album
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
