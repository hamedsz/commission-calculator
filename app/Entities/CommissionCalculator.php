<?php

namespace App\Entities;

use App\Entities\Deposit\DepositOperation;
use App\Entities\Withdraw\WithdrawOperation;

class CommissionCalculator
{
    /** @var OperationCalculator */
    private $operationCalculator;
    private $operation;

    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }

    private function initialize(){
        switch ($this->operation->type){
            case "deposit":
                $this->operationCalculator = new DepositOperation($this->operation);
                break;
            case "withdraw":
                $this->operationCalculator = new WithdrawOperation($this->operation);
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
