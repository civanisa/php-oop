<?php


class Token
{
	public static function oluştur(){
		return Session::yerleştir(Config::getir('session/token_ismi'),md5(uniqid()));
	}

	public static function kontrol($token){
		$tokenİsmi = Config::getir('session/token_ismi');
		if (Session::varsa($tokenİsmi) && $token == Session::getir($tokenİsmi)){
			Session::sil($tokenİsmi);
			return true;
		}
		return false;
	}
}