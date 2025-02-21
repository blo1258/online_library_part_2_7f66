<?php

// On démarre (ou on récupère) la session courante
session_start();
global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');

// On inclue le fichier de configuration et de connexion à la base de données


if (strlen($_SESSION['alogin']) == 0) {
  // Si l'utilisateur est déconnecté
  // L'utilisateur est renvoyé vers la page de login : index.php
  header('location:/online_library_part_1/index.php');
} else {
  // sinon on récupère les informations à afficher depuis la base de données
  // On récupère le nombre de livres depuis la table tblbooks
  $sql = "SELECT COUNT(*) FROM tblbooks";
  $query = $dbh->prepare($sql);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_BOTH);
  // On récupère le nombre de livres en prêt depuis la table tblissuedbookdetails
  $sql1 = "SELECT COUNT(*) FROM tblissuedbookdetails WHERE ReturnStatus=0";
  $query1 = $dbh->prepare($sql1);
  $query1->execute();
  $result1 = $query1->fetch(PDO::FETCH_BOTH);
  // On récupère le nombre de livres retournés  depuis la table tblissuedbookdetails
  // Ce sont les livres dont le statut est à 1
  $sql2 = "SELECT COUNT(*) FROM tblissuedbookdetails WHERE ReturnStatus=1";
  $query2 = $dbh->prepare($sql2);
  $query2->execute();
  $result2 = $query2->fetch(PDO::FETCH_BOTH);

  // On récupère le nombre de lecteurs dans la table tblreaders
  $sql3 = "SELECT COUNT(*) FROM tblreaders";
  $query3 = $dbh->prepare($sql3);
  $query3->execute();
  $result3 = $query3->fetch(PDO::FETCH_BOTH);

  // On récupère le nombre d'auteurs dans la table tblauthors
  $sql4 = "SELECT COUNT(*) FROM tblauthors";
  $query4 = $dbh->prepare($sql4);
  $query4->execute();
  $result4 = $query4->fetch(PDO::FETCH_BOTH);

  // On récupère le nombre de catégories dans la table tblcategory
  $sql5 = "SELECT COUNT(*) FROM tblcategory";
  $query5 = $dbh->prepare($sql5);
  $query5->execute();
  $result5 = $query5->fetch(PDO::FETCH_BOTH);
  
?>
  <!DOCTYPE html>
  <html lang="FR">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion de bibliothèque en ligne | Tab bord administration</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />

  
    
  </head>

  <body>
    <!--On inclue ici le menu de navigation includes/header.php-->
    <?php include('includes/header.php'); ?>
    <!-- On affiche le titre de la page : TABLEAU DE BORD ADMINISTRATION-->
    <div class="container">
      <div class="row">
        <div class="col">
          <h3>TABLEAU DE BORD ADMINISTRATION</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 col-md-3">
          <!-- On affiche la carte Nombre de livres -->
          <div class="alert alert-succes text-center">
            <span class="fa fa-book fa-5x">
              <h3><?php echo $result[0]; ?></h3>
            </span>
            Nombre de livre
          </div>
        </div>
        <div class="col-sm-3 col-md-3">
          <!-- On affiche la carte Livres en pr�t -->
          <div class="alert alert-succes text-center">
            <span class="fa fa-book fa-5x">
              <h3><?php echo $result1[0]; ?></h3>

            </span>
            Livres en pret
          </div>
        </div>
        <div class="col-sm-3 col-md-3">
          <!-- On affiche la carte Livres retourn�s -->
          <div class="alert alert-succes text-center">
            <span class="fa fa-bars fa-5x">
              <h3><?php echo $result2[0]; ?></h3>

            </span>
            Livres retournés
          </div>
        </div>
        <div class="col-sm-3 col-md-3">
          <!-- On affiche la carte Lecteurs -->
          <div class="alert alert-succes text-center">
            <span class="fa fa-recycle fa-5x">
              <h3><?php echo $result3[0]; ?></h3>

            </span>
            Lecteurs
          </div>
        </div>
        <div class="col-sm-3 col-md-3">
          <!-- On affiche la carte Auteurs -->
          <div class="alert alert-succes text-center">
            <span class="fa fa-users fa-5x">
              <h3><?php echo $result4[0]; ?></h3>

            </span>
            Auteurs
          </div>
        </div>
        <div class="col-sm-3 col-md-3">
          <!-- On affiche la carte Cat�gories -->
          <div class="alert alert-succes text-center">
            <span class="fa fa-bars fa-5x">
              <h3><?php echo $result5[0]; ?></h3>

            </span>
            Catégories
          </div>

        </div>
      </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
  </body>

  </html>
<?php } ?>