<?php session_start();
//liason avec la base de donnés PhPmyadmin
$mysqlConnection = new PDO('mysql:host=localhost;dbname=blocnotes; charset=utf8', 'root', 'lol');
try {

} catch (PDOException $e) {
    die($e->getMessage());
}
$sqlQuery = "SELECT * FROM `Partage`";
$textStatement = $mysqlConnection->prepare($sqlQuery);
$textStatement->execute();
$notes = $textStatement->fetchAll();



//Fonctionnalités pour le bouton delete
if (isset($_POST['form']) && ($_POST['form']) == "delete_note_recu") {
    $id = $_POST['id'];
    $sqlQuery = 'DELETE FROM Partage WHERE `id` = "' . $id . '"';
    $delete = $mysqlConnection->prepare($sqlQuery);
    $delete->execute();
    header("Location: /partage.php");
}
;

if (isset($_POST['form']) && ($_POST['form']) == "delete_note_partage") {
    $id = $_POST['id'];
    $sqlQuery = 'DELETE FROM Partage WHERE `id` = "' . $id . '"';
    $delete = $mysqlConnection->prepare($sqlQuery);
    $delete->execute();
    header("Location: /partage.php");
}
;
