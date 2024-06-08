<?php

namespace App\Service;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserCreator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
        private DataFieldsEmptyChecker $dataChecker,
    ) {
    }

    public function create(array $data): array
    {
        $validated = $this->dataChecker->check($data);
        if (!empty($validated)) {
            return $validated;
        }

        $user = new User;
        $user->setName($data['name']);
        $user->setSex($data['sex']);
        $user->setBirthday(new DateTimeImmutable($data['birthday']));
        $user->setEmail($data['email']);
        $user->setPhone($data['phone']);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return ['errors' => $errorsString];
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return ["created user {$user->getName()} with id {$user->getId()}"];
    }
}
