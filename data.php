<?php

require_once("connexion.php");


class data{
	
	protected $connexion;
	
	
	public function __construct(){
		$db = "product";
		$this->connexion = new Connexion($db);
		
	}
	
	public function getAllCategories(int $limit=0){
		$qs = "Select * from Categorie";
		$arr = $this->connexion->q($qs);
		
		$categories = Array_map(function($obj){
			$obj->articles  = $this->getArctilesByIdCat($obj->id); 
			return $obj;
		},$arr);
		 
		return JSON_encode($categories);
		
	
	}
	public function getAllArticle(int $limit=0){
		$qs = "Select * from article";
		$arr = $this->connexion->q($qs);
		return $arr;
	}
	
	public function getArctilesByIdCat(int $idCategorie){
		
		$qs = "Select * from article where idKategorie=" . $idCategorie;
		$articles = $this->connexion->q($qs);
		
		return $articles;
		
	}
	
	public function insertCategorie(string $title){
		
		if($this->connexion->insertCategorie($title)){
			return json_encode(['Status' => '200','message' => 'Ok']);
		}else return json_encode(['Status' => '403','message' => 'Error']);
	}
	
	public function insertArticle($article){
		
		if($this->connexion->insertArticle($article)){
			return json_encode(['Status' => '200','message' => 'Ok']);
		}else return json_encode(['Status' => '403','message' => 'Error']);
	}
	
	



}