<?php

use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('games')->insert([
        	[
                'thumbnail' 	=> '/uploads/images/sdk.png',
                'icon' 	=> '/uploads/images/logo-game.png',
                'link' => 'https://game.gamota.com/game/tam-quoc-liet-truyen-175',
                'game_id' => '1111111',
                'qr_code' => '/uploads/images/qr-code-game.png',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
               
            ],
           
            
        ]);

        DB::table('game_language')->insert([
        	[
                'game_id' 	=> 1,
                'language_id' 	=> 1,
                'name' => 'Tam quốc liệt truyện',
                'description' => 'tiếng việt',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
               
            ],
            [
                'game_id' 	=> 1,
                'language_id' 	=> 2,
                'name' => 'Tam quốc liệt truyện ENG',
                'description' => 'tiếng anh',
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
               
            ],
            [
                'game_id' 	=> 1,
                'language_id' 	=> 3,
                'name' => 'Tam quốc liệt truyện CHINA',
                'description' => 'tiếng trung',
               
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
               
            ],
           
            
        ]);
    }
}