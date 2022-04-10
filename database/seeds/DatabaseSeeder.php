<?php

use Doctrine\Inflector\Language;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //$this->call(Links::class);
        $this->call(Settings::class);
        $this->call(UserSeeder::class);
        $this->call(GameCateSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(GameSeeder::class);
    }
}