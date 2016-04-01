<?php

//var_dump($_GET);
$idcat= $_GET["idcat"];


$sql="SELECT * FROM categorie WHERE id=:idcat";
$requete = $connexion -> prepare($sql);
$requete ->bindValue(":idcat", $idcat);
$requete -> execute();
$categorie=$requete->fetch();

//var_dump($categorie);


// ramener les articles de la bonne catégorie

$sql="SELECT * FROM article WHERE categorie_id=:idcat";
$requete = $connexion -> prepare($sql);
$requete ->bindValue(":idcat", $idcat);
$requete -> execute();
$artCategorie=$requete->fetchAll();

//var_dump($artCategorie);
