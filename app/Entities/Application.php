<?php

namespace App\Entities;

use App\Entities\CSV\CsvReader;

class Application
{
    private $csvFileName;
    private $store;
    private $csvReader;
    private $operations;

    public static function commission($csvFileName){
        $object = new Application($csvFileName);
        return $object->main();
    }

    public function __construct($csvFileName)
    {
        $this->csvFileName = $csvFileName;
        $this->store = new FreeCommissionUsageStore();
        $this->csvReader = new CsvReader();
    }

    private function readFromCsv(){
        $this->operations = $this->csvReader->read($this->csvFileName);
    }

    private function calculateCommission(){
        foreach ($this->operations as $operation){
            $calc = new \App\Entities\CommissionCalculator($operation, $this->store);

            $operation->commission = $calc->main();
        }
    }

    public function main(){
        $this->readFromCsv();
        $this->calculateCommission();

        return $this->operations;
    }
}
