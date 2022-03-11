<?php

namespace App\Entities\Withdraw;

use App\Entities\CommissionCalculatorInterface;
use App\Entities\Operation;

class BusinessWithdrawCommissionCalculator implements CommissionCalculatorInterface
{

    public function __construct(Operation $operation)
    {
    }

    public function calculate(): float
    {
        return 6;
        // TODO: Implement calculate() method.
    }
}
