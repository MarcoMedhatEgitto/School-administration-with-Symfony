<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClasseFormType;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classe', name: 'classe_index')]
    public function index(Request $request, EntityManagerInterface $entityManager, ClasseRepository $repository): Response
    {
        $classe = new Classroom();
        $form = $this->createForm(ClasseFormType::class, $classe);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classe);
            $entityManager->flush();
    
            return $this->redirectToRoute('classe_index');
        }
    
        $classes = $repository->findAll();
    
        return $this->render('classe/index.html.twig', [
            'form' => $form->createView(),
            'classes' => $classes,
        ]);
        
    }
    #[Route('/classe/delete/{id}', name: 'delete_classe', methods: ['POST'])]
    public function delete(Classroom $classe, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($classe);
        $entityManager->flush();

        return $this->redirectToRoute('classe_index');
    }
    public function edit(Classroom $classe, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClasseFormType::class, $classe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_index');
        }

        return $this->render('classe/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
