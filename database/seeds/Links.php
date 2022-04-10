<?php

use Illuminate\Database\Seeder;

class Links extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('links')->insert([
        	[
	        	'title' 	=> 'Link Googleplay',
				'slug' 		=> 'link-googleplay',
				'url' 		=> 'https://nt.onelink.me/6vtG/homepage',
				'target' 	=> '_blank',
				'status' 	=> '1',
				'author_id' => '1'
	        ],
	        [
	        	'title' 	=> 'Link Apk',
				'slug' 		=> 'link-apk',
				'url' 		=> 'https://nt.onelink.me/6vtG/homepage',
				'target' 	=> '_blank',
				'status' 	=> '1',
				'author_id' => '1'
	        ],
	        [
	        	'title' 	=> 'Link Ios',
				'slug' 		=> 'link-ios',
				'url' 		=> 'https://nt.onelink.me/6vtG/homepage',
				'target' 	=> '_blank',
				'status' 	=> '1',
				'author_id' => '1'
	        ]
	    ]);
    }
}
