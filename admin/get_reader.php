<?php 

session_start();

error_log(print_r($_POST, true));

global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ReaderId'])) {
	$readerId = trim($_POST['ReaderId']);
	
	$sql = "SELECT FullName FROM tblreaders WHERE ReaderId = :ReaderId";
	$query = $dbh->prepare($sql);
	$query->bindParam(':ReaderId', $readerId, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetch(PDO::FETCH_OBJ);
	if ($results) {
		echo $results->FullName;
	} else {
		echo "Le lecteur est non valide";
	}
	exit();
}
/* Cette fonction est declenchee au moyen d'un appel AJAX depuis le formulaire de sortie de livre */
/* On recupere le numero l'identifiant du lecteur SID---*/

// On prepare la requete de recherche du lecteur correspondnat
// On execute la requete
// Si un resultat est trouve
	// On affiche le nom du lecteur
	// On active le bouton de soumission du formulaire
// Sinon
	// Si le lecteur n existe pas
		// On affiche que "Le lecteur est non valide"
		// On desactive le bouton de soumission du formulaire
	// Si le lecteur est bloque
		// On affiche lecteur bloque
		// On desactive le bouton de soumission du formulaire

?>
