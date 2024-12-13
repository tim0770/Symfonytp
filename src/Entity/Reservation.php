<?php

// src/Entity/Reservation.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "La date est obligatoire.")]
    #[Assert\GreaterThan('now', message: "La réservation doit être faite au moins 24 heures à l'avance.")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: "La plage horaire est obligatoire.")]
    private ?string $timeSlot = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'événement est obligatoire.")]
    private ?string $eventName = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Getters et Setters...
}
