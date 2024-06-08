<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('user_details')]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Groups('user_details')]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups('user_details')]
    private ?int $age = null;

    #[ORM\Column(length: 1)]
    #[Groups('user_details')]
    #[Assert\Choice(['F', 'M'])]
    private ?string $sex = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups('user_details')]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $birthday = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    #[Groups('user_details')]
    private ?\DateTimeImmutable $created_at;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'update')]
    #[Groups('user_details')]
    private ?\DateTimeImmutable $updated_at;

    #[ORM\Column(length: 30)]
    #[Assert\Email]
    #[Assert\NotBlank]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank]
    private ?string $phone = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function calculateAge(): void
    {
        $today = new DateTimeImmutable;
        $this->age = $today->diff($this->birthday)->y;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getBirthday(): ?\DateTimeImmutable
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeImmutable $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }
}
