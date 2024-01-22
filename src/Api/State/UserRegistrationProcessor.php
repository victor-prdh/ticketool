<?php

namespace App\Api\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\UserRegistration;
use App\Service\User\Register;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class UserRegistrationProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly Register $register
    ) {
    }

    public function process(
        mixed $data, 
        Operation $operation, 
        array $uriVariables = [], 
        array $context = []
    ): UserRegistration
    {
        if(!($data instanceof UserRegistration)) {
            throw new UnprocessableEntityHttpException(
                'That\'s  not a valid UserRegistration object');
        }

        $user = $this->register->fromApi($data);

        $data->id = time();
        $data->plainPassword = null;
        $data->userId = $user->getId();

        return $data;
    }
}
