<?php

namespace App\Entities\Withdraw;


use App\Entities\DataStore\FreeCommissionUsageStore;
use App\Entities\Interfaces\CommissionCalculatorInterface;
use App\Entities\Interfaces\OperationCalculator;
use App\Entities\Operation\Operation;

class WithdrawOperation implements OperationCalculator
{
    /** @var CommissionCalculatorInterface */
    private $calculator;
    private $operation;
    private $freeCommissionUsageStore;


    protected $userTypes = [
        'private'  => PrivateWithdrawCommissionCalculator::class,
        'business' => BusinessWithdrawCommissionCalculator::class
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
