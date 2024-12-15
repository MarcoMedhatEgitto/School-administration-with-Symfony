<?php

namespace App\Controller;

use App\Entity\Attivita;
use App\Form\AttivitaFormType;
use App\Repository\AttivitaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttivitaController extends AbstractController
{
    #[Route('/attivita', name: 'attivita_index')]
    public function index(Request $request, EntityManagerInterface $entityManager, AttivitaRepository $repository): Response
    {
        $attivita = new Attivita();
        $form = $this->createForm(AttivitaFormType::class, $attivita);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($attivita);
            $entityManager->flush();
    
            return $this->redirectToRoute('attivita_index');
        }
    
        $attivitas = $repository->findAll();
    
        return $this->render('attivita/index.html.twig', [
            'form' => $form->createView(),
            'attivitas' => $attivitas,
        ]);
    }
    #[Route('/attivita/delete/{id}', name: 'delete_attivita', methods: ['POST'])]
    public function delete(Attivita $attivita, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($attivita);
        $entityManager->flush();

        return $this->redirectToRoute('attivita_index');
    }
    public function edit(Attivita $attivita, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AttivitaFormType::class, $attivita);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('attivita_index');
        }

        return $this->render('attivita/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
