<?php

namespace App\Entities\Deposit;

use App\Entities\DataStore\FreeCommissionUsageStore;
use App\Entities\Interfaces\CommissionCalculatorInterface;
use App\Entities\Operation\Operation;

class NormalDepositCommissionCalculator implements CommissionCalculatorInterface
{
    private $operation;

    public function __construct(Operation $operation, FreeCommissionUsageStore $freeCommissionUsageStore)
    {
        $this->operation = $operation;
    }

    public function calculate() : float
    {
        return round($this->operation->amount * 0.0003 , 2);
    }
}
