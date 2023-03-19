<?php session_start();
/*définition des variables*/
$lines = 3;
$counter = 0;

/*lien avec mysql*/
$mysqlConnection = new PDO('mysql:host=localhost;dbname=blocnotes;charset=utf8', 'root', 'lol');
try {

} catch (PDOException $e) {
    die($e->getMessage());
}
/*prends les donnés directement de la base de donnés et affiche le nom est le mail renseigner*/
$sqlQuery = 'SELECT * FROM `Users`';
$UsersStatement = $mysqlConnection->prepare($sqlQuery);
$UsersStatement->execute();
$Users = $UsersStatement->fetchAll();

/*rentrer dans l'input connection*/
if (isset($_POST['form']) && ($_POST['form']) == "connection") {
    /*vérification des champs de connection*/
    if (isset($_POST['pass_connection']) && isset($_POST['name_connection'])) {
        foreach ($Users as $user) {
            if ($user['name'] == $_POST['name_connection'] && $user['motdepasse'] == hash('ripemd160', $_POST['pass_connection'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['mail'] = $user['mail'];
                $_SESSION['motdepasse'] = $user['motdepasse'];
                break;
            }
        }
        if ($user['name'] !== $_POST['name_connection'] || $user['motdepasse'] !== hash('ripemd160', $_POST['pass_connection'])) {
            $message_connection_no_valid = "Les identifiants de connection ne sont pas valides";
            echo "<script type='text/javascript'>alert('$message_connection_no_valid');
document.location.href = '/login/view/login.php';
</script>";
            return;
        } else {
            
            echo "<script type='text/javascript'>
document.location.href = '/index.php';
</script>";
            exit;
        }
    }

}

/*rentre dans l'input inscription*/
if (isset($_POST['form']) && ($_POST['form']) == "inscription") {
    /*commande pour enregistrer les donnés dans le phpmyadmin*/
    if (isset($_POST['name_inscription']) && isset($_POST['mail_inscription']) && isset($_POST['pass_inscription']) && isset($_POST['form']) == "inscription") {
        $sqlQuery = 'INSERT INTO Users(name, mail, motdepasse, is_admin) VALUES (:name, :mail, :motdepasse, false)';
        $insertRecipe = $mysqlConnection->prepare($sqlQuery);
        $insertRecipe->execute([
            'name' => $_POST['name_inscription'],
            'mail' => $_POST['mail_inscription'],
            'motdepasse' => hash('ripemd160', $_POST['pass_inscription']),
        ]);
        
        echo "<script type='text/javascript'>
document.location.href = ' /';
</script>";
        $_SESSION['id'] = $mysqlConnection->lastInsertId();
        $_SESSION['name'] = $_POST['name_inscription'];
        $_SESSION['mail'] = $_POST['mail_inscription'];
        $_SESSION['motdepasse'] = $_POST['pass_inscription'];
    }

}
if (isset($_POST['deconnection']) && ($_POST['deconnection']) == "deconnection") {
    session_destroy();
    $message_deconnection = "Vous avez bien été déconnecté";
    echo "<script type='text/javascript'>alert('$message_deconnection');
document.location.href = '/login/view/login.php';
</script>";
}

if (isset($_POST['change_mdp']) && ($_POST['change_mdp']) == "change_mdp") {
    if (hash('ripemd160', $_POST['ancien_mdp']) == $_SESSION['motdepasse']) {
        if ($_POST['nouveau_mdp'] == $_POST['confirm_nouveau_mdp']) {
            $id = $_SESSION['id'];
            $sqlQuery = 'UPDATE Users SET `motdepasse` = :motdepasse WHERE `id` = "' . $id . '"';
            $edit = $mysqlConnection->prepare($sqlQuery);
            $edit->execute([
                ":motdepasse" => hash('ripemd160', $_POST['nouveau_mdp']),
            ]);
            $_SESSION['motdepasse'] = hash('ripemd160', $_POST['nouveau_mdp']);
            $message_change_mdp_accept = "Votre mot de passe a bien été changé";
            echo "<script type='text/javascript'>alert('$message_change_mdp_accept');
            document.location.href = '/index.php';
            </script>";
        } else {
            $message_change_mdp_confirm_mdp_fail = "Vous n\'avez pas rentré deux fois le même mot de passe";
            echo "<script type='text/javascript'>alert('$message_change_mdp_confirm_mdp_fail');
            document.location.href = '/index.php';
            </script>";
        }
    } else {
        $message_change_mdp_ancien_not_egale_nouveau = "Votre ancien mot de passe n\'est pas celui que vous venez de rentré";
        echo "<script type='text/javascript'>alert('$message_change_mdp_ancien_not_egale_nouveau');
        document.location.href = '/index.php';
            </script>";
    }
}
