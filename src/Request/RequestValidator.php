<?php

namespace App\Request;

use App\Exceptions\RequestViolationsException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestValidator implements RequestValidatorInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    /**
     * @throws RequestViolationsException
     */
    public function validate($value, $constraints = null, $groups = null): void
    {
        $violations = $this->validator->validate($value, $constraints, $groups);

        if (count($violations) > 0) {
            throw new RequestViolationsException($violations);
        }
    }
}
