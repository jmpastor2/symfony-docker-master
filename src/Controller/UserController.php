<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $entityManager;
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/users", name="create_user", methods={"POST"})
     */
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validar los datos recibidos
        $this->validateUserData($data);

        // Crear un nuevo usuario
        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);

        // Guardar el usuario en la base de datos
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Devolver una respuesta JSON
        return new JsonResponse(['message' => 'User created'], 201);
    }

    /**
     * @Route("/users/{id}", name="update_user", methods={"PUT"})
     */
    public function updateUser(Request $request, int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        // Validar los datos recibidos
        $this->validateUserData($data);

        // Actualizar el usuario
        $user->setName($data['name']);
        $user->setEmail($data['email']);

        // Guardar los cambios en la base de datos
        $this->entityManager->flush();

        // Devolver una respuesta JSON
        return new JsonResponse(['message' => 'User updated']);
    }

    /**
     * @Route("/users/{id}", name="delete_user", methods={"DELETE"})
     */
    public function deleteUser(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        // Establecer deletedAt en la fecha actual
        $user->setDeletedAt(new \DateTime());

        // Guardar los cambios en la base de datos
        $this->entityManager->flush();

        // Devolver una respuesta JSON
        return new JsonResponse(['message' => 'User deleted']);
    }

    /**
     * @Route("/users", name="get_all_users", methods={"GET"})
     */
    public function getAllUsers(): JsonResponse
    {
        // Obtener todos los usuarios activos (no eliminados)
        $users = $this->userRepository->findBy(['deletedAt' => null]);

        // Crear un array con los datos de cada usuario
        $usersData = [];
        foreach ($users as $user) {
            $usersData[] = $this->getUserData($user);
        }

        // Devolver una respuesta JSON
        return new JsonResponse(['users' => $usersData]);
    }

    private function validateUserData(array $data): void
    {
        $requiredFields = ['name', 'email'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                throw new \InvalidArgumentException("The field '$field' is required.");
            }
        }
    }

    private function getUserData(User $user): array
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'createdAt' => $user->getCreatedAt(),
            'updatedAt' => $user->getUpdatedAt(),
        ];
    }
}
