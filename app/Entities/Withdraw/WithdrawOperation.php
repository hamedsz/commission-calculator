<?php

namespace App\Entities\Withdraw;

use App\Entities\CommissionCalculatorInterface;
use App\Entities\Operation;
use App\Entities\OperationCalculator;

class WithdrawOperation implements OperationCalculator
{
    /** @var CommissionCalculatorInterface */
    private $calculator;
    private $operation;

    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }

    public function initialize(){
        switch ($this->operation->userType){
            case "private":
                $this->calculator = new PrivateWithdrawCommissionCalculator($this->operation);
                break;
            case "business":
                $this->calculator = new BusinessWithdrawCommissionCalculator($this->operation);
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
