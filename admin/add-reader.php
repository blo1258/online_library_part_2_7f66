<?php
session_start();
global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');


if (!isset($_SESSION['alogin'])) {
    $_SESSION['msg'] = "Erreur: ID du livre manquant!";
    header('location:/online_library_part_1/adminlogin.php');
    exit;
}
      // Si le formulaire a été soumis
      if (isset($_POST['submit'])) {
          // On recupere le nom et le statut de la categorie
        
          $fullName = $_POST['FullName'];
          $status = $_POST['Status'];
          
          $mobilNumber = $_POST['MobileNumber'];
          $email = isset($_POST['EmailId']) ? $_POST['EmailId'] : null;

         
          // On prepare la requete d'insertion dans la table tblcategory
          $sql = "INSERT INTO tblreaders(fullName,status,mobilNumber,email) VALUES (:FullName,:Status,:MobileNumber,:EmailId)";
          $query = $dbh->prepare($sql);
          
          // On recupere le nom et le statut de la categorie
          // On prepare la requete d'insertion dans la table tblcategory
          // On execute la requete
          
  
  $query->bindParam(':FullName', $fullName, PDO::PARAM_STR);
  $query->bindParam(':Status', $status, PDO::PARAM_INT);
  
  $query->bindParam(':MobileNumber', $mobilNumber, PDO::PARAM_STR);
  $query->bindParam(':EmailId', $email, PDO::PARAM_STR);

      if ($query->execute()) {
          $_SESSION['message'] = "Lecteur ajouté avec succès";
             
       } else {
          $_SESSION['message'] = "Echec de l'ajout de le lecteur";
       }

       header('location:add-reader.php');
            exit();
      }

?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Ajout de lecteurs</title>
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
        <h2>AJOUTER UN LECTEUR</h2>
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
            <label for="email">E-Mail<span style="color: red;">*</span> </label>
            <input type="text" class="form-control" id="email" name="EmailId" required>
        </div>
        <div class="form-group">
        <label for="fullName">Nom et Prenom<span style="color: red;">*</span> </label>
        <input type="text" class="form-control" id="fullName" name="FullName" required>
              
            
        </div>
        <div class="form-group">
            <label for="tlf">Numero de Telephone <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="tlf" name="MobileNumber" required>
            
        </div>
        <div class="form-group">
            <label for="status">Status <span style="color: red;">*</span></label>
            <input type="text" class="form-control"  name="Status" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
