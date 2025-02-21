<?php
session_start();

error_log("🛠️ TEST: error_log() ÇALIŞIYOR!");
file_put_contents("debug_log.txt", "🛠️ TEST: error_log() ÇALIŞIYOR!\n", FILE_APPEND);


global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (!isset($_SESSION['alogin'])) {
      $_SESSION['msg'] = "Erreur: ID du livre manquant!";
      header('location:/online_library_part_1/adminlogin.php');
      exit;
  }
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $bookId = isset($_POST['BookId']) ? $_POST['BookId'] : '';
      $readerId = isset($_POST['ReaderId']) ? $_POST['ReaderId'] : '';

      if (empty($readerId) || empty($bookId)) {
          $_SESSION['message'] = "Tous les champs sont obligatoires";
          header('location:edit-issue-book.php');
          exit;
      } else {
            $sql = "INSERT INTO tblissuedbookdetails(BookId, ReaderId) VALUES (:BookId, :ReaderId)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':BookId', $bookId, PDO::PARAM_STR);
            $query->bindParam(':ReaderId', $readerId, PDO::PARAM_STR);
            
            if ($query->execute()) {
                $_SESSION['message'] = "Livre sorti avec succès";
            } else {
                $_SESSION['message'] = "Echec de la sortie du livre";
            }
      }
      header('location:edit-issue-book.php');
      exit();
  }
      

     

?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Sorties</title>
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
<!-- MENU SECTION END-->

<div class = "container">
        <h2 class="mt-5">SORTIE D'UN LIVRE</h2>
      <!-- Affichage des messages -->
      <?php
            if (isset($_SESSION['message'])) : ?>
                <div class="alert alert-info"><?php echo $_SESSION['message']; ?></div>
                <?php endif; ?>
       
            <!-- On affiche le formulaire de creation-->
            <form method="POST" action="">
            <div class="form-group">
                <label for="ReaderId">Identifiant du lecteur<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="ReaderId" name="ReaderId" required>
                  <small id="readerName" class="form-text text-muted"></small>
            </div>
            <div class="form-group">
                <label for="BookId">Numero ISBN<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="BookId" name="BookId" required>
                <small id="BookName" class="form-text text-muted"></small>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Sortir le livre</button>
      </form>
</div>

<script>
      document.querySelector("form").addEventListener("submit", function(e) {
    console.log("📤 Form submit edildi!");
});

      
      document.addEventListener("DOMContentLoaded", function() {
            let readerId = document.getElementById('ReaderId');
            let bookId = document.getElementById('BookId');
            let readerName = document.getElementById('readerName');
            let bookName = document.getElementById('BookName');

            readerId.addEventListener('blur', async function() {
                  let readerIdValue = readerId.value.trim();
                  if (readerIdValue !== '') {
                        
                       try { 
                        let response = await fetch('get_reader.php', {
                              method: 'POST',
                              headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded' },
                                    body: 'ReaderId=' + encodeURIComponent(readerIdValue)
                              
                            });
                        let data = await response.text();
                        readerName.innerHTML = (data === "not_found") 
                    ? "<span style='color:red;'>Lecteur introuvable</span>" 
                    : "Nom du lecteur: " + data;
                       } catch (error) {
                             console.error(error);
                             
                       }
                  } else {
                        readerName.innerHTML = '';
                  }
            });
      

      bookId.addEventListener('blur', async function() {
            let bookIdValue = bookId.value.trim();
            if (bookIdValue !== '') {
                  try {
                        let response = await fetch('get_book.php', {
                              method: 'POST',
                              
                              headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                              },
                              body:'ISBNNumber=' + encodeURIComponent(bookIdValue)
                        });
                        let data = await response.text();
                        bookName.innerHTML = data === "not_found"
                        ? "<span style='color:red;'>Livre introuvable</span>" : "Nom du livre: " + data ;
                  } catch (error) {
                        console.error(error);
                  }
            } else {
                  bookName.innerHTML = '';
            }
      });
     });      

     console.log(document.getElementById("BookId"));
      console.log(document.getElementById("ReaderId"));

</script>
     <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
