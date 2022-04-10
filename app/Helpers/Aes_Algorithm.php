<?php
namespace App\Helpers;

class Aes_Algorithm
{
	public static function AES_256_CBC_Encrypt($data, $privateKey){
		require_once  app_path("random_compat/lib/random.php");
		if(!is_string($data)){
			throw new Exception("[AES_Encrypt] data input must be a tring!");
		}
		if(!function_exists('openssl_encrypt')){
			throw new Exception("Function openssl_encrypt could not be found!");
		}
		$iv = substr(bin2hex(random_bytes(32)), 0, 16);
		$aes_code = openssl_encrypt($data, 'AES-256-CBC', $privateKey, 0, $iv);
		return base64_encode($iv.$aes_code);
	}

	public static function AES_256_CBC_Decrypt($data, $privateKey){
		require_once app_path("random_compat/lib/random.php");
		if(!is_string($data)){
			throw new Exception("[AES_Decrypt] data input must be a tring!");
		}
		if(!function_exists('openssl_decrypt')){
			throw new Exception("Function openssl_decrypt could not be found!");
		}
		$input = base64_decode($data);
		$iv = substr($input, 0, 16);

		if(strlen($iv)!=16){
			return false;
		}

		$sourceData = substr($input, 16);
		$aes_code = openssl_decrypt($sourceData, 'AES-256-CBC', $privateKey, 0, $iv);
		return $aes_code;
	}

}