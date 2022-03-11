<?php

namespace App\Entities;

interface OperationCalculator
{
    public function __construct(Operation $operation);

    public function main() : float;
}
