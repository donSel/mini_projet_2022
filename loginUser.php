<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" 
integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<h1> Connexion User</h1> 
<hr>

<?php
  require_once('php/database.php');
  // Enable all warnings and errors.
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  // Database connection.
  $db = dbConnect();
  
  // Session start
  session_start();
?>

<a class="btn btn-primary" href="accueil.php" role="button">Retour à l'accueil</a>

<form action="loginUser.php" method="get">
  <div class="form-group">
    <label for="inputAuteurLastName">Adresse mail</label>
    <input class="form-control" type="text" name="mail">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Mot de passe</label>
    <input type="password" class="form-control" name="mdp">
</div>
    <button type="submit" class="btn btn-secondary" name="valider">Valider</button>
    <a class="btn btn-primary" href="registerUser.php" role="button">Vous n'êtes pas inscrits ?</a>
    <a class="btn btn-primary" href="loginDoc.php" role="button">Vous êtes un professionel de santé ?</a>
</form>

<?php
    if (isset($_GET['valider'])){
        $mail = $_GET['mail'];
        $mdp = $_GET['mdp'];
        
        if (isGoodLogin($db, $mail, $mdp, true)){
            // Creating session
            $compte = getCompte($db, $mail, $mdp, true);
            $_SESSION['mail']= $mail;
            $_SESSION['nom'] = $compte[0]['nom'];
            $_SESSION['prenom'] = $compte[0]['prenom'];
            $_SESSION['connected']= true;
            $_SESSION['isUser'] = true;
            echo "<span class='badge badge-success'>Vous vous êtes connectés avec succès !</span>";
        } else {
            $_SESSION['connected']= false;
            echo "<div class='alert alert-danger' role='alert'>Ce compte n'existe pas!</div>"; //reprendre truc des tp pour faire une petite alete sympa
        }
    }

?>