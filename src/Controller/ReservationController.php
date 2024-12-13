<?php

// src/Controller/ReservationController.php

namespace App\Controller;

use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends AbstractController
{
    /**
     * @Route("/user/reservations", name="reservation_list")
     */
    public function list()
    {
        // Récupérer les réservations de l'utilisateur connecté
        $reservations = $this->getDoctrine()->getRepository(Reservation::class)
            ->findBy(['user' => $this->getUser()]);

        return $this->render('reservation/list.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/user/reservations/create", name="reservation_create")
     */
    public function create(Request $request)
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Réservation créée avec succès !');
            return $this->redirectToRoute('reservation_list');
        }

        return $this->render('reservation/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/reservations/edit/{id}", name="reservation_edit")
     */
    public function edit(Request $request, Reservation $reservation)
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('reservation_list');
        }

        return $this->render('reservation/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/reservations/delete/{id}", name="reservation_delete")
     */
    public function delete(Reservation $reservation)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('reservation_list');
    }
}
