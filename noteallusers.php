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

$sqlrecupusers = "SELECT * FROM `Users`";
$textSatement = $mysqlConnection->prepare($sqlrecupusers);
$textSatement->execute();
$users = $textSatement->fetchAll();

$db = "SELECT is_admin FROM `Users` WHERE `id` = :id";
$textStatementla = $mysqlConnection->prepare($db);
$textStatementla->execute([
    ":id" => $_SESSION['id'],
]);
$is_admin = $textStatementla->fetchAll();
if ($user['id'] = $_SESSION['id']) {
    if ($is_admin[0]['is_admin'] == 0) {
        $message_non_droit_admin = "Vous ne possédé pas les droit administrateurs";
        echo "<script type='text/javascript'>alert('$message_non_droit_admin');
    document.location.href = '/index.php';
    </script>";
    } else {

    }
}
;

$selectdonnes = "SELECT donnes FROM text WHERE `users_id` = :id";
$donnesStatement = $mysqlConnection->prepare($selectdonnes);
$donnesStatement->execute([
    ":id" => $_SESSION['id_all_note'],
]);
$donnes = $donnesStatement->fetchAll();


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <title>BLOCBLOK-INTADMIN</title>
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



<?php
$compteur = 1;
foreach ($donnes as $Donnes) {
    echo '

                    <div class="col-4 bg-secondary">
                    <div class="card">
                        <div class="card-body">
                        <div class="text-center mb-3">' . "Note : " . '' . $compteur . '</div>
                        <label class="form-control mb-0 text-center">' . $Donnes['donnes'] . ' </label>
                        </div>
                    </div>
                    </div>
                    ';
    $compteur += 1;
}

?>

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
                            <div class="col mb-2">
                                <label for="">Nouveau mot de passe:</label>
                                <br>
                                <input type="password" name="nouveau_mdp" required>
                            </div>
                            <div class="col mb-2">
                                <label for="">Confirmé nouveau mot de passe:</label>
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
</body>
</html>