<?php

namespace App\Entities\Deposit;

use App\Entities\CommissionCalculatorInterface;
use App\Entities\FreeCommissionUsageStore;
use App\Entities\Operation;
use App\Entities\OperationCalculator;

class DepositOperation implements OperationCalculator
{
    /** @var CommissionCalculatorInterface */
    private $calculator;
    private $operation;

    public function __construct(Operation $operation, FreeCommissionUsageStore $freeCommissionUsageStore)
    {
        $this->operation = $operation;
    }

    public function initialize(){
        switch (true){
            default:
                $this->calculator = new NormalDepositCommissionCalculator($this->operation);
        }
    }

    public function main() : float{
        $this->initialize();
        return $this->calculator->calculate();
    }
}
