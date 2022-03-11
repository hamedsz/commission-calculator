<?php

namespace Tests\Unit;

use App\Entities\Operation;
use App\Entities\Withdraw\BusinessWithdrawCommissionCalculator;
use App\Entities\Withdraw\PrivateWithdrawCommissionCalculator;
use PHPUnit\Framework\TestCase;

class PrivateWithdrawCommissionCalculatorTest extends TestCase
{

    private function getData(){

        $data = [];

        $item = new Operation();
        $item->amount = 3000000;
        $item->date = "2016-02-19";
        $item->currency = "JPY";
        $data[] = [
            'operation' => $item,
            'result'    => 8612
        ];

        $item = new Operation();
        $item->amount = 300.00;
        $item->date = "2016-02-15";
        $item->currency = "EUR";
        $data[] = [
            'operation' => $item,
            'result'    => 0.00
        ];

        $item = new Operation();
        $item->amount = 1000.00;
        $item->date = "2016-01-10";
        $item->currency = "EUR";
        $data[] = [
            'operation' => $item,
            'result'    => 0.00
        ];

        $item = new Operation();
        $item->amount = 100.00;
        $item->date = "2016-01-10";
        $item->currency = "EUR";
        $data[] = [
            'operation' => $item,
            'result'    => 3.00
        ];

        return $data;
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_is_returns_correct_data()
    {
        $data = $this->getData();

        foreach ($data as $item){
            $obj = new PrivateWithdrawCommissionCalculator($item['operation']);

            $this->assertTrue($obj->calculate() === $item['result']);
        }
    }
}
