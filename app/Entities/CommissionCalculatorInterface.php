<?php

namespace App\Entities;

interface CommissionCalculatorInterface
{
    public function __construct(Operation $operation, FreeCommissionUsageStore $freeCommissionUsageStore);

    public function calculate() : float;
}
