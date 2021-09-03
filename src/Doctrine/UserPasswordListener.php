<?php

namespace App\Doctrine;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordListener
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function prePersist(User $user): void
    {
        // Hash the user's password
        $user->setPassword($this->encoder->hashPassword($user, $user->getPassword()));
    }
}
