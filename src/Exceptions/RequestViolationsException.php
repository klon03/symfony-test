<?php

namespace App\Exceptions;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestViolationsException extends \Exception
{
    private ConstraintViolationListInterface $violations;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
        parent::__construct('exception.badRequest', 400);
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
