<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function loadUserByIdentifier($identifier)
    {
        return $this->repository->findOneBy(['email' => $identifier]);
    }

    public function loadUserByUsername(string $username)
    {
        return $this->repository->findOneBy(['email' => $username]);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->repository->findOneBy(['email' => $user->getUserIdentifier()]);
    }

    public function supportsClass(string $class)
    {
        return true;
    }
}
