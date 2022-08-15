<?php

namespace MyBudget\Domain\Shared\Ports\Output;

interface DataValidationInterface
{
    public function validate(object $object): array|null;
}
