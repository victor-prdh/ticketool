<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class DbUnique extends Constraint
{
    public string $message = 'The value "{{ string }}" is already used and must be unique.';

    public function __construct(
        public string $table, 
        public string $column,  
        string $message = null, 
        array $groups = null, 
        $payload = null
    ) {
        parent::__construct([], $groups, $payload);

        $this->message = $message ?? $this->message;
    }
}
