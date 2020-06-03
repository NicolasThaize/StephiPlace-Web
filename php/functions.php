<?php

function testConnexion($pseudo,$mdp){
    $dbh=accesDB();
	return testMdp($dbh,$pseudo,$mdp);
}

?>