<?php

namespace Tests\Unit;

use App\Entities\Deposit\NormalDepositCommissionCalculator;
use App\Entities\Operation;
use PHPUnit\Framework\TestCase;

class NormalDepositCommissionCalculatorTest extends TestCase
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

            $obj = new NormalDepositCommissionCalculator($operation);

            $this->assertTrue($obj->calculate() == ($operation->amount * 0.0003));
        }
    }

    public function test_handles_zero_amount()
    {
        $operation = new Operation();
        $operation->amount = 0;

        $obj = new NormalDepositCommissionCalculator($operation);

        $this->assertEquals(0, $obj->calculate());
    }

    public function test_handles_null_amount(){
        $operation = new Operation();

        $obj = new NormalDepositCommissionCalculator($operation);

        $this->assertEquals(0, $obj->calculate());
    }
}
