<?php

// src/Repository/ReservationRepository.php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * Vérifie si une plage horaire est disponible
     */
    public function isTimeSlotAvailable(\DateTimeInterface $date, string $timeSlot): bool
    {
        $query = $this->createQueryBuilder('r')
            ->andWhere('r.date = :date')
            ->andWhere('r.timeSlot = :timeSlot')
            ->setParameter('date', $date)
            ->setParameter('timeSlot', $timeSlot)
            ->getQuery();

        $result = $query->getOneOrNullResult();

        return $result === null;  // Retourne vrai si aucune réservation n'existe
    }
}
