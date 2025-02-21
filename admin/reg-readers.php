<?php
// On démarre ou on récupère la session courante
session_start();
global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');
// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');

// Si l'utilisateur n'est logué ($_SESSION['alogin'] est vide)
if(strlen($_SESSION['alogin'])==0){
    // On le redirige vers la page de login
    header('location:index.php');

// Sinon on affiche la liste des lecteurs de la table tblreaders
}else{
    // On récupère tous les lecteurs de la table tblreaders
    if ( isset($_GET['inid']) && isset($_GET['inid']) != "") {
        // Si l'identifiant du lecteur est passé en paramètre
        // On met à jour le statut du lecteur dans la table tblreaders
        $id = $_GET['inid'];
        $sql = "UPDATE tblreaders SET status=1 WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        // On stocke un message de succès
        $_SESSION['msg']="Lecteur activé avec succès";
        header('location:reg-readers.php');
    }
    // On affiche le nombre de lecteurs
    

// Lors d'un click sur un bouton "inactif", on récupère la valeur de l'identifiant

// du lecteur dans le tableau $_GET['inid']

// et on met à jour le statut (0) dans la table tblreaders pour cet identifiant de lecteur
    if(isset($_GET['inid']) && $_GET['inid']!=""){
        $id=$_GET['inid'];
        $sql = "UPDATE tblreaders SET status=0 WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id',$id,PDO::PARAM_STR);
        $query->execute();
        $_SESSION['msg']="Lecteur inactivé avec succès";
        header('location:reg-readers.php');
    }
// Lors d'un click sur un bouton "actif", on récupère la valeur de l'identifiant
// du lecteur dans le tableau $_GET['id']
// et on met à jour le statut (1) dans  table tblreaders pour cet identifiant de lecteur
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $id = $_GET['id'];
        $sql = "UPDATE tblreaders SET status=1 WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['msg'] = "Lecteur activé avec succès";
        header('location:reg-readers.php');
    }
// Lors d'un click sur un bouton "supprimer", on récupère la valeur de l'identifiant
// du lecteur dans le tableau $_GET['del']
// et on met à jour le statut (2) dans la table tblreaders pour cet identifiant de lecteur
    if (isset($_GET['del']) && $_GET['del'] != "") {
        $id = $_GET['del'];
        $sql = "UPDATE tblreaders SET status=2 WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Lecteur supprimé";
        header('location:reg-readers.php');
    }
// On récupère tous les lecteurs dans la base de données
$sql = "SELECT * from  tblreaders";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion de bibliothèque en ligne | Reg lecteurs</title>
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
    <!-- Titre de la page (Gestion du Registre des lecteurs) -->
    <div class = "container">
    <div class="row pad-botm">
    <div class="col-md-12">
    <h4 class="header-line">Gestion du Registre des Lecteurs</h4>
    </div>
    </div>
    <!--On insère ici le tableau des lecteurs.-->
    <table class = "table table-bordered">
       <!-- On gère l'affichage des boutons Actif/Inactif/Supprimer en fonction de la valeur du statut du lecteur -->
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Numéro de lecteur</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Statut</th>
                <th>Créé le</th>
                <th>Action</th>
            </tr>
        </thead>
        
            <?php $cnt = 1;
            // On parcourt la liste des lecteurs
            foreach($results as $result) {
            ?>
            <tr>
                <td><?php echo htmlentities($cnt++);?></td>
                <td><?php echo htmlentities($result->FullName);?></td>
                <td><?php echo htmlentities($result->ReaderId);?></td>
                <td><?php echo htmlentities($result->EmailId);?></td>
                <td><?php echo htmlentities($result->MobileNumber);?></td>
                <td><?php if($result->Status==1){?>
                    <span style="color:green" >Actif</span>
                    <?php } else if($result->Status==0) { ?>
                    <span style="color:red">Inactif</span>
                    <?php } else { ?>
                    <span style="color:blue">Supprime</span> 
                </td> <?php } ?>
                <td><?php echo htmlentities($result->RegDate);?></td>
                <td>
                    <!-- On affiche les boutons Actif/Inactif/Supprimer en fonction de la valeur du statut du lecteur -->
                    <?php if($result->Status==1){?>
                    <a href="reg-readers.php?inid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Voulez-vous vraiment inactiver ce lecteur?');" >  <button class="btn btn-danger"> Inactif</button></a>
                    <?php } else { ?>
                    <a style="color:green" href="reg-readers.php?id=<?php echo htmlentities($result->id);?>" onclick="return confirm('Voulez-vous vraiment activer ce lecteur?');"><button class="btn btn-primary"> Actif</button></a>
                    <?php } ?>
                    
                    <a href="reg-readers.php?del=<?php echo htmlentities($result->id);?>"><button class="btn btn-primary" onclick="return confirm('Voulez-vouw vraiment supprimer ce lecteur ?');"> Supprimer</button></a>
            </td>
            </tr>
            <?php 
            } 
            ?>
            <tbody>
        </table> 
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->
</body>

</html>