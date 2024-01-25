<?php

namespace App\Api\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Api\State\UserRegistrationProcessor;
use App\Doctrine\Enum\TableEnum;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AppAssert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

#[ApiResource(
    normalizationContext: ['groups' => ['register:read']],
    denormalizationContext: ['groups' => ['register:write']],
)]
#[Post(
    uriTemplate: '/user-register',
    processor: UserRegistrationProcessor::class,
)]
class UserRegistration
{
    #[ApiProperty(identifier: true)]
    public ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[AppAssert\DbUnique(
        table: TableEnum::USER,
        column: 'email'
    )]
    #[Groups(['register:read', 'register:write'])]
    public ?string $email = null;

    #[Assert\PasswordStrength([
        'minScore' => PasswordStrength::STRENGTH_WEAK
    ])]
    #[Groups(['register:write'])]
    public ?string $plainPassword = null;

    #[Assert\NotBlank]
    #[Groups(['register:read', 'register:write'])]
    public ?string $firstname = null;

    #[Assert\NotBlank]
    #[Groups(['register:read', 'register:write'])]
    public ?string $lastname = null;

    #[Groups(['register:read'])]
    public ?int $userId = null;
}
