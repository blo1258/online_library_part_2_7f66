


<?php
session_start();
global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');


// Si l'utilisateur n'est plus logué
// On le redirige vers la page de login
// Sinon on peut continuer. Après soumission du formulaire de creation    
 
if (!isset($_SESSION['alogin'])) {
    $_SESSION['msg'] = "Erreur: ID du livre manquant!";
    header('location:/online_library_part_1/adminlogin.php');
    exit;
} 
    // Si le formulaire a été soumis
    if (isset($_POST['submit'])) {
        // On recupere le nom et le statut de la categorie
        $category = $_POST['category'];
        $status = $_POST['status'];
        // On prepare la requete d'insertion dans la table tblcategory
        $sql = "INSERT INTO  tblcategory(CategoryName,Status) VALUES(:category,:status)";
        $query = $dbh->prepare($sql);
        
        // On recupere le nom et le statut de la categorie
        // On prepare la requete d'insertion dans la table tblcategory
        // On execute la requete
        
$query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);

        if ($query->execute()) {
            // On stocke dans $_SESSION le message correspondant au resultat de loperation
            $_SESSION['message'] = "La catégorie a été ajoutée avec succès";
        } else {
            $_SESSION['message'] = "Une erreur s'est produite. Veuillez réessayer";
            print_r($query->errorInfo());
        }   
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
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <!-- On affiche le titre de la page-->
     
    <div class = "container">
        <h2>Ajouter une Categorie</h2>
    <!-- Affichage des messages -->
    <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
    
        <!-- On affiche le formulaire de creation-->
     <form method="post" action="">
        <div class="form-group">
            <label for="category">Nom </label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>
        <div class="form-group">
            <label for="status">Statut</label>
            <div class="radio">
                <label>
                    <input type="radio" name="status" id="status" value="1" checked>Active
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="status" id="status" value="0">Inactive
                </label>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
    <!-- Par defaut, la categorie est active-->
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>