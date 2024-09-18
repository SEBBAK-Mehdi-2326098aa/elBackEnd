<?php

namespace App\Controller\Exercice;

use App\Model\Exercice\ExerciceModel;
use App\Model\Exercice\ListExerciceModel;
use App\Model\User\UserModel;
use App\Repository\ExerciceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExerciceController extends AbstractController
{
    private ExerciceRepository $exerciceRepository;
    private ExerciceModel $exerciceModel;

    private ListExerciceModel $listExerciceModel;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ExerciceRepository         $exerciceRepository,
        ExerciceModel              $exerciceModel,
        EntityManagerInterface $entityManager
    )
    {
        $this->exerciceRepository = $exerciceRepository;
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
//    public function getUserById(int $id): JsonResponse
//    {
//        $user = $this->userRepository->find($id);
//
//        if (!$user) {
//            throw new NotFoundHttpException("User not found");
//        }
//
//        $userModel = new UserModel($user);
//
//        return $this->json($userModel);
//    }
}
