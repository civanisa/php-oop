<?php
session_start();

//Veri Tabanı Bilgileri
$GLOBALS['config'] = array(
	'mysql'   => array(
		'host' => '127.0.0.1',
		'kulanici_adi' => 'root',
		'sifre' => 'root1234',
		'db' => 'php_oop'
	),
	'session' => array(
		'session_ismi' => 'kullanici',
		'token_ismi' => 'token'
	)
);

spl_autoload_register(function ($class){
	require_once  'class/' .$class . '.php';
});

require_once 'fonksiyon/fonksiyon.php';
