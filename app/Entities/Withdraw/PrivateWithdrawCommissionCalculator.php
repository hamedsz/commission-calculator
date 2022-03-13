<?php

namespace App\Entities\Withdraw;

use App\Entities\DataStore\FreeCommissionUsage;
use App\Entities\DataStore\FreeCommissionUsageStore;
use App\Entities\Interfaces\CommissionCalculatorInterface;
use App\Entities\Operation\Operation;
use App\Helpers\Euro;

class PrivateWithdrawCommissionCalculator implements CommissionCalculatorInterface
{
    private $operation;
    private $freeCommissionUsageStore;

    const SUM_ALLOWANCE = 1000;
    const COUNT_ALLOWANCE = 3;

    public function __construct(Operation $operation, FreeCommissionUsageStore $freeCommissionUsageStore)
    {
        $this->operation = $operation;
        $this->freeCommissionUsageStore = $freeCommissionUsageStore;
    }

    private function getSumUsage(){
        return $this->freeCommissionUsageStore
            ->getUserUsageInWeek($this->operation->userID, $this->operation->date)
            ->sum('amount');
    }
    private function getCountUsage(){
        return $this->freeCommissionUsageStore
            ->getUserUsageInWeek($this->operation->userID, $this->operation->date)
            ->count();
    }

    private function isCountOfFreeUsagesMoreThanAllowance(){
        return $this->getCountUsage() > self::COUNT_ALLOWANCE;
    }
    private function isSumOfFreeUsagesMoreThanAllowance(){
        return $this->getSumUsage() >= self::SUM_ALLOWANCE;
    }
    private function isSumOfFreeUsagesAndOperationAmountMoreThanAllowance(){
        return $this->getSumUsage() + $this->getOperationAmountInEuros() <= self::SUM_ALLOWANCE;
    }

    private function getOperationAmountInEuros(){
        return Euro::convert($this->operation->amount, $this->operation->currency);
    }

    private function convertEuroToCurrentCurrency($amount){
        return Euro::convertFromEuroTo($amount, $this->operation->currency);
    }

    private function insertFreeCommissionUsage($amount){
        $usage = new FreeCommissionUsage();
        $usage->id = $this->operation->userID;
        $usage->date = $this->operation->date;
        $usage->amount = $amount;
        $this->freeCommissionUsageStore->insert($usage);
    }

    public function calculate(): float
    {
        if ($this->isCountOfFreeUsagesMoreThanAllowance() || $this->isSumOfFreeUsagesMoreThanAllowance()){
            return round($this->getOperationAmountInEuros() * .003, 2);
        }

        if ($this->isSumOfFreeUsagesAndOperationAmountMoreThanAllowance()){
            $this->insertFreeCommissionUsage(
                $this->getOperationAmountInEuros()
            );

            return 0;
        }
        $sumOfThatCanUseFromFreeUsages = self::SUM_ALLOWANCE - $this->getSumUsage();

        $this->insertFreeCommissionUsage($sumOfThatCanUseFromFreeUsages);

        $mustCalculateCommissionAmount = $this->getOperationAmountInEuros() - $sumOfThatCanUseFromFreeUsages;

        return round($this->convertEuroToCurrentCurrency($mustCalculateCommissionAmount) * .003, 2);
    }
}
