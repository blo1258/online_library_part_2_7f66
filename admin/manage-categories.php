<?php
// On recupere la session courante


global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');


// On informe l'utilisateur du resultat de loperation

// On redirige l'utilisateur vers la page manage-categories.php
$sql = "SELECT * FROM  tblcategory";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Gestion categories</title>
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
    <!-- On affiche le formulaire de gestion des categories-->
     <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Gestion des catégories</h4>
           
                <?php if(isset($_SESSION['msg']) && $_SESSION['msg']!="") {?>
                <div class="alert alert-info" role="alert">
                    <?php echo htmlentities($_SESSION['msg']); ?>
                </div>
                <?php } ?>
                <table class = "table table-bordered">
       <!-- On gère l'affichage des boutons Actif/Inactif/Supprimer en fonction de la valeur du statut du lecteur -->
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Statut</th>
                <th>Créé le</th>
                <th>Mis a jour le </th>
                <th>Action</th>
            </tr>
        </thead> 
        <tbody>
        <?php $cnt = 1;
            // On parcourt la liste des lecteurs
            foreach($results as $result) {
            ?>
             <tr>
                <td><?php echo htmlentities($cnt++);?></td>
                <td><?php echo htmlentities($result->CategoryName);?></td>
                <td><?php echo ($result->Status == 1) ? '<span class = "badge badge-success">Actif</span>' : '<span class = "badge badge-danger">Inactif</span>';?></td>
                <td><?php echo htmlentities($result->CreationDate);?></td>
                <td><?php echo htmlentities($result->UpdationDate);?></td>
                <td>
                    <!-- On affiche les boutons Actif/Inactif/Supprimer en fonction de la valeur du statut du lecteur -->
                    <a href="edit-category.php?id=<?php echo htmlentities($result->id);?>">
                        <button type = "submit" class="btn btn-primary">Editer</button>
                    </a>
                    <form method="POST" action="manage-categories.php" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo htmlentities($result->id);?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette categorie?');">Supprimer</button>
                    </form>
                   
              
            </tr>
    
                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>