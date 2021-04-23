<?php

namespace App\Repository;

use App\Entity\Hotel;
use App\Entity\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
 * @method Hotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hotel::class);
    }
    public function findRecentHotel(int $limit = null)
    {
        return $this->findBy([], ['id' => 'DESC'], $limit);
    }


    // /**
    //  * recupere des hotel promo
     //  * @return Hotel[] Returns an array of Hotel objects
    //  */

   
    public function findPromoHotel(): array
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.promotion = TRUE')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * recupere des hotel en fonction d'une recherche
     //  * @return Hotel[] Returns an array of Hotel objects
    //  */
    public function findSearch(SearchData $search)
    {

        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.vols', 'c');
            // ->groupBy('c');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('c.nom_ville_arrive LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }
        if (!empty($search->lieuDepart)) {
            $query = $query
                ->andWhere('c.nom_aeroport_depart LIKE :lieuDepart')
                ->setParameter('lieuDepart', "%{$search->lieuDepart}%");
        }

        if (!empty($search->min)) {
            $query = $query
                ->andWhere('p.prix >= :min')
                ->setParameter('min', $search->min);
        }

        if (!empty($search->max)) {
            $query = $query
                ->andWhere('p.prix <= :max')
                ->setParameter('max', $search->max);
        }

        if (!empty($search->affaire)) {
            $query = $query
                ->andWhere('c.voyage_affaire = 1');
        }

        if (!empty($search->economie)) {
            $query = $query
                ->andWhere('c.voyage_affaire = 0');
        }

        if (!empty($search->promotion)) {
            $query = $query
                ->andWhere('p.promotion = 1');
        }

        if (!empty($search->pays)) {
            $query = $query
                ->andWhere('c.pays LIKE :pays')
                ->setParameter('pays', "%{$search->pays}%");
        }

        if (!empty($search->depart)) {
            $query = $query
                ->andWhere('c.date_debut_sejour = :depart')
                ->setParameter('depart', $search->depart);
        }

        if (!empty($search->retour)) {
            $query = $query
                ->andWhere('c.date_fin_sejour = :retour')
                ->setParameter('retour', $search->retour);
        }    
        return $query->getQuery()->getResult();
    }

  
        // if (!empty($search->vols)) {
        //     $query = $query
        //         ->andWhere('c.id IN (:vols)')
        //         // ->andWhere('c.pays LIKE :vols')
        //         // ->groupBy('c')
        //         // ->distinct('c')
        //         ->setParameter('vols', $search->vols);
        // }
        
    // /**
    //  * @return Hotel[] Returns an array of Hotel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hotel
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
