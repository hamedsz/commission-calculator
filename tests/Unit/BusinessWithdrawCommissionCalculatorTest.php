<?php

namespace Tests\Unit;

use App\Entities\DataStore\FreeCommissionUsageStore;
use App\Entities\Operation\Operation;
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
        $store = new FreeCommissionUsageStore();

        for ($i=0; $i < 10; $i++){
            $operation = new Operation();
            $operation->amount = rand(1 , 1000000);

            $obj = new BusinessWithdrawCommissionCalculator($operation, $store);

            $this->assertTrue($obj->calculate() == (round($operation->amount * 0.005, 2)));
        }
    }

    public function test_handles_zero_amount()
    {
        $store = new FreeCommissionUsageStore();
        $operation = new Operation();
        $operation->amount = 0;

        $obj = new BusinessWithdrawCommissionCalculator($operation, $store);

        $this->assertEquals(0, $obj->calculate());
    }

    public function test_handles_null_amount(){
        $store = new FreeCommissionUsageStore();
        $operation = new Operation();

        $obj = new BusinessWithdrawCommissionCalculator($operation, $store);

        $this->assertEquals(0, $obj->calculate());
    }
}
