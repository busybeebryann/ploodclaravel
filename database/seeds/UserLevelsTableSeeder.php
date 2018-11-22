<?php

use Illuminate\Database\Seeder;

class UserLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_levels')->insert([
        	'user_level_name' => 'basic',
        ]);

        DB::table('user_levels')->insert([
        	'user_level_name' => 'supervisor 1',
        ]);

        DB::table('user_levels')->insert([
        	'user_level_name' => 'supervisor 2',
        ]);

        DB::table('user_levels')->insert([
        	'user_level_name' => 'admin',
        ]);
    }
}
