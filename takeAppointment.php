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

    <?php
        require_once('php/database.php');
        // Enable all warnings and errors.
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        // Database connection.
        $db = dbConnect();
        
        // Session start
        session_start();
        //echo "session ID : " . session_id();
        
        // Informations
        $_SESSION['mailDoc'] = $_GET['button'];
        $mailDoc = $_SESSION['mailDoc'];
        echo "mail Doc : " . $mailDoc;
        //$mailDoc = 'Bertrand.RIESSE@gmail.com';
        $mailUser = $_SESSION['mail'];
        echo "mail Doc : " . $mailUser;
        //$mailUser = 'Dubois.ROLU@gmail.com';
        
        // get current date
        $date = new DateTime();
        $today = $date->format('Y-m-d');
    ?>

    <?php
        
        echo "<form action='takeAppointment.php' method='get'>";
        echo "  <label> Veuillez saisir le date du rendez-vous souhaité : <br>";
        echo "      <input type='date' id='start' name='calendar' value=$today  min=$today >";
    ?>
        </label>
        <label for="appt">Choisissez un horraire pour votre rendez-vous:</label>
            <input type="time" id="appt" name="hour" step="3600" min="09:00" max="18:00" required>
            <small>Rendez possibles entre 9:00 et 18:00 toutes les heures</small>
        </label>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="valider">Valider</button>
    </form>
    
    <?php 
        $statement = $db->query('SELECT * FROM prendre');
        print_r($statement->fetchAll(PDO::FETCH_ASSOC)); 
        
        if (isset($_GET['valider'])) { 
            // getting informations
            $dayRdv = $_GET['calendar'];
            $hourRdv = $_GET['hour'];
            echo "date rdv : " . $dayRdv;
            echo "horraire rdv : " . $hourRdv;
            // checking if informations are ok and taking appointment             
            $valid = takeAppointment($db, $mailDoc, $mailUser, $dayRdv, $hourRdv);
            if ($valid == true){
                echo "<span class='badge badge-success'>Votre rendez-vous a été pris !</span>"; //mettre petite banière verte
            }
            else {
                
                echo "<div class='alert alert-danger' role='alert'>Rendez vous impossible à prendre</div>";
            }
        }
        else{
            echo $today;
        }
    ?>
    
    </body>
</html>