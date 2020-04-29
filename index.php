<?php
require_once 'vendor\autoload.php';

//Routing
$page = 'acceuil';
if(isset($_GET['p'])){
    $page = $_GET['p'];
}

//Rendu du template

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/twig');
$twig = new \Twig\Environment($loader,['cache' => false,]);


switch($page){
    case 'acceuil':
        echo $twig->render('acceuil.twig');
        break;
    case 'signup':
        echo $twig->render('signup.twig');
        break;
    case 'signin':
        echo $twig->render('signin.twig');
        break;
}


?>