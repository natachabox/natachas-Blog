<?php
session_start();
//var_dump($_SESSION);

//dsn = dollar serveur name, nom de la base de données
$dsn ="mysql:host=localhost;dbname=blog;charset=utf8";
$userlogin="root";
$password="motdepasse";
$connexion= new PDO($dsn,$userlogin,$password);
$connexion->SetAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
$connexion->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);



//var_dump(empty($_SESSION["utilisateur"]));

function isConnected()
{
	if (empty($_SESSION['user']))
    {
    	return false;
    }
    
    return true;
}


function redirectIfNotConnected()
{
	if (isConnected() == false)
    {
    	header('Location: index.php?page=login');
        die();
    }
}
