<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\UserCreator;
use App\Service\UserDeleter;
use App\Service\UserEditor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private SerializerInterface $serializer
    ) {
    }

    #[Route('/users/new', methods: ['POST'])]
    public function createUser(
        Request $request,
        UserCreator $userCreater,
    ): JsonResponse {
        $data = $request->toArray();
        $jsonResponse = [];

        if (!array_is_list($data)) {
            $data = [$data];
        }
        foreach ($data as $userData) {
            $jsonResponse[] = $userCreater->create($userData);
        }

        return new JsonResponse($jsonResponse);
    }

    #[Route('/users', methods: ['GET'])]
    public function users(): JsonResponse
    {
        $users = $this->userRepository->findAll();

        return new JsonResponse($this->serializer->serialize($users, 'json', [
            AbstractObjectNormalizer::GROUPS => ['user_details', 'user_emails', 'user_phones']
        ]), json: true);
    }

    #[Route('users/{id}', methods: ['GET'])]
    public function show(
        int $id,
    ): JsonResponse {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return new JsonResponse("No user found for id {$id}", 400);
        }

        return new JsonResponse($this->serializer->serialize($user, 'json', [
            AbstractObjectNormalizer::GROUPS => ['user_details', 'user_emails', 'user_phones']
        ]), json: true);
    }

    #[Route('users/{id}', methods: ['PATCH'])]
    public function edit(
        int $id,
        Request $request,
        UserEditor $userEditor
    ): JsonResponse {
        $data = $request->toArray();
        $userEditorResult = $userEditor->edit($id, $data);

        return new JsonResponse($userEditorResult);
    }

    #[Route('users/{id}', methods: ['DELETE'])]
    public function delete(
        int $id,
        UserDeleter $userDeleter
    ): JsonResponse {
        $userDeleterResult = $userDeleter->delete($id);

        return new JsonResponse($userDeleterResult);
    }
}
