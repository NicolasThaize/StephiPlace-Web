<?php
session_start();
include('database.php');
if($_COOKIE["connected"] == 'TRUE' && isset($_SESSION["iduser"])){  // vérifie si l'utilisateur est connecté et possède un id d'utilisateur
    $dbh = accesDB();
    $rqt2 ="SELECT id_proprietaire FROM biens WHERE id_bien = ? ";
    $stmt2 = $dbh->prepare($rqt2); //prépare la requête
    $stmt2->execute([$_GET['idbien']]);
    $resultat = $stmt2->fetch(PDO::FETCH_ASSOC);

    if($_SESSION['iduser'] == $resultat['id_proprietaire']){
        $rqt = "DELETE FROM `biens` WHERE id_bien = ? ";
        $stmt = $dbh->prepare($rqt);
        $stmt->execute([$_GET['idbien']]);
    } else {echo 'non';}
 
} else {echo "Vous devez être connecté";}
header('location:../index.php?p=goods');
?>

