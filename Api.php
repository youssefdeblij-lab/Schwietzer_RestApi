<?php
require_once("data.php");

$data = new data();

if(isset($_GET['action'])){
	
	$action = $_GET['action'];
	switch ($action){
		case "read":
			
			$Categories = $data->getAllCategories();
			echo($Categories);
			
		break;
		case "put":
			if(isset($_GET['Token'])){
				$Token_restruction = $_GET['Token'];
				$hash =  "t89apQ8QAC9fH8iuuIQlqoaBDISgBlKTUbqoLYMCdnbdJEqu";
				 
				if( $Token_restruction != $hash ) header('HTTP/1.0 403 Unauthorized');
				else{
					 if(isset($_GET['table'])){
						 $table = $_GET['table'];
						switch($table){
							case "categorie":
								if(isset($_GET['title'])  ){
									$title = $_GET['title'];
									echo $data->insertCategorie($title); 	 
								 }else header('HTTP/1.0 401 Bad Request');
							break;
							case "article":
							 
								if(isset($_GET['titel'])  && isset($_GET['beschreibung'])  && isset($_GET['BildLink'])  && isset($_GET['idKategorie'])   ){
									$article = (Object) [
										"titel" => $_GET['titel'],
										"beschreibung" => $_GET['beschreibung'],
										"BildLink" => $_GET['BildLink'],
										"idKategorie" => $_GET['idKategorie']
									];
									echo $data->insertArticle($article); 	 
								 }else header('HTTP/1.0 401 Bad Request');
							
							
							break;
							default : 

							 header('HTTP/1.0 401 Bad Request');
							break;
						}
						 
						 
					 } else header('HTTP/1.0 401 Bad Request');
				}		
				 
			}else header('HTTP/1.0 403 Unauthorized');
				
		break;
		
	}

	
	
}

