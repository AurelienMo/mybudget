<?php

namespace MyBudget\Infrastructure\Validation;

use MyBudget\Domain\Shared\Ports\Output\DataValidationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService implements DataValidationInterface
{
    public function __construct(private ValidatorInterface $validator) {}

    public function validate(object $object): array|null
    {
        $constraintList = $this->validator->validate($object);
        if ($constraintList->count() > 0) {
            $errors = [];
            foreach ($constraintList as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }

            return $errors;
        }

        return null;
    }
}
