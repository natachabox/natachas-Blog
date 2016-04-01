

<?php




/****************************
 PAGINATION
 ********************************/

$nbResultPerPage = 3;
//var_dump($_GET);
if (empty($_GET)) {
	$limitFirstNb = 0;
	$pageSelected = 0;
}
else if (empty($_GET["nbpage"])) {
	$limitFirstNb = 0;
	$pageSelected = 0;
}
else {
$pageSelected = $_GET["nbpage"];
$limitFirstNb =($pageSelected - 1)*$nbResultPerPage;
//var_dump("firstnumb :".$limitFirstNb);
}


//Pour trouver le nombre d'article total $nbArticles

$sql="SELECT COUNT(titre) AS nbart FROM article";
$requete = $connexion -> prepare($sql);
$requete -> execute();
$articlenb=$requete->fetchColumn();
//var_dump($articlenb);
$nbArticles = $articlenb;

$nbPages = ceil($nbArticles / $nbResultPerPage);
//var_dump($nbPages);

/**********
AFFICHAGE
***************************/

// pour récupérer les données
$sql="SELECT * FROM article ORDER BY date_creation DESC LIMIT :newlimit , :newpage";
$requete = $connexion -> prepare($sql);
$requete ->bindValue(":newlimit", $limitFirstNb, PDO::PARAM_INT);
$requete ->bindValue(":newpage", $nbResultPerPage, PDO::PARAM_INT);
$requete -> execute();
$articles=$requete->fetchAll();

//var_dump($articles);

//requete pour avoir la notre moyenne d'un article

$sql="SELECT article.id, ROUND(AVG(note),1) as note FROM article INNER JOIN commentaire ON article.id=article_id GROUP BY article.id";
$requete = $connexion -> prepare($sql);
$requete -> execute();
$note=$requete->fetchAll();

//var_dump($note);
$noteAVG =[];

foreach ($note as $key => $value) {
	$titre = $value["id"];
	$avg = $value["note"];
	$noteAVG[$titre] =$avg;
}

//var_dump($noteAVG);
