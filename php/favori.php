<?php

session_start();

if($_COOKIE["connected"] == 'TRUE' && isset($_SESSION["iduser"])){  // vérifie si l'utilisateur est connecté et possède un id d'utilisateur
    include('database.php');
    if(empty(testFavoriFromUserIdAndBienID(accesDB(),$_SESSION['iduser'],$_GET['ID']))){
        function ajoutFavori($iduser,$idbien){
            $dbh=accesDB();
            $rqt ="INSERT INTO favoris (id_user, id_bien) VALUES (?,?)";
            $stmt = $dbh->prepare($rqt); //prépare la requête
            $stmt->execute([$iduser,$idbien]);
        }
        ajoutFavori($_SESSION['iduser'],$_GET['ID']);
        
    } else {
        function supprFavori($iduser,$idbien){
            $dbh=accesDB();
            $rqt ="DELETE FROM favoris WHERE id_user = ? AND id_bien = ?";
            $stmt = $dbh->prepare($rqt); //prépare la requête
            $stmt->execute([$iduser,$idbien]);
        }
        supprFavori($_SESSION['iduser'],$_GET['ID']);
    }
    header('location:../index.php?p=good&bienID='.$_GET['ID']);
} else {echo "Vous devez être connecté pour ajouter un bien en favori.";}

?>