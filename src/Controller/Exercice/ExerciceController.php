<?php

namespace App\Controller\Exercice;

use App\Model\Exercice\ExerciceModel;
use App\Model\Exercice\ListExerciceModel;
use App\Model\User\UserModel;
use App\Repository\ExerciceRepository;
use App\Repository\UserRepository;
use App\Repository\UserScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExerciceController extends AbstractController
{
    private ExerciceRepository $exerciceRepository;

    private UserScoreRepository $userScoreRepository;
    private ExerciceModel $exerciceModel;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ExerciceRepository         $exerciceRepository,
        UserScoreRepository        $userScoreRepository,
        ExerciceModel              $exerciceModel,
        EntityManagerInterface $entityManager
    )
    {
        $this->exerciceRepository = $exerciceRepository;
        $this->userScoreRepository = $userScoreRepository;
        $this->exerciceModel = $exerciceModel;
        $this->entityManager = $entityManager;
    }

    /**
     * Get All Exercices
     * @View()
     * @Route("/api/exercice", name="api_get_exercices", methods={"GET"})
     * @IsGranted("ROLE_USER", message="userAccessForbidden")
     *
     * @return JsonResponse
     */
    public function getExercices(): JsonResponse
    {
        $exercices = $this->exerciceRepository->findAll();
        $listExerciceModel = new ListExerciceModel($exercices);
        return $this->json($listExerciceModel);

    }

    /**
     * Get 10 random Exercices
     * @View()
     * @Route("/api/exercice/ten/random", name="api_get_random_exercices", methods={"GET"})
     * @IsGranted("ROLE_USER", message="userAccessForbidden")
     * @return JsonResponse
     */
    public function getTenRandomExercices(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $category = $data['category'] ?? null;
        $difficulty = $data['difficulty'] ?? null;
        $exercices = $this->exerciceRepository->findExercices($category, $difficulty);
        shuffle($exercices);
        $exercicesAleatoires = array_slice($exercices, 0, 10);

        $listExerciceModel = new ListExerciceModel($exercicesAleatoires);
        return $this->json($listExerciceModel);

    }
    /**
     * Get Exercice by Id
     * @View()
     * @Route("/api/exercice/{id}", name="api_get_exercices_by_id", methods={"GET"})
     * @IsGranted("ROLE_USER", message="userAccessForbidden")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getExerciceById(int $id): JsonResponse
    {
        $exercice = $this->exerciceRepository->find($id);

        if (!$exercice) {
            throw new NotFoundHttpException("Exercice not found");
        }

        $exerciceModel = new ExerciceModel($exercice);

        return $this->json($exerciceModel);
    }

    /**
     * Check Answer Exercice
     * @View()
     * @Route("/api/exercice/{id}/check", name="api_check_exercice", methods={"POST"})
     * @IsGranted("ROLE_USER", message="userAccessForbidden")
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function checkExercice(int $id, Request $request): JsonResponse

    {
        $exercice = $this->exerciceRepository->find($id);
        if (!$exercice) {
            throw new NotFoundHttpException("Exercice not found");
        }

        $data = json_decode($request->getContent(), true);
        $answer = $data['answer'] ?? null;
        $isCorrect = $exercice->getCorrectAnswer() === $answer;

        return new JsonResponse(['isCorrect' => $isCorrect]);
    }
}
