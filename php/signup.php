<?php
if (isset($_POST['envoiCrea']) && isset($_POST['creaMail']) && isset($_POST['creaPseudo']) && isset($_POST['creaNom']) && isset($_POST['creaPrenom']) && isset($_POST['creaNaissance']) && isset($_POST['creaVille']) && isset($_POST['creaCodePostal']) && isset($_POST['creaMdp'])){
    
    if(ctype_alnum($_POST['creaPseudo'])){
        $pseudo = $_POST['creaPseudo'];
    } else {header('location:../index.php?p=signup'); }

    if(ctype_alpha($_POST['creaNom'])){
        $nom = $_POST['creaNom'];
    } else {header('location:../index.php?p=signup'); }
    
    if(ctype_alpha($_POST['creaPrenom'])){
        $prenom = $_POST['creaPrenom'];
    } else {header('location:../index.php?p=signup'); }

    if(ctype_alpha($_POST['creaVille'])){
        $ville = $_POST['creaVille'];
    } else {header('location:../index.php?p=signup'); }

    if(ctype_digit($_POST['creaCodePostal'])){
        $codePostal = $_POST['creaCodePostal'];
    } else {header('location:../index.php?p=signup'); }

    
    $mail = $_POST['creaMail'];
    $naissance = $_POST['creaNaissance'];
    $mdp = $_POST['creaMdp'];

} else {header('location:../index.php?p=signup'); }

include('database.php');

function creation($pseudo,$nom,$prenom,$naissance,$mail,$ville,$codePostal,$mdp){
    $mdp=password_hash($mdp, PASSWORD_BCRYPT);

    $dbh=accesDB();
    $rqt ="INSERT INTO utilisateurs (pseudonyme, nom, prenom, date_naissance, mail, ville, code_postal, mdp) VALUES (?,?,?,?,?,?,?,?)";
	$stmt = $dbh->prepare($rqt); //prépare la requête
	$stmt->execute([$pseudo,$nom,$prenom,$naissance,$mail,$ville,$codePostal,$mdp]);
}
creation($pseudo,$nom,$prenom,$naissance,$mail,$ville,$codePostal,$mdp);

header('location:../index.php?p=signin');

?>