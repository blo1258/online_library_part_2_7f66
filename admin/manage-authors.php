<?php
session_start();

global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');

// Si l'utilisateur n'est plus logué
if (!isset($_SESSION['alogin'])) {
    $_SESSION['msg'] = "Erreur: ID du auteur manquant!";
    header('location:/online_library_part_1/adminlogin.php');
    exit;
}
     // Sinon
     // Apres soumission du formulaire de categorie
 
     // On recupere l'identifiant, le statut, le nom
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         if (!isset($_POST['id'])) {
             echo "Erreur";
             exit;
         }
         $identifiant = isset ($_POST['id']) ? $_POST['id'] : '';
         $auteurNom = $_POST['AuthorName'];
         $creationDate = $_POST['creationDate'];
         $updateDate = $_POST['UpdateDate'];
         
         
    
     // On prepare la requete de mise a jour
     // On prepare la requete de recherche des elements de la categorie dans tblcategory
     
     // On execute la requete
    
     $query->bindParam(':identifiant', $identifiant, PDO::PARAM_STR);
     $query->bindParam(':AuthorName', $auteurNom, PDO::PARAM_STR);
     $query->bindParam(':creationDate', $creationDate, PDO::PARAM_INT);
     $query->execute();
     
     // On stocke dans $_SESSION le message "Categorie mise a jour"
     $_SESSION['msg'] = "Categorie mise a jour";
     // On redirige l'utilisateur vers edit-categories.php
     header('location:edit-author.php');
     exit;
     }
 
 $identifiant = isset($_POST['id']) ? $_POST['id'] : '';

 $sql = "SELECT * FROM  tblauthors";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
 ?>


<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Auteurs</title>
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

<div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Gestion des Auteurs</h4>
                <table class = "table table-bordered">
       <!-- On gère l'affichage des boutons Actif/Inactif/Supprimer en fonction de la valeur du statut du lecteur -->
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
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
                <td><?php echo htmlentities($result->AuthorName);?></td>
                
                <td><?php echo htmlentities($result->creationDate);?></td>
                <td><?php echo htmlentities($result->UpdationDate);?></td>
                <td>
                    <!-- On affiche les boutons Actif/Inactif/Supprimer en fonction de la valeur du statut du lecteur -->
                    <a href="edit-author.php?id=<?php echo htmlentities($result->id);?>">
                        <button type = "submit" class="btn btn-primary">Editer</button>
                    </a>
                    <form method="POST" action="manage-authors.php" style="display:inline-block;">
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

<!-- MENU SECTION END-->

     <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
