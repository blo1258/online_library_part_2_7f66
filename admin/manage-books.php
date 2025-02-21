<?php
session_start();
global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');

$sql = "SELECT * FROM tblbooks";
$query = $dbh->prepare($sql);
$query->execute();
$books = $query->fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Gestion livres</title>
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

<div class="container mt-4">
      <h2>Gestion des Livres</h2>
      <table class="table table-bordered">
            <thead>
            <tr>
                  <th>#</th>
                  <th>ISBN</th>
                  <th>Titre</th>
                  <th>Auteur</th>
                  <th>Quantité</th>
                  <th>Prix</th>
                  <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($books as $book) { ?>
                  <tr>
                  <td><?php echo $book['id']; ?></td>
                  <td><?php echo $book['ISBNNumber']; ?></td>
                  <td><?php echo $book['BookName']; ?></td>
                  <td><?php echo $book['AuthorId']; ?></td>
                  <td><?php echo $book['CatId']; ?></td>
                  <td><?php echo $book['BookPrice']; ?></td>
                  <td>
                  <a href="edit-book.php?id=<?php echo $book['id']; ?>" class="btn btn-primary">Editer</a>
                  <a href="delete-book.php?id=<?php echo $book['id']; ?>" class="btn btn-danger" onclick="return confirm('Voulez-vouz vraiment supprimer ce livre ?');">Supprimer</a>
                  </td>
                  </tr>
            <?php } ?>
            </tbody>
      </table>

</div>

<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
