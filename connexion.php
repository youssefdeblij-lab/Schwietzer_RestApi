<?php
class Connexion {
	private $login;
	private $pass;
	private $connec;

	public function __construct($db, $login ='root', $pass=''){
		$this->login = $login;
		$this->pass = $pass;
		$this->db = $db;
		$this->connexion();
	}

	private function connexion(){
		try
		{
	         $bdd = new PDO(
                            'mysql:host=localhost;dbname='.$this->db.';charset=utf8mb4', 
                             $this->login, 
                             $this->pass
                 );
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			$this->connec = $bdd;
		}
		catch (PDOException $e)
		{
			$msg = 'ERREUR PDO IN ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
			die($msg);
		}
	}

	public function q($sql){
		$stmt = $this->connec->prepare($sql);

		 

		$stmt->execute();

		return $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt=NULL;
	}
	
	 public function insertCategorie($title){
		 
			$sql = "INSERT INTO categorie (id, `titel` ) VALUES (NULL, :title )";
			$stmt= $this->connec->prepare($sql);
			if($stmt->execute(["title" => $title])) return true; else return false;
	 }
	 
	 public function insertArticle($article){
		
		if($this->checkcategorie($article->idKategorie)) return false;
		 
		 
		 $data = [
				'titel' => $article->titel,
				'beschreibung' => $article->beschreibung,
				'BildLink' => $article->BildLink,
				'idKategorie' => $article->idKategorie
			];
		 
		 $sql = "INSERT INTO article (`id`, `titel`, `beschreibung`, `BildLink`, `idKategorie` ) VALUES (NULL, :titel , :beschreibung , :BildLink , :idKategorie)";
			$stmt= $this->connec->prepare($sql);
			if($stmt->execute($data)) return true; else return false;
			
	 }
	 
	 public function checkcategorie($idcategorie){
		 
		 $arr = $this->q("select * from categorie where id = " . $idcategorie);
		 
		if(empty($arr)) return true; else return false;
		 
	 }


}