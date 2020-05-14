<?php


class Onaylama
{
	private $tamam = false,
			$hatalar = array(),
			$db = null;

	public function getHatalar(){
		return $this->hatalar;
	}

	public function getTamam(){
		return $this->tamam;
	}

	public function __construct()
	{
		$this->db = new Db();
		$this->db->baglan();
	}

	public function kontrol($kaynak,$bolumler = array()){
		foreach ($bolumler as $bolum => $kurallar){
			foreach ($kurallar as $kural => $kural_deger) {
				$deger = trim($kaynak[$bolum]);
				$deger = filtrele($deger);
				if ($kural === 'zorunlu' && empty($deger)){
					$this->hataEkle("{$bolum} Zorunlu Alandır.");
				}
				else if(!empty($deger)){
					switch ($kural){
						case 'min' :
							if (strlen($deger) < $kural_deger)
								$this->hataEkle("{$bolum} En Az {$kural_deger} Karekter Olmalı");
							break;
						case 'max' :
							if (strlen($deger) > $kural_deger)
								$this->hataEkle("{$bolum} En Fazla {$kural_deger} Karekter Olmalı");
							break;
						case 'eslesme' :
							if ($deger != $kaynak[$kural_deger])
								$this->hataEkle("{$kural_deger} ile {$bolum} Eşleşmedi");
							break;
						case 'benzersiz' :
							$kontol = $this->db->satirGetir($kural_deger,array("{$bolum}","=","{$deger}"));
							if ($kontol->getSayac())
								$this->hataEkle("{$bolum} Daha Önce Alınmış!");
							break;
						default:
							break;
					}
				}
			}
		}

		if (empty($this->getHatalar())){
			$this->tamam = true;
		}
		return $this;
	}

	public function hataEkle($hatalar){
		$this->hatalar[] = $hatalar;
	}
}