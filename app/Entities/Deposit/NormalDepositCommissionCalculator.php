<?php

namespace App\Entities\Deposit;

use App\Entities\CommissionCalculatorInterface;
use App\Entities\Operation;

class NormalDepositCommissionCalculator implements CommissionCalculatorInterface
{
    private $operation;

    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }

    public function calculate() : float
    {
        return 22; //TODO
    }
}
