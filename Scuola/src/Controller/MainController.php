<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use App\Repository\EvaluationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_page')]
    public function homepage(
        EvaluationRepository $evaluationRepository,
        ActivityRepository $activityRepository): Response
    {
        $evaluations = $evaluationRepository->findAll();
        $activities = $activityRepository->findAll();

        return $this->render('main/homepage.html.twig',[
            'evaluations' => $evaluations,
            'activities' => $activities,
        ]);
    }

}