<?php

include('database.php');

if(isset($_POST['fastResearch'])){
    $rqtComplete = "";
    $tabValeurs = [];
    if(isset($_POST['ville'])){
        if(ctype_alpha($_POST['ville'])){
            $tabValeurs['ville'] = $_POST['ville'];
            $rqtComplete .= "ville";
        } else {echo("error"); }
    }

    if(isset($_POST['nbrePieces'])){
        if(ctype_digit($_POST['nbrePieces'])){
            $tabValeurs['nbrePieces'] = $_POST['nbrePieces'];
            $rqtComplete .= "nbrePieces";
        } else {echo("error"); }
    }

    if(isset($_POST['prixMax'])){
        if(ctype_digit($_POST['prixMax'])){
            $tabValeurs['prixMax'] = $_POST['prixMax'];
            $rqtComplete .= "prixMax";
        } else {echo("error"); }
    }

    if(isset($_POST['typeBien'])){
        $tabValeurs['typeBien'] = $_POST['typeBien'];
        $rqtComplete .= "typeBien";
    }


    //print_r(rechercheFast(accesDB(),$tabValeurs,$rqtComplete));

    session_start(); 
    $_SESSION['research'] = rechercheFast(accesDB(),$tabValeurs,$rqtComplete);
}


if(isset($_POST['research'])){
    $rqtComplete = "";
    $tabValeurs = [];
    if(isset($_POST['ville'])){
        if(ctype_alpha($_POST['ville'])){
            $tabValeurs['ville'] = $_POST['ville'];
            $rqtComplete .= "ville";
        } else {echo("error"); }
    }

    if(isset($_POST['departement'])){
        if(ctype_digit($_POST['departement'])){
            $tabValeurs['departement'] =  substr($_POST['nbrePieces'], 0, 2);
            $rqtComplete .= "departement";
        } else {echo("error"); }
    }

    if(isset($_POST['nbrePieces'])){
        if(ctype_digit($_POST['nbrePieces'])){
            $tabValeurs['nbrePieces'] = $_POST['nbrePieces'];
            $rqtComplete .= "nbrePieces";
        } else {echo("error"); }
    }

    if(isset($_POST['prixMin'])){
        if(ctype_digit($_POST['prixMin'])){
            $tabValeurs['prixMin'] = $_POST['prixMin'];
            $rqtComplete .= "prixMin";
        } else {echo("error"); }
    }

    if(isset($_POST['prixMax'])){
        if(ctype_digit($_POST['prixMax'])){
            $tabValeurs['prixMax'] = $_POST['prixMax'];
            $rqtComplete .= "prixMax";
        } else {echo("error"); }
    }

    if(isset($_POST['superficie'])){
        if(ctype_digit($_POST['superficie'])){
            $tabValeurs['superficie'] = $_POST['superficie'];
            $rqtComplete .= "superficie";
        } else {echo("error"); }
    }

    if(isset($_POST['surface'])){
        if(ctype_digit($_POST['surface'])){
            $tabValeurs['surface'] = $_POST['surface'];
            $rqtComplete .= "surface";
        } else {echo("error"); }
    }

    if(isset($_POST['typeBien'])){
        $tabValeurs['typeBien'] = $_POST['typeBien'];
        $rqtComplete .= "typeBien";
    }

    //print_r(rechercheFast(accesDB(),$tabValeurs,$rqtComplete));

    session_start(); 
    $_SESSION['research'] = recherche(accesDB(),$tabValeurs,$rqtComplete);
}

header('location:../index.php?p=research');

?>