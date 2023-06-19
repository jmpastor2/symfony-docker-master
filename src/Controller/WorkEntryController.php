<?php

namespace App\Controller;

use App\Entity\WorkEntry;
use App\Repository\WorkEntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkEntryController extends AbstractController
{
   

    /**
 * @Route("/work-entries", name="work_entry_create", methods={"POST"})
 */
public function createWorkEntry(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
{
    $data = json_decode($request->getContent(), true);

    // Validar los datos recibidos
    $constraints = new Assert\Collection([
        'start_date' => [new Assert\NotBlank(), new Assert\DateTime()],
        'end_date' => [new Assert\Optional(new Assert\DateTime())],
    ]);

    $violations = $validator->validate($data, $constraints);

    if (count($violations) > 0) {
        // Si hay violaciones de validación, devuelve los mensajes de error
        $errorMessages = [];

        foreach ($violations as $violation) {
            $errorMessages[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
        }

        return new JsonResponse(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
    }

    // Procesar los datos y crear una nueva instancia de WorkEntry
    $workEntry = new WorkEntry();
    $workEntry->setStartDate(new \DateTime($data['start_date']));
    $workEntry->setEndDate($data['end_date'] ? new \DateTime($data['end_date']) : null);
    // Establecer otros campos de WorkEntry según tus necesidades

    // Guardar el nuevo fichaje en la base de datos
    $entityManager->persist($workEntry);
    $entityManager->flush();

    return new JsonResponse(['message' => 'Work entry created'], Response::HTTP_CREATED);
}

/**
 * @Route("/work-entries/{id}", name="work_entry_update", methods={"PUT"})
 */
public function updateWorkEntry(Request $request, EntityManagerInterface $entityManager, WorkEntry $workEntry, ValidatorInterface $validator): Response
{
    $data = json_decode($request->getContent(), true);

    // Validar los datos recibidos
    $constraints = new Assert\Collection([
        'start_date' => [new Assert\NotBlank(), new Assert\DateTime()],
        'end_date' => [new Assert\Optional(new Assert\DateTime())],
        // Agrega más validaciones según tus requisitos para los demás campos
    ]);

    $violations = $validator->validate($data, $constraints);

    if (count($violations) > 0) {
        // Si hay violaciones de validación, devuelve los mensajes de error
        $errorMessages = [];

        foreach ($violations as $violation) {
            $errorMessages[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
        }

        return new JsonResponse(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
    }

    // Procesar los datos y actualizar los campos de WorkEntry según los datos recibidos
    $workEntry->setStartDate(new \DateTime($data['start_date']));
    $workEntry->setEndDate($data['end_date'] ? new \DateTime($data['end_date']) : null);
    // Actualizar otros campos de WorkEntry según tus necesidades

    // Guardar los cambios en la base de datos
    $entityManager->flush();

    return new JsonResponse(['message' => 'Work entry updated'], Response::HTTP_OK);
}


    /**
     * @Route("/work-entries/{id}", name="delete_work_entry", methods={"DELETE"})
     */
    public function deleteWorkEntry(EntityManagerInterface $entityManager, WorkEntry $workEntry): Response
    {
        // Establecer la fecha de borrado
        $workEntry->setDeletedAt(new \DateTime());

        // Guardar los cambios en la base de datos
        $entityManager->flush();

        return new JsonResponse(['message' => 'Work entry deleted'], Response::HTTP_OK);
    }

    /**
     * @Route("/work-entries/{id}", name="get_work_entry", methods={"GET"})
     */
    public function getWorkEntry(WorkEntry $workEntry): JsonResponse
    {
        // Devolver los detalles del fichaje
        return new JsonResponse($workEntry);
    }

    /**
     * @Route("/work-entries/user/{userId}", name="get_work_entries_by_user", methods={"GET"})
     */
    public function getWorkEntriesByUser(WorkEntryRepository $workEntryRepository, int $userId): JsonResponse
    {
        // Obtener todos los fichajes del usuario con el ID proporcionado
        $workEntries = $workEntryRepository->findBy(['userId' => $userId]);

        // Devolver la lista de fichajes del usuario
        return new JsonResponse($workEntries);
    }
}
