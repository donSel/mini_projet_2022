<!DOCTYPE html><!--HTML5-->
<html lang="fr">
    <head>
    <meta charset="utf-8">
        <title>Accueil</title>
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
          crossorigin="anonymous">
       <!-- Mon css -->
       <link href="style.css" rel="stylesheet">
   </head>
   <body>
       
    <div class='container-fluid mt-3'> <!-- FLEX -->
    <div class='d-flex justify-content-center'>
    <h1> Prise de rendez-vous</h1> 
    <hr>
    </div>

    <?php
        require_once('php/database.php');
        // Enable all warnings and errors.
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        // Database connection.
        $db = dbConnect();
        
        // Session start
        session_start();
        
        // Informations
        $_SESSION['mailDoc'] = $_GET['button'];
        $mailDoc = $_SESSION['mailDoc'];
        //$mailDoc = 'Bertrand.RIESSE@gmail.com';
        $mailUser = $_SESSION['mail'];
        //$mailUser = 'Dubois.ROLU@gmail.com';
        
        // get current date
        $date = new DateTime();
        $today = $date->format('Y-m-d');
    ?>
    
    <div class='d-flex p-2 border'>
        <?php
        echo "mail Doc : " . $mailDoc;
        echo "  mail User : " . $mailUser;
        ?>
    </div>
    
    <div class='d-flex p-2 border'>
        <form action='takeAppointment.php' method='get'>
            <label> Veuillez saisir le date du rendez-vous souhaité :
                <?php
                    echo "<input type='date' id='start' name='calendar' value=$today  min=$today >";
                ?>
            </label>
            <button class='btn btn-outline-success my-2 my-sm-0' type='submit' name='validerDate'>Valider la date</button>
        </form>
    </div>
    
    <!--afficher tableau rdv du jour-->
    <?php
        if (isset($_GET['validerDate'])){
            // getting information
            $dayRdv = $_GET['calendar'];
            
            // afficher tableau rdv du jour
            echo "
                <div class='d-flex p-2 border'>
                </div>";
                
                
            // afficher la selection de heure
            echo "
                <div class='d-flex p-2 border'>
                    <form action='takeAppointment.php' method='get'>
                        <label for='appt'>Choisissez un horraire pour votre rendez-vous : 
                            <input type='time' id='appt' name='hour' step='3600' min='09:00' max='18:00' required>
                            <small> Rendez-vous possibles entre 9:00 et 18:00 toutes les heures  </small>
                        </label>
                        <button class='btn btn-outline-success my-2 my-sm-0' type='submit' name='validerHeure'>Valider l'heure du rendez-vous</button>
                    </form>
                </div>    
            ";
            
            // enregistrment du rdv
            if (isset($_GET['validerHeure'])){
                if (!empty($_GET['calendar']) && !empty($_GET['hour'])){ 
                    // getting informations
                    $hourRdv = $_GET['hour'];
                    echo "date rdv : " . $dayRdv;
                    echo "horraire rdv : " . $hourRdv;
                    
                    // checking if informations are ok and taking appointment             
                    $valid = takeAppointment($db, $mailDoc, $mailUser, $dayRdv, $hourRdv);
                    if ($valid == true){
                        echo "<span class='badge badge-success'>Votre rendez-vous a été pris !</span>"; 
                    }
                    else {
                        echo "<div class='alert alert-danger' role='alert'>Rendez vous impossible à prendre</div>";
                    }
                }
                else{
                    echo "<div class='alert alert-danger' role='alert'>Remplissez tout les champs !</div>";
                }
            }
            
        }
    ?>
    </div>
    </body>
</html>