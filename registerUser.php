<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" 
integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<h1> Inscription User</h1> 
<hr>

<?php
  require_once('php/database.php');
  include ('php/constants.php');
  // Enable all warnings and errors.
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  // Database connection.
  $db = dbConnect();
  
?>

<a class="btn btn-primary" href="accueil.php" role="button">Retour à l'accueil</a>

<form action="registerUser.php" method="get">
  <div class="form-group">
    <label for="inputAuteurLastName">Nom</label>
    <input class="form-control" type="text" name="nom">
  </div>
  <div class="form-group">
    <label for="inputAuteurFirstName">Prenom</label>
    <input class="form-control" type="text" name="prenom">
  </div>
  <div class="form-group">
    <label for="inputAuteurFirstName">Telephone</label>
    <input class="form-control" type="text" name="telephone">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Mot de passe</label>
    <input type="password" class="form-control" name="mdp">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Confirmation mot de passe</label>
    <input type="password" class="form-control" name="mdpConf">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Adresse mail</label>
    <input type="text" class="form-control" name="mail">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Confirmation adresse mail</label>
    <input type="text" class="form-control" name="mailConf">
  </div>
  <button type="submit" class="btn btn-secondary" name="valider">Valider</button> 
</form>

<?php

    if (isset($_GET['valider'])){ 
        
        // vChecking of all the informations where entered
        if (empty($_GET['nom']) || empty($_GET['prenom']) || empty($_GET['telephone']) || empty($_GET['mdp']) || empty($_GET['mdpConf']) || empty($_GET['mail']) || empty($_GET['mailConf'])){
            echo "<div class='alert alert-danger' role='alert'>Remplissez tout les champs !</div>";
        }
        else {
            //getting informations
            $nom = $_GET['nom'];
            $prenom = $_GET['prenom'];
            $telephone = strval($_GET['telephone']);
            $mdp = $_GET['mdp'];
            $mdpConf = $_GET['mdpConf'];
            $mail = $_GET['mail'];
            $mailConf = $_GET['mailConf'];
            
            if (isStringSame($mail, $mailConf) && isStringSame($mdp, $mdpConf)){ //check if informations correct
                
                if (mailExists($db, $mail, true)){ //check if the mail already is in the DB
                    echo "<div class='alert alert-danger' role='alert'>L'adresse mail rentrée existe déjà !</div>";
                } else {
                    // Adding the new user
                    addUser($db, $mdp, $nom, $prenom, $mail, $telephone);
                    
                    // Success message                    
                    echo "<span class='badge badge-success'>Vous avez créez votre compte avec succès !</span>";
                    //sleep(3);
                    echo "<a href='loginUser.php'>Cliquez ici pour vous connecter !</a>";
                }
            } else {
                echo "<div class='alert alert-danger' role='alert'>Les mots de passes ou les adresses mail ne correspondent pas!</div>"; //distinguer cas ereur adresse mail et mdp
            }
        }
    }

?>