<?php

function accesDB(){ 
    try { //Execute cette ligne
		$dbh = new PDO("mysql: host=localhost;dbname=stephiplace;port=3308", "root" , "");
	} catch (Exception $e) { //Si il y a une erreur 
		print ($e->getMessage()); //revoit l'erreur
		exit; //stop le programme
	}
	return $dbh;
}

function testMdp($dbh,$pseudo,$mdp){ // Renvoit true ou false
    $rqt = "SELECT `mdp` FROM `utilisateurs` WHERE pseudonyme = ?";
	$stmt = $dbh->prepare($rqt); //prépare la requête
	$stmt->execute([$pseudo]); //remplace les "?"  dans la requête
	$resultat = $dbh->query($rqt);
	while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) { //tant que le fetch renvoit qq chose
		foreach ($line as $key => $val) { // print chaque ligne
			$mdpBDD=$val;
		}
    }
	return password_verify($mdp,$mdpBDD);
}

function recupIdFromPseudo($dbh,$pseudo){ // Renvoit l'id de l'utilisateur 
    $rqt = "SELECT `IDUSER` FROM `utilisateurs` WHERE pseudonyme = ?";
	$stmt = $dbh->prepare($rqt); //prépare la requête
	$stmt->execute([$pseudo]); //remplace les "?"  dans la requête
	$resultat = $dbh->query($rqt);
	while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) { //tant que le fetch renvoit qq chose
		foreach ($line as $key => $val) { // print chaque ligne
			$IDUSER=$val;
		}
	}
	return $IDUSER;
}

function recupInfosUserFromUserID($dbh,$iduser){
	$rqt = "SELECT * FROM `utilisateurs` WHERE IDUSER = ?";
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$iduser]);
	$resultat = $stmt->fetch(PDO::FETCH_ASSOC);
	return $resultat;
}


?>