<?php


class Kullanici
{
	private $db,
			$veri;

	public function GetVeri(){
		return $this->veri;
	}

	public function __construct()
	{
		$this->db = new Db();
		$this->db->baglan();
	}

	public function oluştur($alanlar = null){
		if (!$this->db->satirEkle('uye',$alanlar)){
			throw new Exception('Hesap Oluşturulamadı');
		}
	}

	public function bul($kullanici = null){
		if ($kullanici){
			$alan = (is_numeric($kullanici)) ? 'id' : 'kullanici_adi';
			$veri = $this->db->satirGetir('uye',array($alan,'=',$kullanici));
			if ($veri->getSayac()){
				$this->veri = $veri->satirIlk();;
				return true;
			}
		}
		return false;
	}

	public function giris($kullanciAdi = null, $sifre=null){
		$kullanici = $this->bul($kullanciAdi);
		if ($kullanici){
			if ($this->GetVeri()->sifre === Hash::yap($sifre,$this->veri->salt))
			echo  tamam;
		}
		return false;
	}
}