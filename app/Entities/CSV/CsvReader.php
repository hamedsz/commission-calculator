<?php

namespace App\Entities\CSV;

use App\Entities\Operation\Operation;
use Illuminate\Support\Facades\Storage;

class CsvReader
{
    private function getFile($filename){
        return Storage::get($filename);
    }
    private function getLines($file){
       return collect(explode(PHP_EOL, $file));
    }
    private function filterEmptyLines($lines){
        return $lines->filter(function ($item){
            return !empty($item);
        });
    }
    private function convertToOperation($lines){
        return $lines->map(function ($item){
            $line = explode(',', $item);

            $operation = new Operation();
            $operation->date = $line[0];
            $operation->userID = $line[1];
            $operation->userType = $line[2];
            $operation->type = $line[3];
            $operation->amount = $line[4];
            $operation->currency = $line[5];

            return $operation;
        });
    }

    public function read($filename){
        $file = $this->getFile($filename);
        $lines = $this->getLines($file);
        $lines = $this->filterEmptyLines($lines);
        return $this->convertToOperation($lines);
    }
}
