<?php

namespace App\Controller\User;

use App\Controller\Core\ApiController;
use App\Entity\User;
use App\Model\User\UserModel;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    private UserRepository $userRepository;
    private UserModel $userModel;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserRepository $userRepository,
        UserModel $userModel,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->userModel = $userModel;
        $this->entityManager = $entityManager;
    }

    /**
     * Get User identified by {id}.
     * @View()
     * @Route("/api/user/{id}", name="api_get_user", methods={"GET"})
     * @IsGranted("ROLE_USER", message="userAccessForbidden")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getUserById(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new NotFoundHttpException("User not found");
        }

        $userModel = new UserModel($user);

        // Retourne la réponse au format JSON
        return $this->json($userModel);
    }

    /**
     * Create a new User.
     * @View()
     * @Rest\Post("/api/user/create", name="create_user")
     * @IsGranted("ROLE_USER", message="userAccessForbidden")
     *
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * Create a new User.
     * @View()
     * @Rest\Post("/api/user/create", name="create_user")
     * @IsGranted("ROLE_USER", message="userAccessForbidden")
     *
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * Create a new User.
     * @View()
     * @Rest\Post("/api/user/create", name="create_user")
     * @IsGranted("ROLE_USER", message="userAccessForbidden")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'] ?? null;
        $lastname = $data['lastname'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $civility = $data['civility'] ?? null;

        $user = new User();
        $user->setName($name);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setCivility($civility);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $userModel = new UserModel($user);

        return $this->json($userModel);
    }

    /**
     * Check user credentials.
     * @View()
     * @Rest\Post("/api/user/check/login", name="api_login")*
     * @param Request $request
     * @return JsonResponse
     */
    public function checkCredentials(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            return $this->json(['message' => 'Invalid Email']);
        }
        if ($user->getPassword() !== $password) {
            return $this->json(['message' => 'Invalid credentials']);
        }

        return $this->json($user);
    }

    /**
     * Update User level by {id}.
     * @View()
     * @Rest\Put("/api/user/{id}/update/level", name="api_change_level")
     * @IsGranted("ROLE_USER", message="userAccessForbidden")
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */

    public function updateUserLevel(int $id, Request $request): JsonResponse {
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new NotFoundHttpException("User not found");
        }
        $data = json_decode($request->getContent(), true);
        $level = $data['level'] ?? null;

        if ($level <= $user->getLevel()) {
            return $this->json(['message' => 'User level is higher']);
        }
        $user->setLevel($level);
        $this->entityManager->flush();
        $userModel = new UserModel($user);
        return $this->json($userModel);
    }
}
