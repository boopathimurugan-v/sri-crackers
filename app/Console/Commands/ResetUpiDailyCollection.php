<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UpiAccount;

class ResetUpiDailyCollection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upi:reset-daily-collection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically reset daily collection to zero for all UPI accounts at 12:00 AM';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = UpiAccount::query()->update(['current_collection' => 0.00]);

        $this->info("Successfully reset daily collection to zero for {$count} UPI accounts.");

        return Command::SUCCESS;
    }
}
