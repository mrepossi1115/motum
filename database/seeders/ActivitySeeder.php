<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('activities')->insert([
            ['activity_id' => 1, 'name_activity' => 'CrossFit', 'created_at' => now(), 'updated_at' => now()],
            ['activity_id' => 2, 'name_activity' => 'Yoga', 'created_at' => now(), 'updated_at' => now()],
            ['activity_id' => 3, 'name_activity' => 'Fútbol', 'created_at' => now(), 'updated_at' => now()],
            ['activity_id' => 4, 'name_activity' => 'Running', 'created_at' => now(), 'updated_at' => now()],
            ['activity_id' => 5, 'name_activity' => 'Entrenamiento Funcional', 'created_at' => now(), 'updated_at' => now()],
            ['activity_id' => 6, 'name_activity' => 'Zumba', 'created_at' => now(), 'updated_at' => now()],
            ['activity_id' => 7, 'name_activity' => 'Calistenia', 'created_at' => now(), 'updated_at' => now()],
            ['activity_id' => 8, 'name_activity' => 'Basquet', 'created_at' => now(), 'updated_at' => now()],
            ['activity_id' => 9, 'name_activity' => 'Ciclismo', 'created_at' => now(), 'updated_at' => now()],
            ['activity_id' => 10, 'name_activity' => 'Fútbol femenino', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
    }
}
