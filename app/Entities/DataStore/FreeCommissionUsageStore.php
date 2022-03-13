<?php

namespace App\Entities\DataStore;

use Illuminate\Support\Carbon;

class FreeCommissionUsageStore
{
    private $usages;

    public function __construct()
    {
        $this->usages = collect();
    }

    public function insert(FreeCommissionUsage $freeCommissionUsage) : void{
        $this->usages->add($freeCommissionUsage);
    }

    public function getUserUsages($id){
        return $this->usages->filter(function (FreeCommissionUsage $item) use ($id){
            return $item->id == $id;
        });
    }

    public function getUserUsageInWeek($id, $date){
        $targetCarbonDate = Carbon::make($date);

        return $this->getUserUsages($id)->filter(function (FreeCommissionUsage $item) use ($targetCarbonDate){
            $itemCarbonDate = Carbon::make($item->date);

            return ($targetCarbonDate->diffInWeeks($itemCarbonDate) == 0);
        });
    }
}
