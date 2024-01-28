<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Group;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Group::factory()->create([
            'name'=>'group 1',
        ]);
        Group::factory()->create([
            'name'=>'group 2',
        ]);


         \App\Models\User::factory(25)->create([
             'group_id'=>1
         ]);
        \App\Models\User::factory(25)->create([
            'group_id'=>2
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
