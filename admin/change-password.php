<?php
session_start();

global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');

// Si l'utilisateur n'est plus logué
// On le redirige vers la page de login
if (strlen($_SESSION['login']) == 0) {
	header('location:/online_library_part_1.php');
	exit;
}
// Sinon on peut continuer. Après soumission du formulaire de modification du mot de passe
// Si le formulaire a bien ete soumis
if (isset($_POST['submit'])) {
	// On recupere le mot de passe courant
	$currentPassword = $_POST['current_password'];
	// On recupere le nouveau mot de passe
	$newPassword = $_POST['new_password'];
	$confirmPassword = $_POST['confirm_password'];
	// On recupere le nom de l'utilisateur stocké dans $_SESSION
	$userEmail = $_SESSION['login'];
	// On prepare la requete de recherche pour recuperer l'id de l'administrateur (table admin)
	// dont on connait le nom et le mot de passe actuel
	
	if ($newPassword !== $confirmPassword) {
		$_SESSION['error'] = "Les mots de passe ne correspondent pas";
	} else {
	$sql = "SELECT Password FROM tblreaders WHERE EmailId = :email";
	$query = $dbh->prepare($sql);
	$query->bindValue(':email', $userEmail, PDO::PARAM_STR);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);
	// Si on trouve un resultat
	if ($result) {
		// On prepare la requete de mise a jour du nouveau mot de passe de cet id
		$sql = "UPDATE tblreaders SET Password = :password WHERE EmailId = :email";
		$query = $dbh->prepare($sql);
		$query->bindValue(':password', password_hash($newPassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
		$query->bindValue(':email', $userEmail, PDO::PARAM_STR);
		$query->execute();
		// On stocke un message de succès de l'operation
		$_SESSION['msg'] = "Mot de passe modifié avec succès";
		// On purge le message d'erreur
		unset($_SESSION['error']);
	} else {
		// Sinon on a trouve personne
		// On stocke un message d'erreur
		$_SESSION['error'] = "Mot de passe actuel incorrect";
	}
}
} else {
	// Sinon le formulaire n'a pas encore ete soumis
	// On initialise le message de succes et le message d'erreur (chaines vides)
	$_SESSION['msg'] = "";
	$_SESSION['error'] = "";
}

?>

<!DOCTYPE html>
<html lang="FR">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Gestion bibliotheque en ligne</title>
	<!-- BOOTSTRAP CORE STYLE  -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- FONT AWESOME STYLE  -->
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<!-- CUSTOM STYLE  -->
	<link href="assets/css/style.css" rel="stylesheet" />
	<!-- Penser a mettre dans la feuille de style les classes pour afficher le message de succes ou d'erreur  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>


<body>
	<!------MENU SECTION START-->
	<?php include('includes/header.php'); ?>
	
	
	<!-- MENU SECTION END-->
	<!-- On affiche le titre de la page "Changer de mot de passe"  -->
	 <div class= "container">
		<h2>Changer le mot de passe</h2>
	<!-- On affiche le message de succes ou d'erreur  -->
	
	
		<!-- On affiche le formulaire de changement de mot de passe-->
		<form method="post" onsubmit="return valid();">
		<div class="form-group-pasword">
			<label for="current_password">Mot de passe actuel</label>
			<div class="input-group">
			<input type="password" class="form-control" id="current_password" name="current_password" required>
			<div class="input-group-append">
			<span class="input-group-text toggle-password" data-target="current_password">
                <i class="fa fa-eye"></i>
			</span>
			</div>
			</div>				
			</div>
		<div class="form-group-pasword">
			<label for="new_password">Nouveau mot de passe</label>
			<div class="input-group">
			<input type="password" class="form-control" id="new_password" name="new_password" required>
			<div class="input-group-append">
			<span class="input-group-text toggle-password" data-target="new_password">
				<i class="fa fa-eye"></i>
			</span>
			</div>
			</div>
		</div>		
		
			<div class="form-group-pasword">
			<label for="confirm_password">Confirmer le mot de passe</label>
			<div class="input-group">
			<input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
			<div class="input-group-append">
			<span class="input-group-text toggle-password" data-target="confirm_password">
				<i class="fa fa-eye"></i>
			</span>

		</div>
		</div>
	</div>
	<button type="submit" name="submit" class="btn btn-primary">Changer</button>
	</form>
	</div>

	<!-- CONTENT-WRAPPER SECTION END-->
	<?php include('includes/footer.php'); ?>
<!-- La fonction JS valid() est appelee lors de la soumission du formulaire onSubmit="return valid();" -->

<script type="text/javascript">
	// On cree une fonction JS valid() qui renvoie
	// true si les mots de passe sont identiques
	// false sinon
	function valid() {
		let newPassword = document.getElementById('new_password').value;
		let confirmPassword = document.getElementById('confirm_password').value;
		if (newPassword !== confirmPassword) {
			alert("Les deux mots de passe ne correspondent pas !!");
			document.getElementById('confirm_password').focus();
			return false;
		}
	}

	document.addEventListener("DOMContentLoaded", function() {
		const toggleButton = document.querySelectorAll('.toggle-password');

		toggleButton.forEach(function(button) {
			button.addEventListener('click', function() {
				const input = document.getElementById(this.dataset.target);
				if (input.getAttribute('type') === 'password') {
					input.setAttribute('type', 'text');
				} else {
					input.setAttribute('type', 'password');
				}
			});
		});
	});
</script>
	<!-- FOOTER SECTION END-->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

	<style>
		.form-group-pasword {
			display: flex;
			flex-direction: column;
			justify-content: center;
			width: 50%;
		}
	</style>


</body>

</html>