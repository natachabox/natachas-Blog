<?php

//var_dump($_GET);
$page = $_GET["page"];
$idArticle = $_GET["id-article"];

// récupérer les données d'un article

if (!empty($_GET["id-article"])) {
	

	$sql="SELECT * FROM article WHERE id=:newid";
	$requete = $connexion -> prepare($sql);
	$requete ->bindValue(":newid", $idArticle);
	$requete -> execute();
	$article=$requete->fetch();

	$sql="SELECT categorie.titre FROM article INNER JOIN categorie ON categorie_id=categorie.id  WHERE article.id=:newid";
	$requete = $connexion -> prepare($sql);
	$requete ->bindValue(":newid", $idArticle);
	$requete -> execute();
	$categorie=$requete->fetchcolumn();

	//var_dump($categorie);

	//requete pour avoir la notre moyenne d'un article

	$sql="SELECT ROUND(AVG(note),1) as note FROM article INNER JOIN commentaire ON article.id=article_id WHERE article.id=:newid";
	$requete = $connexion -> prepare($sql);
	$requete ->bindValue(":newid", $idArticle);
	$requete -> execute();
	$note=$requete->fetchcolumn();

	//var_dump($note);
}

//recupérer la categorie de l'article



//var_dump($article);

if (empty($article)) {
	header("Location:index.php?page=404");
	die();
}

//var_dump($_POST);

if (!empty($_POST))
{

	if (!empty($_POST)) {
		$errors =[];
		if (empty($_POST["auteur"])) {
			$errors["auteur"]="Attention auteur vide";
		}
		if (empty($_POST["note"])) {
			$errors["note"]="Attention note vide";
		}
		if (empty($_POST["comment"])) {
			$errors["comment"]="Attention commentaire vide";
	}	

}

	if (empty($errors)) {
	// INSERT INTO

		$auteur = $_POST["auteur"];
		//var_dump($auteur);
		$note = $_POST["note"];
		$comment = $_POST["comment"];


		$sql="INSERT INTO commentaire(auteur, contenu, note, date_creation, article_id) VALUES (:newauteur, :newcomment, :newnote, now(), :newarticle)";
		$requete = $connexion -> prepare($sql);
		$requete ->bindValue(":newauteur", $auteur);
		$requete ->bindValue(":newcomment", $comment);
		$requete ->bindValue(":newnote", $note);
		$requete ->bindValue(":newarticle", $idArticle);
		$requete -> execute();

		//header("Location:?page=article&id-article=".$idArticle."");
		/* AJAX check  */
	    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
	    {

	    $commentaireAjax = '
				<div class="media">
                        <a class="pull-left" href="#">
                            note: '.$_POST["note"].'
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">'.$_POST["auteur"].'
                                <small>'.$_POST["auteur"].'</small>
                            </h4>
                            '.$_POST["auteur"].'
                        </div>
                    </div>';

	    $dataAjax = ['success' => 'Votre commentaire a bien été ajouté'];
    	die(json_encode($dataAjax));	// Permet de retourner des informations au format json

	    }
	}
	else {
		foreach ($errors as $key => $value) {
			echo $value."<br/>";
		}
	}
}

//recuperer les commentaires et les afficher

$sql="SELECT * FROM commentaire WHERE article_id=:newid ORDER BY date_creation DESC";
	$requete = $connexion -> prepare($sql);
	$requete ->bindValue(":newid", $idArticle);
	$requete -> execute();
	$comments=$requete->fetchAll();


//var_dump($comments);

if (empty($comments)) {
	$comments[0]["note"] = "";
	$comments[0]["auteur"] = "";
	$comments[0]["date_creation"] ="";
	$comments[0]["contenu"] = "Be the first to leave a comment !";
}