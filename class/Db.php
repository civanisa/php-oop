<?php

class Db
{
	private
		$pdo,
	    $query,
	    $sayac = 0,
	    $sonuc,
	    $hatalar = false;

	public function getSonuc(){
		return $this->sonuc;
	}

	public function getSayac(){
		return $this->sayac;
	}

	public function getHatalar(){
		return $this->hatalar;
	}

	public function baglan(){
		try {
			$host = Config::getir('mysql/host');
			$db = Config::getir('mysql/db');
			$kulanici_adi = Config::getir('mysql/kulanici_adi');
			$sifre = Config::getir('mysql/sifre');
			$this -> pdo = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8',$kulanici_adi ,$sifre );
		} catch ( PDOException $e ){
			print $e->getMessage();
		}
	}

	public function query($sql,$parametre = array()){
		$this->hatalar = false;
		if ($this->query = $this->pdo->prepare($sql)){
			$x = 1;
			if (count($parametre)){
				foreach ($parametre as $item){
					$this->query->bindValue($x,$item);
					$x++;
				}
				if ($this->query->execute()){
					$this ->sonuc = $this ->query -> fetchAll(PDO::FETCH_OBJ);
					$this ->sayac = $this ->query -> rowCount();
				}
				else{
					$this->hatalar = true;
				}
			}
		}
		return $this;
	}

	public function eylem($eylem,$tablo,$where = array()){
		if (count($where) === 3){
			$operatorler = array('=','>','<','>=','<=');

			$alan = $where[0];
			$operator = $where[1];
			$deger = $where[2];

			if (in_array($operator,$operatorler)){
				$sql = "{$eylem} FROM {$tablo} WHERE {$alan} {$operator} ? ";
				if (!$this->query($sql,array($deger))->getHatalar()){
					return $this;
				}
			}
		}
		return false;
	}

	public function satirEkle($tablo,$alanlar = array()){
		$anahtar = array_keys($alanlar);
		$degerler = '';
		$x = 1;
		foreach ($alanlar as $alan) {
			$degerler .= '?';
			if ($x < count($alanlar)) {
				$degerler .= ", ";
			}
			$x++;
		}
		$sql = "INSERT INTO {$tablo} (".implode(",",$anahtar).") VALUES ({$degerler})";
		if (!$this->query($sql,$alanlar)->getHatalar()){
			return $this;
		}
		return false;
	}

	public function satirIlk(){
		return $this->getSonuc()[0];
	}

	public function satirGetir($tablo,$where){
		return $this ->eylem('SELECT *', $tablo, $where);
	}

	public function satirSil($tablo,$where){
		return $this->eylem('DELETE',$tablo,$where);
	}
}