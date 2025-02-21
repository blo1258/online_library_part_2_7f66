<?php 
/* Cette fonction est declenchee au moyen d'un appel AJAX depuis le formulaire de sortie de livre */
session_start();

global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');
    
/* On recupere le numero ISBN du livre*/


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ISBNNumber'])) {
    $isbn = $_POST['ISBNNumber'];
    
    error_log("ISBNNumber: " . $isbn);
   
    $sql = "SELECT BookName FROM tblbooks WHERE ISBNNumber = :isbn";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
    $query->execute();
    
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo  $result['BookName'];
    } else {
        echo "not_found";
    }
    exit();
}












if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['BookId'])) {
    $isbn = trim($_POST['BookId']);


// On prepare la requete de recherche du livre correspondnat
$sql = "SELECT BookName FROM tblbooks WHERE BookId = :isbn";
$query = $dbh->prepare($sql);
$query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
$query->execute();

// On execute la requete
$result = $query->fetch(PDO::FETCH_ASSOC);

// Si un resultat est trouve
if ($result) {
	// On affiche le nom du livre
	echo $result['BookName'];
	// On active le bouton de soumission du formulaire
} else {
	// Sinon
	// On affiche que "ISBN est non valide"
	echo "ISBN is not valid";
	// On desactive le bouton de soumission du formulaire 
}
exit();
}
?>
