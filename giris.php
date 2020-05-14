<?php
require_once 'core/init.php';

if (Input::varsa())
	if (Token::kontrol(Input::getir('token'))){
		$onaylama = new Onaylama();
		$onaylama = $onaylama->kontrol($_POST,array(
			'kullanici_adi' => array('zorunlu' => true),
			'sifre' => array('zorunlu' => true)
		));
		if ($onaylama->getTamam()){
			$kullanici = new Kullanici();
			$giris = $kullanici->giris(Input::getir('kullanici_adi'),Input::getir('sifre'));
			echo 'Giriş Yapıldı.';
		}
		else{
			foreach ($onaylama->getHatalar() as $hata)
				echo $hata.'<br>';
		}
	}
?>
<!doctype html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Giris Sayfası</title>
</head>
<body>
<form action="" method="post">
	<div class="alan">
		<label for="kullanici_adi">Kullanıcı Adı :</label>
		<input type="text" name="kullanici_adi" id="kullanici_adi" autocomplete="off">
	</div>
	<div class="alan">
		<label for="sifre">Şifre :</label>
		<input type="password" name="sifre" id="sifre" autocomplete="off">
	</div>
	<div class="alan">
		<label for="hatirla">Beni Hatırla :</label>
		<input type="checkbox" name="hatirla" id="hatirla" autocomplete="off">
	</div>
	<input type="hidden" name="token" value="<?php echo Token::oluştur();?>">
	<input type="submit" value="Giriş">
</form>
</body>
</html>
