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

function testMdpFromID($dbh,$iduser,$mdp){ // Renvoit true ou false
    $rqt = "SELECT `mdp` FROM `utilisateurs` WHERE IDUSER = ?";
	$stmt = $dbh->prepare($rqt); //prépare la requête
	$stmt->execute([$iduser]); //remplace les "?"  dans la requête
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

function recupInfosGoodFromGoodID($dbh,$idbien){
	$rqt = "SELECT * FROM `biens` WHERE id_bien = ?";
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$idbien]);
	$resultat = $stmt->fetch(PDO::FETCH_ASSOC);
	return $resultat;
}


function rechercheFast($dbh,$tabValeurs,$rqtComplete){
	$rqt = "SELECT * FROM `biens` ";
	$count=0;
	if(stristr($rqtComplete, "ville")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "ville = :ville ";
		$count += 1;
	}

	if(stristr($rqtComplete, "nbrePieces")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "nbr_piece = :nbrePieces ";
		$count += 1;
	}

	if(stristr($rqtComplete, "prixMax")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "prix < :prixMax ";
		$count += 1;
	}

	if(stristr($rqtComplete, "typeBien")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "type = :typeBien ";
		$count += 1;
	}
	$rqt .= "LIMIT 15";

	$stmt = $dbh->prepare($rqt);
	$stmt->execute($tabValeurs);
	$resultat = $stmt->fetchAll();
	return $resultat;
}

function recherche($dbh,$tabValeurs,$rqtComplete){
	$rqt = "SELECT * FROM `biens` ";
	$count=0;
	if(stristr($rqtComplete, "ville")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "ville = :ville ";
		$count += 1;
	}

	if(stristr($rqtComplete, "departement")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "code_postal LIKE :departement% ";
		$count += 1;
	}

	if(stristr($rqtComplete, "nbrePieces")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "nbr_piece = :nbrePieces ";
		$count += 1;
	}

	if(stristr($rqtComplete, "prixMin")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "prix > :prixMin ";
		$count += 1;
	}

	if(stristr($rqtComplete, "prixMax")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "prix < :prixMax ";
		$count += 1;
	}

	if(stristr($rqtComplete, "superficie")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "superficie > :superficie ";
		$count += 1;
	}

	if(stristr($rqtComplete, "surface")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "surface > :surface ";
		$count += 1;
	}

	if(stristr($rqtComplete, "typeBien")){
		if($count == 0){
			$rqt .= "WHERE ";
		} else {
			$rqt .= "AND ";
		}
		$rqt .= "type = :typeBien ";
		$count += 1;
	}
	$rqt .= "LIMIT 15";

	$stmt = $dbh->prepare($rqt);
	$stmt->execute($tabValeurs);
	$resultat = $stmt->fetchAll();
	return $resultat;
}

function testFavoriFromUserID($dbh,$iduser)
{
	$rqt = "SELECT * FROM `favoris` WHERE id_user = ?";
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$iduser]);
	$resultat = $stmt->fetch(PDO::FETCH_ASSOC);
	return $resultat;
}

function testFavoriFromUserIdAndBienID($dbh,$iduser,$idbien)
{
	$rqt = "SELECT * FROM `favoris` WHERE id_user = ? AND id_bien = ?";
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$iduser,$idbien]);
	$resultat = $stmt->fetch(PDO::FETCH_ASSOC);
	return $resultat;
}

function tabFavorisFromUserID($dbh,$iduser){
	$rqt = "SELECT id_bien FROM favoris WHERE id_user = ? ";
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$iduser]);
	$resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$rqt2 = "SELECT * FROM biens WHERE id_bien IN (";

	for ($i=0; $i < count($resultat); $i++) { 
		$rqt2 .= " :".chr(97+$i)." ,";
		$tabValeurs[chr(97+$i)] = $resultat[$i]['id_bien'];
	}

	$rqt2 = substr($rqt2, 0, -1);
	$rqt2 .= ")";
	$stmt2 = $dbh->prepare($rqt2);
	$stmt2->execute($tabValeurs);
	$resultat2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
	
	return $resultat2;
	
}

function recupGoodsFromUserID($dbh,$iduser){
	$rqt = "SELECT * FROM `biens` WHERE id_proprietaire = ?";
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$iduser]);
	$resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $resultat;
}

function pseudoUserFromUserID($dbh,$iduser){
	$rqt = "SELECT pseudonyme FROM utilisateurs WHERE IDUSER = ?";
	$stmt = $dbh->prepare($rqt);
	$stmt->execute([$iduser]);
	$resultat = $stmt->fetch(PDO::FETCH_ASSOC);
	return $resultat['pseudonyme'];
}

?>