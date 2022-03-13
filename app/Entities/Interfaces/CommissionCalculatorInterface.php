<?php

namespace App\Entities\Interfaces;

use App\Entities\DataStore\FreeCommissionUsageStore;
use App\Entities\Operation\Operation;

interface CommissionCalculatorInterface
{
    public function __construct(Operation $operation, FreeCommissionUsageStore $freeCommissionUsageStore);

    public function calculate() : float;
}
