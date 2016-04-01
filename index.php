
<?php 
include "config/config.inc.php";

$page="home";

//var_dump($_GET["page"]);

if(!empty($_GET["page"])) {
	$page=$_GET["page"];
}

if("logout" == $page) {
    unset($_SESSION["user"]);
    header("Location:index.php?page=login");
    die();
}


$controller = 'controller/'.$page.'Controller.php';
$view = 'view/'.$page.'View.phtml';

if (!file_exists($controller) || !file_exists($view))
{
	header("Location: index.php?page=404");
	die();
}

include $controller;
include $view;

//var_dump($_SESSION);
