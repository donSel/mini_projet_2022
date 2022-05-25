<!DOCTYPE html><!--HTML5-->
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>infoUser</title>
            <!-- Bootstrap -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
            crossorigin="anonymous">
            <!-- Mon css -->
            <link href="style.css" rel="stylesheet">
    </head>
    <body>
        
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
    
    <div class='container-fluid mt-3'> <!-- FLEX -->
    <div class='d-flex justify-content-center'>
    <h1> Vos informations</h1> 
    <hr>
    </div>
    
    <a class="btn btn-primary" href="accueil.php" role="button">Retour à l'accueil</a>
    
    
    <?php
        $mailUser = $_SESSION['mail'];
        //echo "mail user : " . $mailUser;
    
        if ($_SESSION['isUser'] == true){ // page info User
            $compte = getCompte($db, $_SESSION['mail'], true);
            echo "<div class='d-flex justify-content-center'>";
            echo "Nom : " . $compte[0]['nom'];
            echo "</div>";
            echo "<div class='d-flex justify-content-center'>";
            echo "Prenom : " . $compte[0]['prenom'];
            echo "</div>";
            echo "<div class='d-flex justify-content-center'>";
            echo "Telephone : " . $compte[0]['telephone'];
            echo "</div>";
            echo "<div class='d-flex justify-content-center'>";
            echo "Adresse mail : " . $compte[0]['mail'];
            echo "</div>";
            $arrOldAppointment = getOldAppointments($db, $mailUser);
            //print_r($arrOldAppointment);
            
            // affichage des rdv passés
            
            
            echo "
            <div class='d-flex justify-content-center'>
            <h1> Anciens rendez-vous</h1> 
            <hr>
            </div>
            ";
            
            echo "<form action='takeAppointment.php' method='get'>";
            foreach($arrOldAppointment as $value){
                $compteDoc = getCompte($db, $value['mail'], false);
                echo "<div class='flex-fill m-1 p-1 bg-light'>";
                echo "<div class='card w-75'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'> le " . $value['jour'] . " à " . $value['heure'] . " ". $compteDoc[0]['nom'] . " " . $compteDoc[0]['prenom'] . "</h5>";
                echo "<p class='card-text'>spécialité : ". $compteDoc[0]['specialite'] . ", téléphone : " . $compteDoc[0]['telephone'] . ", établissement : " . $compteDoc[0]['etablissement'] . ", adresse :  " . $compteDoc[0]['adresse']  . " " . $compteDoc[0]['ville']  . " " . $compteDoc[0]['code_postal']. "</p>";
                echo "<button name='button' type='submit' value=" . $value['mail'] . " class='btn btn-primary'> Reprendre un rendez-vous </button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</form>";
            
            //print_r($arrOldAppointment);
        }
        else { // page info User Doc
            $compte = getCompte($db, $_SESSION['mail'], false);
            //print_r($compte);
            echo "<div class='d-flex justify-content-center'>";
            echo "Nom : " . $compte[0]['nom'];
            echo "</div>";
            echo "<div class='d-flex justify-content-center'>";
            echo "Prenom : " . $compte[0]['prenom'];
            echo "</div>";
            echo "<div class='d-flex justify-content-center'>";
            echo "Telephone : " . $compte[0]['telephone'];
            echo "</div>";
            echo "<div class='d-flex justify-content-center'>";
            echo "Adresse mail : " . $compte[0]['mail'];
            echo "</div>";
            echo "<div class='d-flex justify-content-center'>";
            echo "Etablissement : " . $compte[0]['etablissement'];
            echo "</div>";
            echo "<div class='d-flex justify-content-center'>";
            echo "Adresse : " . $compte[0]['adresse'] . " " . $compte[0]['ville'] . " " . $compte[0]['code_postal'];
            echo "</div>";
        }
    
    ?>
        

    </body>
</html>