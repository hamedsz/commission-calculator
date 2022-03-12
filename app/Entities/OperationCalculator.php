<?php

namespace App\Entities;

interface OperationCalculator
{
    public function __construct(Operation $operation, FreeCommissionUsageStore $freeCommissionUsageStore);

    public function main() : float;
}
