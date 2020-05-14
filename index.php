<?php
require_once 'core/init.php';

if (Session::varsa('basari')){
	echo Session::flash('basari');
}

$db = new Db();
$db->baglan();
$db->satirGetir('uye',array('kullanici_id','>','0'));
$satir = $db->getSonuc();
$hata = 0;
if ($db->getHatalar() != null)
    $hata = $db->getHatalar();
$satir_say = $db->getSayac();
$satir=objectToArray($satir);
?>
<!doctype html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<title>Vue + Php </title>
</head>
<body>
	<div id="app">
		Kullanici Sayisi : {{kullaniciSayisi}} <br>
    Hata Sayisi : {{denemeVerisi}}
	</div>
  <div  id="liste">
      <ul>
          <li v-for="(item, index) in items">
              {{ item.message }}
          </li>
      </ul>
  </div>

	<script>
    var app = new Vue({
      el:'#app',
      data:{
        kullaniciSayisi : "<?php echo $satir_say;?>",
        denemeVerisi : "<?php echo $hata?>",
      }
    });

      var example2 = new Vue({
        el: '#liste',
        data: {
          parentMessage: 'Parent',
          items: [
	          <?php for($i = 0 ; $i<$satir_say; $i++) echo "{ message :'".$satir[$i]['kullanici_adi']."'},"; ?>
          ]
        }
      });
	</script>
</body>
</html>
