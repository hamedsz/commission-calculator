<?php

namespace App\Entities\Withdraw;

use App\Entities\CommissionCalculatorInterface;
use App\Entities\FreeCommissionUsageStore;
use App\Entities\Operation;
use App\Entities\OperationCalculator;

class WithdrawOperation implements OperationCalculator
{
    /** @var CommissionCalculatorInterface */
    private $calculator;
    private $operation;
    private $freeCommissionUsageStore;

    public function __construct(Operation $operation, FreeCommissionUsageStore $freeCommissionUsageStore)
    {
        $this->operation = $operation;
        $this->freeCommissionUsageStore = $freeCommissionUsageStore;
    }

    public function initialize(){
        switch ($this->operation->userType){
            case "private":
                $this->calculator = new PrivateWithdrawCommissionCalculator($this->operation, $this->freeCommissionUsageStore);
                break;
            case "business":
                $this->calculator = new BusinessWithdrawCommissionCalculator($this->operation, $this->freeCommissionUsageStore);
                break;
            default:
                throw new \Exception("unexpected user type! supported types: business, private");
        }
    }

    public function main() : float{
        $this->initialize();
        return $this->calculator->calculate();
    }
}
