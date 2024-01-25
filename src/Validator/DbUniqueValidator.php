<?php

namespace App\Validator;

use App\Doctrine\Query\UniqueVerifier;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class DbUniqueValidator extends ConstraintValidator
{
    public function __construct(
        private readonly UniqueVerifier $uniqueVerifier
    ){
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof DbUnique) {
            throw new UnexpectedTypeException($constraint, DbUnique::class);
        }
        
        if (false === $this->uniqueVerifier->valueAlreadyExist(
            $constraint->table, $constraint->column, $value
        )) {
            return;
        }
        
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}