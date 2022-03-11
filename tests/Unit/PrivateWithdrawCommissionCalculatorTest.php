<?php

namespace Tests\Unit;

use App\Entities\Operation;
use App\Entities\Withdraw\BusinessWithdrawCommissionCalculator;
use PHPUnit\Framework\TestCase;

class PrivateWithdrawCommissionCalculatorTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_is_returns_correct_data()
    {
        for ($i=0; $i < 10; $i++){
            $operation = new Operation();
            $operation->amount = rand(1 , 1000000);

            $obj = new BusinessWithdrawCommissionCalculator($operation);

            $this->assertTrue($obj->calculate() == ($operation->amount * 0.005));
        }
    }
}
