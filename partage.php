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

//Prendre les donnés dans la base PhPmyadmin
$sqlQuery = "SELECT Partage.*, text.donnes AS donnes,  Users.name AS user_name 
FROM `Partage`
LEFT JOIN `text` ON Partage.donnes_id = `text`.id
LEFT JOIN `Users` ON `text`.users_id = Users.id
WHERE `user_id_desti` = :id";
$textStatement = $mysqlConnection->prepare($sqlQuery);
$textStatement->execute([
    ":id" => $_SESSION['id'],
]);
$note_partage = $textStatement->fetchAll();

$sql = "SELECT Partage.*, Users.id AS user_id, Users.name AS user_name, Partage.id AS partage_id, text.donnes AS donnes
FROM `Partage` 
LEFT JOIN `text` ON Partage.donnes_id = text.id
LEFT JOIN `Users` ON Users.id = Partage.user_id_desti
WHERE `user_id_expe` = :id";
$Statement = $mysqlConnection->prepare($sql);
$Statement->execute([
    ":id" => $_SESSION['id'],
]);
$me_note_partage = $Statement->fetchAll();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <title>BLOCBLOK-PARTAGE</title>
    <link rel="icon" href="/logobloc.png" sizes="48px,48px">


</head>

<body>

<div class=" mb-3 row">
        <div class="col">
            <nav class="navbar navbar-dark bg-warning">
                <div class="container-fluid">
                    <a class="navbar-brand text-dark" href="/index.php">
                        <img src="logobloc.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
                        BlocBlox
                    </a>
                    <a class="nav-link" href="/partage.php">Partagé</a>
                    <a class="nav-link" href="/intadmin.php">Int Admin</a>
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modal_nouveau_mdp" href="#">Gestion mot
                        de passe</a>
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modal_confirmation_deconnection"
                        href="#">Déconnection</a>
                </div>
        </div>
        </nav>
    </div>

    <h3>Note(s) reçu(s) :</h3>
    <table class="table table-dark">
        <thead>
            <tr>
                <th style="width: 20%;" scope="row">Partage de : </th>
                <th class="" style="width: 60%;" scope="col">Note(s) reçu(s)</th>
                <th class="" style="width: 20%;" scope="col">Actions</th>
            </tr>
        </thead>




        <tbody>

<?php
foreach ($note_partage as $note_partages) {
    echo '
    <tr>
    <form action="partagefonc.php" method="POST">
    <td ">'.$note_partages['user_name'].'</td>
    <td><textarea name="notedonnes" id="note_recu" value="' . $note_partages['donnes'] . '" class="form-control mb-0  note"  readonly>' . $note_partages['donnes'] . ' </textarea></td>
    <td>
    <input type="hidden" name="id" value="' . $note_partages["id"] . '"/>
    <button class="btn btn-danger text-white " type="submit"  name="form" value="delete_note_recu">Delete</button>
    </td>
    </form>
    </tr>

    ';

}


?>
    <td id="no_note_recu" class="d-none">Vous n'avez reçu aucune note</td>
    </tbody>
    </table>


    <h3>
        Note(s) partagé(s) :
    </h3>


    <table class="table table-dark">
        <thead>
            <tr>
            <th style="width: 20%;" scope="row">Partagé à : </th>
                <th class="" style="width: 60%;" scope="col">Note(s) envoyé(s)</th>
                <th class="" style="width: 20%;" scope="col">Actions</th>
            </tr>
        </thead>

        <tbody>

<?php
foreach ($me_note_partage as $me_note_partages) {
    echo '
    <tr>
    <form action="partagefonc.php" method="POST">
    <td>' . $me_note_partages["user_name"] . '</td>
    <td><textarea name="notedonnes" id="note_partage" value="' . $me_note_partages['donnes'] . '" class="form-control mb-0  "  readonly>' . $me_note_partages['donnes'] . ' </textarea></td>
    <td>

    <input type="hidden" name="id" value="' . $me_note_partages["partage_id"] . '"/>
    <button class="btn btn-danger text-white " type="submit"  name="form" value="delete_note_partage">Delete</button>
    </td>
    </form>
    </tr>

    ';

}

?>
    <td id="no_note_partage" class="d-none">Vous n'avez partagé aucune de vos note(s)</td>
    </tbody>
    </table>





    <!-- Modal -->
    <form action="/login/controllers/loginfonc.php" method="POST">
        <div class="modal fade" id="modal_confirmation_deconnection" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        Etes vous sur de vouloir vous déconnecté ?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="deconnection" value="deconnection"
                            class="btn btn-primary">Oui</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>


  <!-- Modal -->
  <form action="/login/controllers/loginfonc.php" method="POST">
        <div class="modal fade" id="modal_nouveau_mdp" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        Changement de mot de passe
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-2">
                                <label for="">Ancien mot de passe:</label>
                                <br>
                                <input type="password" name="ancien_mdp" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="">Nouveau mot de passe:</label>
                                <br>
                                <input type="password" name="nouveau_mdp" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="">Confirmé nouveau mot de passe :</label>
                                <br>
                                <input type="password" name="confirm_nouveau_mdp" required>
                            </div>
                        </div>
                    

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="change_mdp" value="change_mdp" class="btn btn-primary">Oui</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>



<script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="partage.js"></script>
</body>
</html>