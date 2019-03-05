<?php

	//CONNEXION BASE DE DONNEES MYSQL
	try 
	{
		$db = new PDO('mysql:host=localhost; dbname=e_blog_commerce; charset=utf8', 'root', 'root');
	}
	catch(Exception $e) 
	{
		die('Erreur : '.$e->getMessage());
	}
	
	$usertmp = "";
	$msg_error = "";

	//Si les champs ont été rempli, $_POST n'est donc pas vide
	if(!empty($_POST)) {
		//On injecte les variables de $_POST dans d'autres variables (Par sécurité)
		$mail = $_POST['mail'];
		$pass = $_POST['pass'];

		//On consulte la $db (base de donnée) avec une $req (requête sql)
		$req = $db->prepare('SELECT id FROM user WHERE mail= :mail');
		$req->bindParam(':mail', $mail);
		$req->execute();
		$checkmail = $req->fetch(); 

		//Si $mail existe dans la $db, $checkmail récupère une id et n'est donc pas "Empty"
		if (!empty($checkmail)) {

			//On consulte la $db avec une $req (requête sql)
			$req = $db->prepare('SELECT id FROM user WHERE mail= :mail AND password= :pass');
			$req->bindParam(':mail', $mail);
			$req->bindParam(':pass', $pass);
			$req->execute();
			$checkpass = $req->fetchAll(); 
			
			//Si le $mail et le $pass corresponde à l'utilisateur, $checkpass ne sera donc pas vide
			if (!empty($checkpass)) {
				header("location: index.php");
			//si le mot de passe ne corrspond pas :
			} else {
				$msg_error = "Mot de passe incorrect";
				$usertmp = $_POST['mail'];
			}
		//Si $mail n'est pas dans la base de donnée :
		} else {
			$msg_error = "Email utilisateur inconnu";
		}
	}
?>

