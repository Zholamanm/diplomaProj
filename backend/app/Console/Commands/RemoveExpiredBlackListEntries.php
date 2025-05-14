<?php

namespace App\Console\Commands;

use App\Models\BlackList;
use Illuminate\Console\Command;

class RemoveExpiredBlackListEntries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blacklist:remove-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove expired entries from the BlackList table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredBlacklist = BlackList::whereDate('expire_date', now())->get();

        foreach ($expiredBlacklist as $entry) {
            $entry->delete();
            $this->info("Deleted BlackList entry for user ID: {$entry->user_id}");
        }

        if ($expiredBlacklist->isEmpty()) {
            $this->info('No expired blacklist entries to remove.');
        }
    }
}
