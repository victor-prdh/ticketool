<?php 

namespace App\Service\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class Register
{
    public function __construct(
        private EntityManagerInterface $em,
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $passwordHasher
    ){
    }

    /**
     * Create an user from registration API
     * 
     * @throws \Exception if user is not valid
     */
    public function fromApi(array $userData): User
    {
        $user = new User();

        $user->setFirstname($userData['firstname'] ?? '');
        $user->setLastname($userData['lastname'] ?? '');
        $user->setPlainPassword($userData['password'] ?? '');
        $user->setEmail($userData['email'] ?? '');

        if(true !== $userValidation = $this->validate($user)) {
            // @todo enhance this
            throw new \Exception($userValidation);
        }

        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user, $user->getPlainPassword()
            )
        );

        $user->eraseCredentials();

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    private function validate(User $user): mixed 
    {
        $validationResult = $this->validator->validate($user);

        if(0 === count($validationResult)) return true;

        return $validationResult;
    }
}
