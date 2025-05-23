<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class UpdateOfflineUsers extends Command
{
    protected $signature = 'users:update-offline';
    protected $description = 'Mark users as offline if they havent been active';

    public function handle()
    {
        $threshold = now()->subMinutes(5);

        User::where('is_online', true)
            ->where('last_seen_at', '<', $threshold)
            ->update(['is_online' => false]);

        $this->info('Offline users updated successfully.');
    }
}
