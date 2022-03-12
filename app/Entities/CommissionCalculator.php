<?php

namespace App\Entities;

use App\Entities\Deposit\DepositOperation;
use App\Entities\Withdraw\WithdrawOperation;

class CommissionCalculator
{
    /** @var OperationCalculator */
    private $operationCalculator;
    private $operation;
    private $freeCommissionUsageStore;

    public function __construct(Operation $operation, FreeCommissionUsageStore $store)
    {
        $this->operation = $operation;
        $this->freeCommissionUsageStore = $store;
    }

    private function initialize(){
        switch ($this->operation->type){
            case "deposit":
                $this->operationCalculator = new DepositOperation($this->operation, $this->freeCommissionUsageStore);
                break;
            case "withdraw":
                $this->operationCalculator = new WithdrawOperation($this->operation, $this->freeCommissionUsageStore);
                break;
            default:
                throw new \Exception("unexpected operation type! supported types: deposit, withdraw");
        }
    }

    public function main() : float{
        $this->initialize();
        return $this->operationCalculator->main();
    }
}
