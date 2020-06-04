<?php
if (isset($_POST['titreBien']) && isset($_POST['descriptionBien']) && isset($_POST['typeBien']) && isset($_POST['superficieBien']) && isset($_POST['surfaceBien']) && isset($_POST['nbrePiecesBien']) && isset($_POST['etagesBien']) && isset($_POST['villeBien']) && isset($_POST['code_postalBien']) && isset($_POST['adresseBien']) && isset($_POST['prixBien'])){
    
    if(ctype_alnum($_POST['titreBien'])){
        $titre = $_POST['titreBien'];
    } else {header('location:../index.php?p=startselling'); }

    if(ctype_alnum($_POST['descriptionBien'])){
        $description = $_POST['descriptionBien'];
    } else {header('location:../index.php?p=startselling'); }
    
    if(ctype_alpha($_POST['typeBien'])){
        $type = $_POST['typeBien'];
    } else {header('location:../index.php?p=startselling'); }

    if(ctype_digit($_POST['superficieBien'])){
        $superficie = $_POST['superficieBien'];
    } else {header('location:../index.php?p=startselling'); }

    if(ctype_digit($_POST['surfaceBien'])){
        $surface = $_POST['surfaceBien'];
    } else {header('location:../index.php?p=startselling'); }

    if(ctype_digit($_POST['nbrePiecesBien'])){
        $pieces = $_POST['nbrePiecesBien'];
    } else {header('location:../index.php?p=startselling'); }

    if(ctype_digit($_POST['etagesBien'])){
        $etages = $_POST['etagesBien'];
    } else {header('location:../index.php?p=startselling'); }
    
    if(ctype_alpha($_POST['villeBien'])){
        $ville = $_POST['villeBien'];
    } else {header('location:../index.php?p=startselling'); }

    if(ctype_digit($_POST['code_postalBien'])){
        $code_postal = $_POST['code_postalBien'];
    } else {header('location:../index.php?p=startselling'); }

    if(ctype_alnum($_POST['adresseBien'])){
        $adresse = $_POST['adresseBien'];
    } else {header('location:../index.php?p=startselling'); }

    if(ctype_digit($_POST['prixBien'])){
        $prix = $_POST['prixBien'];
    } else {header('location:../index.php?p=startselling'); }

    echo 'salut;';

    if(isset($_POST['surfaceDep']) && isset($_POST['nbrePiecesDep']) ){
        $surfaceDep = $_POST['surfaceDep'];
        $piecesDep = $_POST['nbrePiecesDep'];
    } else {
        $surfaceDep = NULL;
        $piecesDep = NULL;
    }

    $dateAjout = date('Y-m-d');

    session_start();
    $idUser = $_SESSION['iduser'];

    include('database.php');
    $pseudoUser = pseudoUserFromUserID(accesDB(),$idUser);

    function ajoutBien($titre,$desc,$type,$superficie,$surface,$pieces,$etages,$ville,$code_postal,$adresse,$prix,$surfaceDep,$piecesDep,$date,$iduser,$pseudo){
        $dbh=accesDB();
        $rqt ="INSERT INTO biens (id_proprietaire, proprietaire, titre, description, type, superficie, surface_habitable, nbr_piece, prix, date_ajout, adresse, code_postal, ville, etage) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $dbh->prepare($rqt); //prépare la requête
        $stmt->execute([$iduser,$pseudo,$titre,$desc,$type,$superficie,$surface,$pieces,$prix,$date,$adresse,$code_postal,$ville,$etages]);
        
        $rqt2 ="SELECT id_bien FROM biens WHERE date_ajout = ? AND id_proprietaire = ? AND etages = ?";
        $stmt2 = $dbh->prepare($rqt2); //prépare la requête
        $stmt2->execute([$date,$iduser,$etages]);
        $resultat = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($surfaceDep != NULL){
            
            $rqt3 ="INSERT INTO dependances (IDBIEN, SURFACE, NBRPIECE) VALUES (?,?,?)";
            $stmt3 = $dbh->prepare($rqt3); //prépare la requête
            $stmt3->execute([$resultat['id_bien'],$surfaceDep,$piecesDep]);
            
        }
    }

    ajoutBien($titre,$description,$type,$superficie,$surface,$pieces,$etages,$ville,$code_postal,$adresse,$prix,$surfaceDep,$piecesDep,$dateAjout,$idUser,$pseudoUser);
    header('location:../index.php?p=goods');
} else {header('location:../index.php?p=startselling'); }
?>


