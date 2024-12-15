<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use App\Repository\EvaluationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecondPageController extends AbstractController
{
    #[Route('/second/page', name: 'app_second_page')]
    public function index(EvaluationRepository $evaluationRepository,
                          ActivityRepository $activityRepository): Response
    {
        $evaluations = $evaluationRepository->findAll();
        $activities = $activityRepository->findAll();

        return $this->render('second_page/index.html.twig',[
            'evaluations' => $evaluations,
            'activities' => $activities,
        ]);
    }
}
