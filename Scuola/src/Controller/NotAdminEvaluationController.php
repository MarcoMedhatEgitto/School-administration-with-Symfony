<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Evaluation;
use App\Form\NotAdminEvaluationType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NotAdminEvaluationController extends AbstractController
{
    #[Route('/evaluation/{activity}', name: 'evaluation')]
    public function index(
        Request                  $request,
        Activity                 $activity,
        EntityManagerInterface   $entityManager,
        StudentRepository        $studentRepository): Response
    {
        $evaluation = new Evaluation();
        $form = $this->createForm(NotAdminEvaluationType::class, $evaluation, [
            'activity' => $activity,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($evaluation);
            $entityManager->flush();

            return $this->redirectToRoute('evaluation');
        }

        return $this->render('not_admin_evaluation/index.html.twig', [
            'form' => $form->createView(),
            'students' => $studentRepository->findAll(),
        ]);
    }

}
