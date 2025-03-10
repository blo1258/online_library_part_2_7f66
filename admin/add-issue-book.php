<?php
session_start();

include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Ajout de sortie</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <script>
        // On crée une fonction JS pour récuperer le nom du lecteur à partir de son identifiant
        function getReader(val) {
            $.ajax({
                type: "POST",
                url: "get_reader.php",
                data: 'reader_id=' + val,
                success: function(data) {
                    $("#reader_name").val(data);
                }
            });
        }
        // On crée une fonction JS pour recuperer le titre du livre a partir de son identifiant ISBN
        function getBook(val) {
            $.ajax({
                type: "POST",
                url: "get_book.php",
                data: 'book_id=' + val,
                success: function(data) {
                    $("#book_name").val(data);
                }
            });
        }
    </script>
</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->

    <!-- Dans le formulaire du sortie, on appelle les fonctions JS de recuperation du nom du lecteur et du titre du livre 
 sur evenement onBlur-->
    <div class="container">
        <h2>Ajouter un livre</h2>
        <form method="post">
            <div class="form-group">
                <label for="reader_id">Identifiant du lecteur</label>
                <input type="text" class="form-control" id="reader_id" name="reader_id" onBlur="getReader(this.value)" required>

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>