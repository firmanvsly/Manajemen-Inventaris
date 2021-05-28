<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'nama_role' => 'Owner',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'nama_role' => 'Manager',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'nama_role' => 'Staff',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
