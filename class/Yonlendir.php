<?php


class Yonlendir
{
	public static function yonlen($konum = null){
		if ($konum){
			if (is_numeric($konum)){
				switch ($konum){
					case 404:
						header('HTTP/1.0 404 Not Found');
						include('include/404.php');
						exit();
						break;
					default:
						break;
				}
			}
			else{
				header('locatation:' . $konum);
				exit();
			}
		}
	}
}