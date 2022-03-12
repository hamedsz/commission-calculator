<?php

namespace App\Console\Commands;

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
    protected $signature = 'commission:calculate';

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
        $store = new FreeCommissionUsageStore();

        $operation = new Operation();
        $operation->type = "withdraw";
        $operation->userType = "private";
        $operation->userID = 5;
        $operation->date = "2016-02-19";
        $operation->amount = 3000000;
        $operation->currency = "JPY";
        $calc = new \App\Entities\CommissionCalculator($operation, $store);

        $commission = $calc->main();

        $this->info($commission);

        return 0;
    }
}
