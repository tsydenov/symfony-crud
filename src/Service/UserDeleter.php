<?php

namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserDeleter
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private ValidatorInterface $validator
    ) {
    }

    public function delete(int $id): array
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return ["No user found for id {$id}"];
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return ["Successfully deleted user with id {$id}"];
    }
}
