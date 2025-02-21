<?php
session_start();
global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');

if (!isset($_SESSION['alogin'])) {
    $_SESSION['msg'] = "Erreur: ID du auteur manquant!";
    header('location:/online_library_part_1/adminlogin.php');
    exit;
} 
      // Si le formulaire a été soumis
      if (isset($_POST['submit'])) {
          // On recupere le nom et le statut de la categorie
          $author = $_POST['authors'];
         
          // On prepare la requete d'insertion dans la table tblcategory
          $sql = "INSERT INTO  tblauthors(AuthorName) VALUES (:AuthorName)";
          $query = $dbh->prepare($sql);
          
          // On recupere le nom et le statut de la categorie
          // On prepare la requete d'insertion dans la table tblcategory
          // On execute la requete
          
  $query->bindParam(':AuthorName', $author, PDO::PARAM_STR);
      if ($query->execute()) {
          $_SESSION['message'] = "Auteur ajouté avec succès";
             
       } else {
          $_SESSION['message'] = "Echec de l'ajout de l'auteur";
       }

       header('location:add-author.php');
            exit();
      }

?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Ajout de categories</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>


      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
     <!-- CONTENT-WRAPPER SECTION END-->

     <div class = "container">
        <h2>AJOUTER UN AUTEUR</h2>
    <!-- Affichage des messages -->
    <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
    
        <!-- On affiche le formulaire de creation-->
     <form method="post">
        <div class="form-group">
            <label for="authors">Nom </label>
            <input type="text" class="form-control" id="authors" name="authors" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
