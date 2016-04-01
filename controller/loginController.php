<?php

//var_dump($_POST);


if (!empty($_POST))
{

	if (!empty($_POST)) {
		$errors =[];
		if (FALSE == (filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))) {
			$errors["email"]="Attention email non valide";
		}
		if (empty($_POST["email"])) {
			$errors["email"]="Attention email vide";
		}	
		if (empty($_POST["password"])) {
			$errors["password"]="Attention password vide";
		}

	}

	if (empty($errors)) {
	// VERIFIE SI L'UTILISATEUR EST DANS LA BASE

		$mail = $_POST["email"];
		$password = $_POST["password"];

		$sql="SELECT email, password FROM utilisateur WHERE email = :newemail ";
		$requete = $connexion -> prepare($sql);
		$requete ->bindValue(":newemail", $mail);
		$requete -> execute();
		$user=$requete->fetch();

		var_dump($user);

		$exist= [];
		if (FALSE == $user["email"]) {
			$exist["user"] = ["l'utilisateur n'existe pas"]; 
		}
		else {
			$hash = $user["password"];
			if (password_verify($password, $hash)) {
				// CONNEXION UTILISATEUR
                $_SESSION['user'] = $user;
                
                header('Location: index.php');
                die();
			}
			else {
				echo "mot de passe ou login invalide";
			}
		}

	}
	else {
		foreach ($errors as $key => $value) {
			echo $value."<br/>";
		}
	}
}

if (!empty($exist)) {
	echo "L'utilisateur n'existe pas";
}