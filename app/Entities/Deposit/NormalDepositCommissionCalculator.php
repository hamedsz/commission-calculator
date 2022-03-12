<?php

namespace App\Entities\Deposit;

use App\Entities\CommissionCalculatorInterface;
use App\Entities\FreeCommissionUsageStore;
use App\Entities\Operation;

class NormalDepositCommissionCalculator implements CommissionCalculatorInterface
{
    private $operation;

    public function __construct(Operation $operation, FreeCommissionUsageStore $freeCommissionUsageStore)
    {
        $this->operation = $operation;
    }

    public function calculate() : float
    {
        return $this->operation->amount * 0.0003; //TODO
    }
}
