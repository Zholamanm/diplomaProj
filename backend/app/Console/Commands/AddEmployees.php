<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use Faker\Factory as Faker;

class AddEmployees extends Command
{
    // The name and signature of the console command
    protected $signature = 'add:employees';

    // The console command description
    protected $description = 'Add 50 new employees to the Employee table';

    // Execute the console command
    public function handle()
    {
        $faker = Faker::create();

        // Add 50 employee records
        for ($i = 0; $i < 50; $i++) {
            Employee::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'position' => $faker->jobTitle,
                'salary' => $faker->numberBetween(30000, 100000),
            ]);
        }

        $this->info('50 employees have been added successfully!');
    }
}
