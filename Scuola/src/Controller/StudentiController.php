<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\EnterType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StudentiController extends AbstractController
{
    #[Route('/studenti', name: 'studenti_index')]
    public function index(Request $request, EntityManagerInterface $entityManager, StudentRepository $repository): Response
    {
        $classe = new Student();
        $form = $this->createForm(EnterType::class, $classe);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classe);
            $entityManager->flush();
    
            return $this->redirectToRoute('studenti_index');
        }
    
        $studentis = $repository->findAll();
    
        return $this->render('studenti/index.html.twig', [
            'form' => $form->createView(),
            'studentis' => $studentis,
        ]);
    }
    #[Route('/studenti/delete/{id}', name: 'delete_studenti', methods: ['POST'])]
    public function delete(Student $studenti, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($studenti);
        $entityManager->flush();

        return $this->redirectToRoute('studenti_index');
    }
    public function edit(Student $studenti, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EnterType::class, $studenti);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('studenti_index');
        }

        return $this->render('studenti/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
