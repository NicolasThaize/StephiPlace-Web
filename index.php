<?php
require_once 'vendor\autoload.php';
require_once 'php\database.php';

if (empty($_COOKIE["connected"])) { //Teste si le cookie connecté existe sinon en crée un
    setcookie("connected", 'FALSE', strtotime('+ 3 days'),'/');
}

session_start(); //Lance les sessions

if(!(isset($status))){ //vérifie le status de la page si non défini le met sur false
    $status = false;
}

if($_COOKIE["connected"] == 'TRUE' && isset($_SESSION["iduser"])){  // vérifie si l'utilisateur est connecté et possède un id d'utilisateur
    $tabUserInfo=recupInfosUserFromUserID(accesDB(),$_SESSION["iduser"]);
    $status = true;
    if(empty(testFavoriFromUserID(accesDB(),$_SESSION['iduser']))){
        $favoris = false;
    } else { 
        $favoris = true; 
    }
}





//Routing
$page = 'acceuil';
if(isset($_GET['p'])){
    $page = $_GET['p'];
}

if(isset($_GET['bienID'])){
    $bienID = $_GET['bienID'];
    $tabGoodInfo = recupInfosGoodFromGoodID(accesDB(),$bienID);
}

if(isset($_GET['mod'])){
    $modified = $_GET['mod'];
}

//Rendu du template

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/twig');
$twig = new \Twig\Environment($loader,['cache' => FALSE,]);


switch($page){
    case 'acceuil':
        if($status){ // teste si l'utilisateur est connecté
            echo $twig->render('acceuil.twig',[
                'status'=>$status,
                'idsuer'=>$_SESSION["iduser"]              //Récupère le contenu de la session et l'envoie sur la page
                ]); 
        } else {echo $twig->render('acceuil.twig');}
        break;



    case 'signup':
        
        if($status){ echo 'Vous êtes déjà connecté';} 
        else {echo $twig->render('signup.twig');}
        break;
 

    case 'signin':
        if($status){ echo 'Vous êtes déjà connecté';} 
        else {echo $twig->render('signin.twig');}
        break;


    case 'research':
        if($status){
            echo $twig->render('research.twig',[
                'status'=>$status,
                'idsuer'=>$_SESSION["iduser"],              //Récupère le contenu de la session et l'envoie sur la page
                'research'=>$_SESSION["research"]
                ]);
            } else {echo $twig->render('research.twig',[
                'status'=>$status,              //Récupère le contenu de la session et l'envoie sur la page
                'research'=>$_SESSION["research"]
                ]);}
        break;


    case 'account':
        if($status){
            echo $twig->render('account.twig',[
                'status'=>$status,
                'idsuer'=>$_SESSION["iduser"],              //Récupère le contenu de la session et l'envoie sur la page
                'tabUser'=>$tabUserInfo
                ]);
            } else {echo 'Vous n\'êtes pas connecté';}
        break;

    case 'modify':
        if($status){
            echo $twig->render('modify.twig',[
                'status'=>$status,
                'idsuer'=>$_SESSION["iduser"],              //Récupère le contenu de la session et l'envoie sur la page
                'modif'=>$modified
                ]);
            } else {echo 'Vous n\'êtes pas connecté';}
        break;

    case 'good':
        if(isset($_GET['bienID'])){
            if($_GET['bienID'] > 0 && ctype_digit($_GET['bienID'])){ // Sécurise l'entrée du get 
                if(isset($_SESSION['iduser'])){ // vérifie si l'utilisateur est authentifié
                    if(empty(testFavoriFromUserIdAndBienID(accesDB(),$_SESSION['iduser'],$_GET['bienID']))){ // Si l'utilisateur a pour favori le bien sélectionné
                        $favColor = "white";
                        } else {$favColor = "gold";}
                } else {$favColor = "white";}

                
                echo $twig->render('good.twig',[
                    'status'=>$status,
                    'bienID'=>$bienID,
                    'tabGood'=>$tabGoodInfo,
                    'favColor'=>$favColor
                    ]);    
            } else {echo "Bien inexistant";}
        } else {echo "Bien inexistant";}
        break;    

    case 'goods':
        if($status){
            echo $twig->render('goods.twig',[
                'status'=>$status,
                'idsuer'=>$_SESSION["iduser"],              //Récupère le contenu de la session et l'envoie sur la page
                'tabUser'=>$tabUserInfo
                ]);
            } else {echo 'Vous n\'êtes pas connecté';}
        break;


    default:
        echo '404 Error Not found';
        break;
}


?>