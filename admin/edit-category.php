<?php
session_start();

global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');

// Si l'utilisateur n'est plus logué
 
    // Sinon
    // Apres soumission du formulaire de categorie

    // On recupere l'identifiant, le statut, le nom
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['id'])) {
            echo "Erreur";
            exit;
        }
        $identifiant = isset ($_POST['id']) ? $_POST['id'] : '';
        $status = $_POST['status'];
        $category = $_POST['category'];
        
        // On prepare la requete de mise a jour
        $sql = "UPDATE tblcategory SET CategoryName=:category,Status=:status WHERE id=:identifiant";
        // On prepare la requete de recherche des elements de la categorie dans tblcategory
        $query = $dbh->prepare($sql);
        
   
    // On prepare la requete de mise a jour
    // On prepare la requete de recherche des elements de la categorie dans tblcategory
    
    // On execute la requete
   
    $query->bindParam(':identifiant', $identifiant, PDO::PARAM_INT);
    $query->bindParam(':category', $category, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->execute();
    
    // On stocke dans $_SESSION le message "Categorie mise a jour"
    $_SESSION['msg'] = "Categorie mise a jour";
    // On redirige l'utilisateur vers edit-categories.php
    header('location:edit-category.php');
    exit;
    }

$identifiant = isset($_POST['id']) ? $_POST['id'] : '';
?>
<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Categories</title>
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
    <!-- On affiche le titre de la page "Editer la categorie-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="header-line">Editer la categorie</h4>
            </div>
        </div>
        <!-- On affiche le formulaire dedition-->
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <!-- On affiche ici le formulaire d'édition -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Formulaire d'édition
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="edit-category.php">
                            <input type="hidden" name="id" value="<?php echo htmlentities($identifiant); ?>" />
                            <!-- On affiche le message de succes-->
                            <?php if ($_SESSION['msg'] != '') { ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo htmlentities($_SESSION['msg']); ?>
                                </div>
                            <?php } ?>
                            <!-- On recupere l'identifiant de la categorie-->
                            <?php
                          
                            $sql = "SELECT * FROM tblcategory WHERE id=:identifiant";
                            // On prepare la requete de recherche des elements de la categorie dans tblcategory
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':identifiant', $identifiant, PDO::PARAM_STR);
                            $query->execute();
                            $categoryDetails = $query->fetch(PDO::FETCH_ASSOC);
                            ?>
                        </form>
            </div>
        </div>
    </div>
</div>
</div>
        
        <!-- Si la categorie est active (status == 1)-->
        <!-- On coche le bouton radio "actif"-->
        <!-- Sinon-->
        <!-- On coche le bouton radio "inactif"-->

        <!-- CONTENT-WRAPPER SECTION END-->
        <?php include('includes/footer.php'); ?>
        <!-- FOOTER SECTION END-->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>