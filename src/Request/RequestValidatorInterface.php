<?php

namespace App\Request;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface RequestValidatorInterface
{
    /**
     * @param mixed                                              $value       The value to validate
     * @param Constraint|Constraint[]                            $constraints The constraint(s) to validate against
     * @param string|GroupSequence|(string|GroupSequence)[]|null $groups      The validation groups to validate. If none is given, "Default" is assumed
     *
     * @return ConstraintViolationListInterface A list of constraint violations
     *                                          If the list is empty, validation
     *                                          succeeded
     */
    public function validate($value, $constraints = null, $groups = null);
}
