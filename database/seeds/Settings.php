<?php

use Illuminate\Database\Seeder;

class Settings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('settings')->insert([
        	[
	        	'key' 	=> 'company-name',
				'value' => '"Gamota"',
	        ],
	        [
	        	'key' 	=> 'company-email',
				'value' => '"gamota@gamota.com"',
	        ],
	        [
	        	'key' 	=> 'company-phone',
				'value' => '"0123456789"',
	        ],
	        [
	        	'key' 	=> 'company-address',
				'value' => '"Hà Nội, VN"',
	        ],
	        [
	        	'key' 	=> 'home-title',
				'value' => '"Gamota CMS"',
	        ],
	        [
	        	'key' 	=> 'home-description',
				'value' => '"Trang chủ Gamota"',
	        ],
	        [
	        	'key' 	=> 'home-keyword',
				'value' => '"gamota"',
	        ],
	        [
	        	'key' 	=> 'logo',
				'value' => '"http:\/\/localhost\/lar_sg_cms\/public\/gamota_logo.png"',
	        ],
	        [
	        	'key' 	=> 'default-avatar',
				'value' => '"http:\/\/localhost\/lar_sg_cms\/public\/storage\/no-avatar.png"',
	        ],
	        [
	        	'key' 	=> 'default-thumbnail',
				'value' => '"http:\/\/localhost\/lar_sg_cms\/public\/storage\/no-thumbnail.png"',
	        ],
	        [
	        	'key' 	=> 'language',
				'value' => '"vi"',
	        ],
	        [
	        	'key' 	=> 'google-analytics-script',
				'value' => '"google-analytics-script"',
	        ],
	        [
	        	'key' 	=> 'facebook-ads-script',
				'value' => '"facebook-ads-script"',
	        ],
	        [
	        	'key' 	=> 'facebook-fanpage',
				'value' => '"facebook-fanpage"',
	        ],
	        [
	        	'key' 	=> 'facebook-group',
				'value' => '"facebook-group"',
			],
			[
	        	'key' 	=> 'custom_home',
				'value' => '{"title_seo":null,"description_seo":null,"keyword_seo":null,"home_slide":{"slide":["\/uploads\/images\/banner.png","\/uploads\/images\/banner.png","\/uploads\/images\/sdk.png"],"game_id":["1","1","1"]},"home_partner":{"image":["\/uploads\/images\/xiaomi.png","\/uploads\/images\/longtu.png","\/uploads\/images\/o-dazzle.png","\/uploads\/images\/nexon.png","\/uploads\/images\/snail.png","\/uploads\/images\/perfect-world.png","\/uploads\/images\/linekong.png","\/uploads\/images\/dazzle.png"],"link":["#","#","#","#","#","#","#","#"]},"home_service":{"image":null}}',
			],
			[
	        	'key' 	=> 'custom_gamota',
				'value' => '{"title_seo":"seo","description_seo":"1231","keyword_seo":"123","text_content":{"content":{"vi":"11111111111","en":"22222222222","cn":"33333333333333"}},"timeline":{"image":["\/uploads\/images\/sdk.png","\/uploads\/images\/messi.png"],"year":["2013","2014"],"content":{"vi":["vi","1111"],"en":["en","2222"],"cn":["cn","3333"]}},"about":{"image":["\/uploads\/images\/messi.png","\/uploads\/images\/sdk.png","\/uploads\/images\/sdk.png","\/uploads\/images\/messi.png"],"title":{"vi":["1111111111","1231231","23213","123123"],"en":["2222222222222","123123","123213",null],"cn":["3333333331","13123","1312313","1231231"]},"content":{"vi":["1111111111111111111111","\u003Cp\u003Eaaa\u003C\/p\u003E","\u003Cp\u003Ea3\u003C\/p\u003E","\u003Cp\u003Ea4\u003C\/p\u003E"],"en":["223222222222","\u003Cp\u003Ebbbb\u003C\/p\u003E","\u003Cp\u003Eb3\u003C\/p\u003E","\u003Cp\u003Eb4\u003C\/p\u003E"],"cn":["2222223123123","\u003Cp\u003Ecccc\u003C\/p\u003E","\u003Cp\u003Ec3\u003C\/p\u003E","\u003Cp\u003Ec4\u003C\/p\u003E"]}}}',
			],
			[
	        	'key' 	=> 'custom_service',
				'value' => '{"title_seo":"gg","description_seo":"12313","keyword_seo":"123123","text_content":{"content":{"vi":"111","en":"111","cn":"33"}},"about":{"image":["\/uploads\/images\/messi.png","\/uploads\/images\/sdk.png"],"title":{"vi":["aa","1111111"],"en":["bb","222222222"],"cn":["cc","444444444444"]},"content":{"vi":["\u003Cp\u003Ebbb\u003C\/p\u003E","\u003Cp\u003E111111111\u003C\/p\u003E"],"en":["\u003Cp\u003Eccc\u003C\/p\u003E","\u003Cp\u003E333333333\u003C\/p\u003E"],"cn":["\u003Cp\u003Eccc\u003C\/p\u003E","\u003Cp\u003E44444444444\u003C\/p\u003E"]}}}',
			],
			[
	        	'key' 	=> 'custom_contact',
				'value' => '',
			],
			[
	        	'key' 	=> 'custom_games',
				'value' => '',
			],
			[
	        	'key' 	=> 'custom_language',
				'value' => '',
			],
			[
	        	'key' 	=> 'custom_general',
				'value' => '',
			],
			
	    ]);
    }
}