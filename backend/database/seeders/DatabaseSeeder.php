<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeDetail;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed Departments
        Department::factory()->count(10)->create();

        // Use chunking for performance (avoid memory issues)
        $chunkSize = 1000;
        $total = 100000;

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        for ($i = 0; $i < $total / $chunkSize; $i++) {
            $employees = Employee::factory()
                ->count($chunkSize)
                ->create();

            $details = $employees->map(function ($employee) {
                return EmployeeDetail::factory()
                    ->make(['employee_id' => $employee->id])
                    ->toArray();
            });

            // Insert details in bulk
            EmployeeDetail::insert($details->all());

            $this->command->info("Inserted " . ($i + 1) * $chunkSize . " employees...");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
