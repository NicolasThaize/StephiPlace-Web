<?php
include('database.php');

// Modifications pour chaque champ d'un compte utilisateur

function modifsUserPseudo($dbh,$iduser,$valeur){
	echo $valeur,$iduser;
	$rqt = ("UPDATE utilisateurs SET pseudonyme = ? WHERE IDUSER = ?");
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$valeur,$iduser]);
}

function modifsUserNom($dbh,$iduser,$valeur){
	echo $valeur,$iduser;
	$rqt = ("UPDATE utilisateurs SET nom = ? WHERE IDUSER = ?");
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$valeur,$iduser]);
}

function modifsUserPrenom($dbh,$iduser,$valeur){
	echo $valeur,$iduser;
	$rqt = ("UPDATE utilisateurs SET prenom = ? WHERE IDUSER = ?");
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$valeur,$iduser]);
}

function modifsUserEmail($dbh,$iduser,$valeur){
	echo $valeur,$iduser;
	$rqt = ("UPDATE utilisateurs SET mail = ? WHERE IDUSER = ?");
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$valeur,$iduser]);
}

function modifsUserVille($dbh,$iduser,$valeur){
	echo $valeur,$iduser;
	$rqt = ("UPDATE utilisateurs SET ville = ? WHERE IDUSER = ?");
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$valeur,$iduser]);
}

function modifsUserCodePostal($dbh,$iduser,$valeur){
	echo $valeur,$iduser;
	$rqt = ("UPDATE utilisateurs SET code_postal = ? WHERE IDUSER = ?");
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$valeur,$iduser]);
}

function modifsUserMdp($dbh,$iduser,$valeur){
	echo $valeur,$iduser;
	$rqt = ("UPDATE utilisateurs SET mdp = ? WHERE IDUSER = ?");
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$valeur,$iduser]);
}

session_start();

$iduser = $_SESSION['iduser'];

if(testMdpFromID(accesDB(),$iduser,$_POST['coMdp'])){
    if(isset($_POST['modPseudo'])){
        if(ctype_alnum($_POST['coPseudo'])){
            $pseudo = $_POST['coPseudo'];
            modifsUserPseudo(accesDB(),$iduser,$pseudo);
        } else {header('location:../index.php?p=signup'); }
    }
    
    if(isset($_POST['modNom'])){
        if(ctype_alpha($_POST['coPseudo'])){
            $nom = $_POST['coPseudo'];
            modifsUserNom(accesDB(),$iduser,$nom);
        } else {header('location:../index.php?p=signup'); }
    }
    
    if(isset($_POST['modPrenom'])){
        if(ctype_alpha($_POST['coPseudo'])){
            $prenom = $_POST['coPseudo'];
            modifsUserPrenom(accesDB(),$iduser,$prenom);
        } else {header('location:../index.php?p=signup'); }
    }
    
    if(isset($_POST['modEmail'])){
        $mail = $_POST['coPseudo'];
        modifsUserEmail(accesDB(),$iduser,$mail);
    
    }
    
    if(isset($_POST['modVille'])){
        if(ctype_alpha($_POST['coPseudo'])){
            $ville = $_POST['coPseudo'];
            modifsUserVille(accesDB(),$iduser,$ville);
        } else {header('location:../index.php?p=signup'); }
    }
    
    if(isset($_POST['modCode%20Postal'])){
        if(ctype_digit($_POST['coPseudo'])){
            $codePostal = $_POST['coPseudo'];
            modifsUserCodePostal(accesDB(),$iduser,$codePostal);
        } else {header('location:../index.php?p=signup'); }
    }
    
    if(isset($_POST['modMot%20de%20passe'])){
        $mdp=password_hash($_POST['coPseudo'], PASSWORD_BCRYPT);
        modifsUserMdp(accesDB(),$iduser,$mdp);
    }
    header('location:../index.php?p=account');
} else {echo 'Mot de passe incorrect';}



?>