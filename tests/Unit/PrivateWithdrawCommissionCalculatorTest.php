<?php

namespace Tests\Unit;

use App\Entities\FreeCommissionUsageStore;
use App\Entities\Operation;
use App\Entities\Withdraw\BusinessWithdrawCommissionCalculator;
use App\Entities\Withdraw\PrivateWithdrawCommissionCalculator;
use App\Helpers\Euro;
use Tests\TestCase;

class PrivateWithdrawCommissionCalculatorTest extends TestCase
{

    private function getData(){

        $data = [];

        $item = new Operation();
        $item->amount = 3000000;
        $item->date = "2016-02-19";
        $item->currency = "JPY";
        $item->userID = 1;
        $data[] = [
            'operation'     => $item,
            'result'        => 8607.39,
            'currency_rate' => 130.869977
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
        $store = new FreeCommissionUsageStore();
        $data = $this->getData();

        foreach ($data as $item){
            $obj = new PrivateWithdrawCommissionCalculator($item['operation'], $store);

            //this code converts results to date currency rate because maybe they changed
            $amount = $item['result'] * Euro::getRate($item['operation']->currency) / $item['currency_rate'];
            $amount = round($amount, 2);

            $this->assertEquals($amount, $obj->calculate());
        }
    }
}
