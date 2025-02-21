<?php
session_start();
global $dbh;
$dbh = new PDO("mysql:host=localhost;dbname=library;charset=utf8", 'root', 'root');

if (!isset($_GET['id'])) {
    $_SESSION['msg'] = "Erreur: ID du livre manquant!";
    header('location: manage-books.php');
    exit;
}

$id = intval($_GET['id']); // ID güvenliği için tam sayı olarak al

// Kitabı sil
$query = $dbh->prepare("DELETE FROM tblbooks WHERE id = :id");
$query->bindParam(':id', $id, PDO::PARAM_INT);

if ($query->execute()) {
    $_SESSION['msg'] = "Livre supprimé avec succès!";
} else {
    $_SESSION['msg'] = "Erreur lors de la suppression!";
}

// Kullanıcıyı geri yönlendir
header('location: manage-books.php');
exit;
