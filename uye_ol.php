<?php
require_once 'core/init.php';

if (Input::varsa()){
	if (Token::kontrol(Input::getir('token'))){
	  $onaylama = new Onaylama();
	  $onaylama->kontrol($_POST,array(
		  'kullanici_adi' => array(
			  'zorunlu'   => true,
			  'min'       => 2,
			  'max'       => 20,
			  'benzersiz' => 'uye'
		  ),
		  'sifre'         => array(
			  'zorunlu'   => true,
			  'min'       => 6,
		  ),
		  'sifre_tekrar'  => array(
			  'zorunlu'   => true,
			  'eslesme'       => 'sifre',
		  ),
		  'isim'          => array(
			  'zorunlu'   => true,
			  'min'       => 2,
			  'max'       => 50,
		  )
	  ));

	  if ($onaylama->getTamam()){
	    $kullanici = new Kullanici();
	    $salt = Hash::salt(32);
	    try{
        $kullanici->oluştur(array(
          'kullanici_adi' => Input::getir('kullanici_adi'),
	        'sifre' => Hash::yap(Input::getir('sifre'),$salt),
	        'salt' => $salt,
	        'isim' => Input::getir('isim'),
	        'uyelik_tarihi' => date('Y-m-g H:i:s'),
	        'grup' => 1
        ));
	      Session::flash('basari','Başarı ile Üye Oldunuz.');
	      header('Location:index.php');
      }catch (Exception $e){
	        die($e->getMessage());
      }
	  }
	  else{
		  foreach ($onaylama->getHatalar() as $hata) {
			  echo $hata . '<br>';
		  }
	  }
  }
}
?>

<!doctype html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" method="post">
	<div class="alan">
		<label for="kullanici_adi">Kullanıcı Adı</label>
		<input type="text" name="kullanici_adi" id="kullanici_adi" value="<?php echo filtrele(Input::getir('kullanici_adi'))?>" autocomplete="off">
	</div>
	<div class="alan">
		<label for="sifre">Şifre</label>
		<input type="password" name="sifre" id="sifre">
	</div>
	<div class="alan">
		<label for="sifre_tekrar">Şifre Tekrar</label>
		<input type="password" name="sifre_tekrar" id="sifre_tekrar">
	</div>
	<div class="alan">
		<label for="isim">İsim</label>
      <input type="hidden" name="token" value="<?php echo Token::oluştur();?>">
		<input type="text" name="isim" id="isim" value="<?php echo filtrele(Input::getir('isim'))?>">
	</div>
	<input type="submit" value="ÜYE OL">
</form>
</body>
</html>