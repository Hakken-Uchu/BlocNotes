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
$sqlQuery = "SELECT * FROM `text` WHERE `users_id` = :id";
$textStatement = $mysqlConnection->prepare($sqlQuery);
$textStatement->execute([
    ":id" => $_SESSION['id'],
]);
$notes = $textStatement->fetchAll();

$sqlrecupusers = "SELECT * FROM `Users`";
$textSatement = $mysqlConnection->prepare($sqlrecupusers);
$textSatement->execute();
$users = $textSatement->fetchAll();
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <title>BLOCBLOK</title>
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

    <div class="row">
        <div class="col">
            <form action="foncindex.php" method="POST">
                <div class="text-black mb-3"><?php echo "Ici réside les notes de " . $_SESSION['name'] . " : " ?>
                </div>
        </div>
        <div class="input-group mb-4">
            <textarea name="texte" placeholder="écrit ici <-" type="text" class="form-control"></textarea>
            <div class="input-group-prepend">
                <button type="submit" name="form" value="plus" class="btn btn-danger btn-lg">Ajout !</button>
            </div>
        </div>
        <input type="hidden" name="expire" value="expire">
        </form>
    </div>

    <table class="table table-dark">
        <thead>
            <tr>
                <th style="width: 10%;" scope="row">ID</th>
                <th class="" style="width: 60%;" scope="col">Note(s)</th>
                <th class="" style="width: 30%;" scope="col">Actions</th>
            </tr>
        </thead>




        <tbody>
            <?php
$compteur = 1;
foreach ($notes as $note) {
    echo '
    <tr>
    <form action="foncindex.php" method="POST">
    <td>' . $note['id'] . '</td>
    <td><textarea name="notedonnes" class="form-control mb-0  note" value="' . $note['donnes'] . '"  readonly>' . $note['donnes'] . ' </textarea></td>
    <td>

    <input type="hidden" name="id" value="' . $note['id'] . '"/>
    <button class="btn btn-warning text-dark  editClass" type="button">Edit</button>
    <button class="btn btn-success text-white editConfirmClass d-none" type="submit" name="form" value="confirmEdit">Confirm</button>
    <button value="' . $note['id'] . '" class="portager    btn btn-primary text-white " type="button">Partagé</button>
    <button class="btn btn-danger text-white " type="submit"  name="form" value="delete">Delete</button>
    </td>
    </form>
    </tr>


';

}

?>
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




    <div class="modal fade" id="modal_partage" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/foncindex.php" method="POST">
                    <div class="modal-header">
                        Liste des utilisateurs
                    </div>
                    <div class="modal-body">
                        <?php
foreach ($users as $user) {
    echo '
                    ' . $user['name'] . '    <input name="user_id" value="' . $user["id"] . '" type="radio">
                    <br>

                    ';
}
?>
                    </div>
                    <input type="hidden" name="note_id" id="note_id"></input>
                    <div class="modal-footer">
                        <button type="submit" name="form" value="partage" class="btn btn-primary">Envoyé</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulé</button>
                    </div>
                </form>
            </div>
        </div>
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
    <script src="index-js/index.js"></script>
    <script src="/index-js/checknoteexist.js"></script>

</body>

</html>