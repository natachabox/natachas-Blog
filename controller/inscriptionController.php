<?php

//var_dump($_POST);

if (!empty($_POST))
{

	if (!empty($_POST)) {
		$errors =[];
		if (empty($_POST["name"])) {
			$errors["name"]="Attention name vide";
		}
		if (empty($_POST["firstname"])) {
			$errors["firstname"]="Attention firstname vide";
		}
		if (empty($_POST["email"])) {
			$errors["email"]="Attention email vide";
		}
		if (empty($_POST["password"])) {
			$errors["password"]="Attention password vide";
		}
		if (FALSE == (filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))) {
			$errors["email"]="Attention email non valide";
		}	

	}

	if (empty($errors)) {
	// INSERT INTO

		$name = $_POST["name"];
		$firstname = $_POST["firstname"];
		$mail = $_POST["email"];
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

		//VERIFIE SI USER EXISTE

		$sql="SELECT email, password FROM utilisateur WHERE email = :newemail ";
		$requete = $connexion -> prepare($sql);
		$requete ->bindValue(":newemail", $mail);
		$requete -> execute();
		$user=$requete->fetch();

		$exist= [];
		if (FALSE == $user["email"]) {
			
			//AJOUT DU USER SI TOUT EST OK
			$sql="INSERT INTO utilisateur(nom, prenom, email, password) VALUES (:newname, :newfirstname, :newemail, :newpassword)";
			$requete = $connexion -> prepare($sql);
			$requete ->bindValue(":newname", $name);
			$requete ->bindValue(":newfirstname", $firstname);
			$requete ->bindValue(":newemail", $mail);
			$requete ->bindValue(":newpassword", $password);
			$requete -> execute();

			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		    {

			$dataAjax = ['success' => 'Votre inscription est validée.'];
	    	die(json_encode($dataAjax));

	    	}

	    	header("Location: index.php");
	    	die();
			
		}
		else {
			$errors['login'] = "Attention ce login est déjà utilisé";
		}

	}


	if($errors && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{

			$dataAjax = ['errors' => $errors];
			die(json_encode($dataAjax));

		}
	}