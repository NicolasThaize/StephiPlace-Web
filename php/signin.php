<?php
if (isset($_POST['coSubmit']) && isset($_POST['coPseudo']) && isset($_POST['coMdp'])){
    
    if(ctype_alnum($_POST['coPseudo'])){
        $pseudo = $_POST['coPseudo'];
    } else {header('location:../index.php?p=signin'); }

    $mdp = $_POST['coMdp'];

} else {header('location:../index.php?p=signin'); }

include('database.php');

function testConnexion($pseudo,$mdp){
    $dbh=accesDB();
	return testMdp($dbh,$pseudo,$mdp);
}

if(testConnexion($pseudo,$mdp)){
    $dbh=accesDB();
    $id=recupIdFromPseudo($dbh,$pseudo);
    session_start(); 
    $_SESSION['iduser'] = $id; 
    setcookie("connected", 'TRUE', strtotime('+ 3 days'),'/');
    header('location:../index.php?p=acceuil');
} else {
    echo("Mdp incorrect");
}




?>