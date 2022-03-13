<?php

namespace App\Entities\Operation;

use App\Entities\DataStore\FreeCommissionUsageStore;
use App\Entities\Deposit\DepositOperation;
use App\Entities\Interfaces\OperationCalculator;
use App\Entities\Withdraw\WithdrawOperation;

class OperationTypeDetector
{
    /** @var OperationCalculator */
    private $operationCalculator;
    private $operation;
    private $freeCommissionUsageStore;

    protected $operationTypes = [
        'deposit'  => DepositOperation::class,
        'withdraw' => WithdrawOperation::class
    ];

    public function __construct(Operation $operation, FreeCommissionUsageStore $store)
    {
        $this->operation = $operation;
        $this->freeCommissionUsageStore = $store;
    }

    private function initialize(){
        if (!isset($this->operationTypes[$this->operation->type])){
            throw new \Exception("unexpected operation type!");
        }

        $operationClass = $this->operationTypes[$this->operation->type];

        $this->operationCalculator = new $operationClass($this->operation, $this->freeCommissionUsageStore);
    }

    public function main() : float{
        $this->initialize();
        return $this->operationCalculator->main();
    }
}
