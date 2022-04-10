<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
        	[
	        	'name' 	=> 'Super Amin',
				'email' 		=> 'admin@gamota.com',
				'password' 		=> bcrypt('123123'),
				'status' 	=> '0',
				'role_id' 	=> '1',
                'api_token' => 'mLhlvom8YkipsAq88WGpYTJ9D2cECKylq1OUE5DQO8c48zBeBOxWHxN7HHnU',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        DB::table('roles')->insert([
        	[
	        	'name' 	=> 'Super Amin',
				
                'type' => '*',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}