<?php 

namespace App\Service\User;

use App\Api\Resource\UserRegistration;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class Register
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher
    ){
    }

    /**
     * Create an user from registration API
     */
    public function fromApi(UserRegistration $userData): User
    {
        $user = new User();

        $user->setFirstname($userData->firstname);
        $user->setLastname($userData->lastname);
        $user->setEmail($userData->email);

        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user, $userData->plainPassword
            )
        );

        $user->eraseCredentials();

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
