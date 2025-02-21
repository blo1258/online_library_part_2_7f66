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
        
          $bookName = $_POST['books'];
          $catId = $_POST['CatId'];
          $authorId = $_POST['AuthorId'];
          $isbn = $_POST['ISBNNumber'];
          $price = $_POST['BookPrice'];
         
          // On prepare la requete d'insertion dans la table tblcategory
          $sql = "INSERT INTO tblbooks(bookName,catId,authorId,ISBNNumber,BookPrice) VALUES (:BookName,:CatId,:AuthorId,:ISBNNumber,:BookPrice)";
          $query = $dbh->prepare($sql);
          
          // On recupere le nom et le statut de la categorie
          // On prepare la requete d'insertion dans la table tblcategory
          // On execute la requete
          
  
  $query->bindParam(':BookName', $bookName, PDO::PARAM_STR);
  $query->bindParam(':CatId', $catId, PDO::PARAM_INT);
  $query->bindParam(':AuthorId', $authorId, PDO::PARAM_INT);
  $query->bindParam(':ISBNNumber', $isbn, PDO::PARAM_STR);
  $query->bindParam(':BookPrice', $price, PDO::PARAM_STR);

      if ($query->execute()) {
          $_SESSION['message'] = "Livre ajouté avec succès";
             
       } else {
          $_SESSION['message'] = "Echec de l'ajout de le livre";
       }

       header('location:add-book.php');
            exit();
      }

?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Ajout de livres</title>
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
        <h2>AJOUTER UN LIVRE</h2>
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
            <label for="books">Titre<span style="color: red;">*</span> </label>
            <input type="text" class="form-control" id="books" name="books" required>
        </div>
        <div class="form-group">
            <label for="CatId">Categorie<span style="color: red;">*</span> </label>
            <select class="form-control" id="CatId" name="CatId" required>
                <option value="">Selectionner une categorie</option>
                <?php
                $sql = "SELECT * FROM  tblcategory";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                        ?>
                        <option value="<?php echo $result->id; ?>"><?php echo $result->CategoryName; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="AuthorId">Auteur<span style="color: red;">*</span> </label>
            <select class="form-control" id="AuthorId" name="AuthorId" required>
                <option value="">Selectionner un auteur</option>
                <?php
                $sql = "SELECT * FROM  tblauthors";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                        ?>
                        <option value="<?php echo $result->id; ?>"><?php echo $result->AuthorName; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="isbn">ISBN <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="ISBNNumber" name="ISBNNumber" required>
            <p style="font-size:12px; color:grey;">Le numéro ISBN doit être unique</p>
        </div>
        <div class="form-group">
            <label for="price">Prix <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="BookPrice" name="BookPrice" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
