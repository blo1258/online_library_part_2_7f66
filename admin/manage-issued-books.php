<?php
session_start();

global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');

if (isset($_POST['change'])) {

if ($_POST["vercode"] != $_SESSION["vercode"] ) {
    echo "<script>alert('Code de vérification invalide');</script>";
    } else {
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $newpassword = md5(trim($_POST['password']));

    $sql = "SELECT * FROM tblreaders WHERE EmailId = :email AND MobileNumber = :mobile";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_OBJ);

    if($query->rowCount() > 0) {
        $sql = "UPDATE tblreaders SET Password = :newpassword WHERE EmailId = :email AND MobileNumber = :mobile";
        $query = $dbh->prepare($sql);
        $query->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Mot de passe mis à jour avec succès');</script>";
    } else {
        echo "<script>alert('Email ou numéro de téléphone invalide');</script>";
    }
}
}
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Gestion des sorties</title>
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
    
    <script type="text/javascript">

function valid() {
    if (document.chngpwd.password.value != document.chngpwd.confirmpassword.value) {
        alert("Les deux mots de passe ne correspondent pas !!");
        document.chngpwd.confirmpassword.focus();
        return false;
    } return true;
}

    </script>
<!------MENU SECTION START-->

     <!-- CONTENT-WRAPPER SECTION END-->
    
     <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Gestion des sorties</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="container mt-4">
                           <h5>Sorties</h5> 
                        
                        <div class="panel-body
                        ">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Lecteur</th>
                                            <th>Titre</th>
                                            <th>ISBN</th>
                                            <th>Sortie le</th>
                                            <th>Retourne le</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        </div>
<?php
$sql = "SELECT tblissuedbookdetails.id as isid, tblreaders.FullName as fullname, tblbooks.BookName as bookname, 
tblbooks.ISBNNumber as isbn, tblissuedbookdetails.IssuesDate as idate, tblissuedbookdetails.ReturnDate as rdate 
from tblissuedbookdetails join tblreaders on tblreaders.ReaderId=tblissuedbookdetails.ReaderId 
JOIN tblbooks ON tblbooks.ISBNNumber = tblissuedbookdetails.ISBNNumber";

$query = $dbh->prepare($sql);
$query->execute();
$books = $query->fetchAll(PDO::FETCH_ASSOC);
$i = 1;
foreach ($books as $book) {
?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $book['fullname']; ?></td>
                                            <td><?php echo $book['bookname']; ?></td>
                                            <td><?php echo $book['isbn']; ?></td>
                                            <td><?php echo $book['idate']; ?></td>
                                            <td><?php echo $book['rdate']; ?></td>
                                            <td><a href="edit-issue-book.php?id=<?php echo $book['idate']; ?>" class="btn btn-primary">Editer</a></td>
                                        </tr>
<?php
                                $i++;
                        }
?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
     <!-- FOOTER SECTION -->


 <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

