<?php

namespace App\Controller;

use App\Entity\Attivita;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\EvaluationModel;
use App\Form\ValutazioneFormType;
use App\Repository\AttivitaRepository;
use App\Repository\StudentRepository;
use App\Repository\ValutazioneRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ValutazioneController extends AbstractController
{
    #[Route('/valutazione', name: 'valutazione_index')]
    public function index(Request $request, EntityManagerInterface $entityManager, ValutazioneRepository $repository, StudentRepository $sturepo, AttivitaRepository $attirepo): Response
    {
        $valutazione=new EvaluationModel();
        $form = $this->createForm(ValutazioneFormType::class, $valutazione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($valutazione);
            $entityManager->flush();
    
            return $this->redirectToRoute('valutazione_index');
        }
        $valutaziones = $repository->findAll();
        $studentis = $sturepo->findAll();
        $attivitas = $attirepo->findAll();
        return $this->render('valutazione/index.html.twig', [
            'form' => $form->createView(),
            'valutaziones' => $valutaziones,
            'studentis' => $studentis,
            'attivitas' => $attivitas,
        ]);
    }
#[Route('/valutazione/{id}', name: 'valutazione_show')]
public function getAttivitaDate(Attivita $attivita): JsonResponse
{
    return new JsonResponse([
        'dataDiInizio' => $attivita->getDataDiInizio()->format('Y-m-d'),
    ]);
}
}
