<?php session_start();
//liason avec la base de donnés PhPmyadmin
$mysqlConnection = new PDO('mysql:host=localhost;dbname=blocnotes; charset=utf8', 'root', 'lol');
try {

} catch (PDOException $e) {
    die($e->getMessage());
}
$sqlQuery = "SELECT * FROM `text`";
$textStatement = $mysqlConnection->prepare($sqlQuery);
$textStatement->execute();
$notes = $textStatement->fetchAll();




//message si un utilisateur veut rentré une note mais que le textarea est vide
$messageNoComment = "Il faut ecrire pour ajouté une note";
if (isset($_POST['form']) && ($_POST['form']) == "plus") {
    if (!isset($_POST['texte']) == ($_POST['texte'])) {
        echo "<script type='text/javascript'>alert('$messageNoComment');
document.location.href = ' /';
</script>";
        return;
    }
//insertion de la note dans la base de donnés
    else {
        $sqlQuery = 'INSERT INTO text (users_id, donnes) VALUES (:users_id, :donnes)';
        $insert = $mysqlConnection->prepare($sqlQuery);
        $insert->execute([
            'users_id' => $_SESSION['id'],
            'donnes' => $_POST['texte']
        ]);
        }
        header("Location: /");
    }



//Fonctionnalités pour le bouton delete
if (isset($_POST['form']) && ($_POST['form']) == "delete") {
    $id = $_POST['id'];
    $sqlQuery = 'DELETE FROM text WHERE `id` = "' . $id . '"';
    $delete = $mysqlConnection->prepare($sqlQuery);
    $delete->execute();
    header("Location: /");
}
;

//Fonctionnalités pour le bouton edit
if (isset($_POST['form']) && ($_POST['form']) == "confirmEdit") {
    $notedonnes = $_POST['notedonnes'];
    $_SESSION['notedonnes'] = $notedonnes;
    $id = $_POST['id'];
    $sqlQuery = 'UPDATE text SET `donnes` = :notedonnes WHERE `id` = "' . $id . '"';
    $edit = $mysqlConnection->prepare($sqlQuery);
    $edit->execute([
        ":notedonnes" => $notedonnes,
    ]);
    header("Location: /");
}





if (isset($_POST['form']) && ($_POST['form']) == "partage") {
    if(!empty($_POST['user_id'])){
        $user_id_expe = $_SESSION['id'];
        $user_id_desti = $_POST['user_id'];
        $note_id = $_POST['note_id'];
        $sqlQuery = 'INSERT INTO `Partage` (user_id_expe, user_id_desti, donnes_id) VALUES (:user_id_expe, :user_id_desti, :donnes)';
        $insert = $mysqlConnection->prepare($sqlQuery);
        $insert->execute([
            'user_id_expe' => $user_id_expe,
            'user_id_desti' => $user_id_desti,
            'donnes' => $note_id
        ]);
        echo "<script type='text/javascript'>
        document.location.href = ' /';
        </script>";
        

    }else {
        $message_partage_fail = "Vous n\'avez choisis aucun utilisateur";
        echo "<script type='text/javascript'>alert('$message_partage_fail');
        document.location.href = ' /';
        </script>";
    }

}

//fin
