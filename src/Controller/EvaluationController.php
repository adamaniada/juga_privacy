<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Form\EvaluationType;
use App\Repository\EvaluationRepository;
use App\Repository\QuestionRepository; // Ajoutez ce repository
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evaluation')]
class EvaluationController extends AbstractController
{
    #[Route('/', name: 'evaluation_index', methods: ['GET'])]
    public function list(EvaluationRepository $evaluationRepository): Response
    {
        return $this->render('evaluation/index.html.twig', [
            'evaluations' => $evaluationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'evaluation_new', methods: ['GET', 'POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        QuestionRepository $questionRepository
    ): Response
    {
        $evaluation = new Evaluation();
        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);
    
        // Récupérer les questions regroupées par catégorie
        $questionsByCategory = $questionRepository->findQuestionsGroupedByCategory();
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les réponses
            $answers = $request->request->get('answers', []);

            if (is_array($answers) || is_object($answers)) {
                foreach ($answers as $questionId => $data) {
                    foreach ($data as $category => $answer) {
                        // Traitez la réponse
                    }
                }
            } else {
                // Gérer le cas où $answers n'est pas un tableau ou un objet
            }
    
            $entityManager->persist($evaluation);
            $entityManager->flush();
    
            $this->addFlash('success', 'Evaluation created successfully!');
    
            return $this->redirectToRoute('evaluation_index');
        }
    
        return $this->render('evaluation/new.html.twig', [
            'evaluation' => $evaluation,
            'form' => $form->createView(),
            'questionsByCategory' => $questionsByCategory,
        ]);
    }
    

    #[Route('/{id}', name: 'evaluation_show', methods: ['GET'])]
    public function show(Evaluation $evaluation): Response
    {
        return $this->render('evaluation/show.html.twig', [
            'evaluation' => $evaluation,
        ]);
    }

    #[Route('/{id}', name: 'evaluation_delete', methods: ['POST'])]
    public function delete(Request $request, Evaluation $evaluation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evaluation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evaluation);
            $entityManager->flush();

            $this->addFlash('success', 'Evaluation deleted successfully!');
        }

        return $this->redirectToRoute('evaluation_index');
    }
}
