<?php

namespace Tests\Unit;

use App\Entities\Operation;
use App\Entities\Withdraw\BusinessWithdrawCommissionCalculator;
use PHPUnit\Framework\TestCase;

class BusinessWithdrawCommissionCalculatorTest extends TestCase
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

    public function test_handles_zero_amount()
    {
        $operation = new Operation();
        $operation->amount = 0;

        $obj = new BusinessWithdrawCommissionCalculator($operation);

        $this->assertEquals(0, $obj->calculate());
    }

    public function test_handles_null_amount(){
        $operation = new Operation();

        $obj = new BusinessWithdrawCommissionCalculator($operation);

        $this->assertEquals(0, $obj->calculate());
    }
}
