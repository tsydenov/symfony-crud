<?php

namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserEditor
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private ValidatorInterface $validator
    ) {
    }

    public function edit(int $id, array $data): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $user = $this->userRepository->find($id);

        try {
            foreach ($data as $key => $value) {
                $propertyAccessor->setValue($user, $key, $value);
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return ['errors' => $errorsString];
        }

        $this->entityManager->flush();
        return ["user {$user->getId()} is updated successfully"];
    }
}
