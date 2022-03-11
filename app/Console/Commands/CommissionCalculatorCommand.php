<?php

namespace App\Console\Commands;

use App\Entities\Operation;
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
        $operation = new Operation();
        $operation->type = "withdraw";
        $operation->userType = "private";
        $calc = new \App\Entities\CommissionCalculator($operation);

        $commission = $calc->main();

        $this->info($commission);

        return 0;
    }
}
