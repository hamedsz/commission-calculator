<?php

namespace App\Entities\Deposit;

use App\Entities\Interfaces\CommissionCalculatorInterface;
use App\Entities\DataStore\FreeCommissionUsageStore;
use App\Entities\Operation\Operation;
use App\Entities\Interfaces\OperationCalculator;

class DepositOperation implements OperationCalculator
{
    /** @var CommissionCalculatorInterface */
    private $calculator;
    private $operation;
    private $freeCommissionUsageStore;

    protected $userTypes = [
        'private'  => NormalDepositCommissionCalculator::class,
        'business' => NormalDepositCommissionCalculator::class
    ];

    public function __construct(Operation $operation, FreeCommissionUsageStore $freeCommissionUsageStore)
    {
        $this->operation = $operation;
        $this->freeCommissionUsageStore = $freeCommissionUsageStore;
    }

    public function initialize(){
        if (!isset($this->userTypes[$this->operation->userType])){
            throw new \Exception("unexpected user type!");
        }

        $operationClass = $this->userTypes[$this->operation->userType];

        $this->calculator = new $operationClass($this->operation, $this->freeCommissionUsageStore);
    }

    public function main() : float{
        $this->initialize();
        return $this->calculator->calculate();
    }
}
