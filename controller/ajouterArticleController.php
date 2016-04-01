<?php

redirectIfNotConnected();

$sql="SELECT * FROM categorie ";
$requete = $connexion -> prepare($sql);
$requete -> execute();
$categorie=$requete->fetchAll();

//var_dump($categorie);

if (!empty($_POST) && !empty($_FILES))
{



	if (!empty($_POST)) {
		$errors =[];
		if (empty($_POST["titre"])) {
			$errors["titre"]="Attention titre vide";
		}
		if (empty($_POST["description"])) {
			$errors["description"]="Attention description vide";
		}
		if (empty($_POST["fullstory"])) {
			$errors["description"]="Attention fullstory vide";
		}
		if (empty($_POST["tips"])) {
			$errors["description"]="Attention tips vide";
		}
		if (empty($_POST["auteur"])) {
			$errors["auteur"]="Attention auteur vide";
		}
		if (empty($_POST["date"])) {
			$errors["date"]="Attention date vide";
		}
		if (empty($_POST["categorie"])) {
			$errors["categorie"]="Attention categorie vide";
		}
		if (empty($_FILES['image']) || $_FILES['image']['error'] != 0)
    	{
    	$errors['titre'] = "Veuillez entrer une image";
    	}
    	else {
    		// Vérification si l'utilisateur m'envoit réellement une image
    		$extensions_valides = [ 'jpg' , 'jpeg' , 'gif' , 'png' ];
    		$extension_upload = str_replace("image/", "", $_FILES['image']['type']);
    		if (!in_array($extension_upload, $extensions_valides)) {
	        	$errors['image'] = "Image non valide";
	        }

    	}	

	}
	
	//var_dump($_POST);
	//var_dump($_FILES);

if (empty($errors)) {
	// INSERT INTO

		$titre = $_POST["titre"];
		$description = $_POST["description"];
		$fullstory = $_POST["fullstory"];
		$tips = $_POST["tips"];
		$nomImage = uniqid().'-'.$_FILES['image']['name'];
		// Ne pas reprendre le nom de l'image
        // $nomImage = uniqid().'.'.extension_upload;
        // Mettre le titre de l'article dans le nom de l'image
        // $nomImage = str_replace(' ', '-', $_POST['titre']).'-'.uniqid().'.'.extension_upload;
		$date = $_POST["date"];
		$auteur = $_POST["auteur"];
		$categorie = $_POST["categorie"];


		$successUpload = move_uploaded_file($_FILES['image']['tmp_name'], 'view/images/'.$nomImage);

		if ($successUpload == true) {

			$sql="INSERT INTO article(titre, description, fullstory, tips, auteur, image, date_creation, categorie_id) VALUES (:newtitre, :newdescription, :newstory, :newtips, :newauteur, :newimage, :newdate, :newcategorie)";
			$requete = $connexion -> prepare($sql);
			$requete ->bindValue(":newtitre", $titre);
			$requete ->bindValue(":newdescription", $description);
			$requete ->bindValue(":newstory", $fullstory);
			$requete ->bindValue(":newtips", $tips);
			$requete ->bindValue(":newimage", $nomImage);
			$requete ->bindValue(":newdate", $date);
			$requete ->bindValue(":newauteur", $auteur);
			$requete ->bindValue(":newcategorie", $categorie);
			$requete -> execute();

			$_SESSION["messageFlash"]="Bravo, vous avez publié votre article !";
			header("Location:?page=ajouterArticle");
			die();

		}
		else {
			$errors['image'] = "Problème lors de l'upload de l'image";
		}
		
	}
	else {
		foreach ($errors as $key => $value) {
			echo $value."<br/>";
		}
	}
}