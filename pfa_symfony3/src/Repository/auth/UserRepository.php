<?php

namespace App\Repository\auth;

use App\Entity\user\Utilisateur;
use App\DTO\auth\LoginResponseDTO;
use App\DTO\auth\UserResponseDTO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }
    public function login(string $email, string $password, UserPasswordHasherInterface $passwordHasher): ?LoginResponseDTO
    {
        $user = $this->findOneBy(['email' => $email]);
        if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
            return null;
        }
        return new LoginResponseDTO(
            true,
            '', 
            $user->getId(),
            $user->getEmail(),
            $user->getRole()
        );
    }
    public function getUserDTO(int $id): ?UserResponseDTO
    {
        $user = $this->find($id);
        if (!$user) {
            return null;
        }
        return new UserResponseDTO(
            $user->getId(),
            $user->getEmail()
        );
    }
}

