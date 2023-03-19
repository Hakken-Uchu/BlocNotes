<?php session_start();
if (!isset($_SESSION['name'])) {
    $message_expire = "Votre session a expiré veuillez vous reconnecté";
    echo "<script type='text/javascript'>alert('$message_expire');
    document.location.href = '/login/view/login.php';
    </script>";

}
//liason ave la base de donnés PhPmyadmin
$mysqlConnection = new PDO('mysql:host=localhost;dbname=blocnotes;charset=utf8', 'root', 'lol');
try {

} catch (PDOException $e) {
    die($e->getMessage());
}

$db = "SELECT * FROM `Users`";
$dbStatement = $mysqlConnection->prepare($db);
$dbStatement->execute();
$users = $dbStatement->fetchAll();

if (isset($_POST['form']) && ($_POST['form']) == "delete_user") {
    $id = $_POST['id'];
    $sqlQuery = 'DELETE FROM Users WHERE `id` = "' . $id . '"';
    $delete = $mysqlConnection->prepare($sqlQuery);
    $delete->execute();
    header('Location: /intadmin.php');
}

if (isset($_POST['form']) && ($_POST['form']) == "check_note_user") {
    $_SESSION['id_all_note'] = $_POST['id'];
    header('Location: /noteallusers.php');
}
