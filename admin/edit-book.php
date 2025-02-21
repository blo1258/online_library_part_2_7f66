<?php
session_start();
global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');





if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $sql = "SELECT * FROM tblbooks WHERE id = :id";
      $query = $dbh->prepare($sql);
      $query->bindParam(':id', $id, PDO::PARAM_INT);
      $query->execute();
      $book = $query->fetch(PDO::FETCH_ASSOC);
  
        if (!$book) {
            $_SESSION['message'] = "Livre non trouvé";
            header('location:manage-books.php');
            exit();
        }
  
    }
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
         
      // Si le formulaire a été soumis
      if (isset($_POST['submit'])) {
          // On recupere le nom et le statut de la categorie
          $id = $_POST['id'];  
          $bookName = $_POST['BookName'];
          $catId = $_POST['CatId'];
          $authorId = $_POST['AuthorId'];
          $isbn = $_POST['ISBNNumber'];
          $price = $_POST['BookPrice'];
      }
          // On prepare la requete d'insertion dans la table tblcategory
          $sql = "UPDATE tblbooks SET BookName = :BookName, CatId = :CatId, AuthorId = :AuthorId, ISBNNumber = :ISBNNumber, BookPrice = :BookPrice WHERE id = :id";
          $query = $dbh->prepare($sql);
          
          // On recupere le nom et le statut de la categorie
          // On prepare la requete d'insertion dans la table tblcategory
          // On execute la requete
          
  $query->bindParam(':id', $id, PDO::PARAM_INT);
  $query->bindParam(':BookName', $bookName, PDO::PARAM_STR);
  $query->bindParam(':CatId', $catId, PDO::PARAM_INT);
  $query->bindParam(':AuthorId', $authorId, PDO::PARAM_INT);
  $query->bindParam(':ISBNNumber', $isbn, PDO::PARAM_STR);
  $query->bindParam(':BookPrice', $price, PDO::PARAM_STR);

      if ($query->execute()) {
          $_SESSION['message'] = "Livre edité avec succès";
             
       } else {
          $_SESSION['message'] = "Echec de l'edite de le livre";
       }

       header('location:edit-book.php?id='.$id);
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
        <h2>EDITER LE LIVRE</h2>
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
       <input type="hidden" class="form-control" name="id" value="<?php echo isset($book['id']) ? $book['id'] : ''; ?>">
            </div>
       
      <div class="form-group">
            <label for="books">Titre </label>
            <input type="text" class="form-control" name="BookName" value="<?php echo htmlspecialchars($book['BookName'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="CatId">Categorie </label>
            <select class="form-control" name="CatId" value="<?php echo $book['CatId']; ?>" required>
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
            <label for="AuthorId">Auteur </label>
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
            <label for="isbn">ISBN </label>
            <input type="text" class="form-control" name="ISBNNumber" value="<?php echo $book['ISBNNumber']; ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Prix </label>
            <input type="text" class="form-control" name="BookPrice" value="<?php echo $book['BookPrice']; ?>" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Mettre a jour</button>
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>