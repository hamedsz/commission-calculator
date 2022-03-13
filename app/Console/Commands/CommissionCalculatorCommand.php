<?php

namespace App\Console\Commands;

use App\Entities\Application;
use App\Entities\CSV\CsvReader;
use App\Entities\FreeCommissionUsage;
use App\Entities\FreeCommissionUsageStore;
use App\Entities\Operation;
use App\Helpers\Euro;
use Illuminate\Console\Command;

class CommissionCalculatorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commission:calculate {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $operations = Application::commission($this->argument('file'));

        foreach ($operations as $operation){
            $this->info($operation->commission);
        }

        return 0;
    }
}
