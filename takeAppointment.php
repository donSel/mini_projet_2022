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
        if (isset($_GET['button'])){
            $_SESSION['mailDoc'] = $_GET['button'];
        }
        $mailDoc = $_SESSION['mailDoc'];
        //$mailDoc = 'Bertrand.RIESSE@gmail.com';
        $mailUser = $_SESSION['mail'];
        //$mailUser = 'Dubois.ROLU@gmail.com';
        
        // get current date
        $date = new DateTime();
        $today = $date->format('Y-m-d');
    ?>
        
    <form action='takeAppointment.php' method='get'>
        <div class='d-flex p-2 border'>
            <label> Veuillez saisir le date du rendez-vous souhaité :
                <?php
                    echo "<input type='date' id='start' name='calendar' value=$today  min=$today >";
                    ?>
            </label>
            <button class='btn btn-outline-success my-2 my-sm-0' type='submit' name='validerDate'>Voir les horraires</button>
        </div>
    </form>
    
    <?php
   
        if (isset($_GET['validerDate'])){
            $_SESSION['dayRdv'] = $_GET['calendar'];
            // getting information
            $dayRdv = $_GET['calendar'];
            
            // afficher tableau rdv du jour
            echo "
            <div class='d-flex p-2 border'>
            </div>";
            // afficher la selection de heure
            $arrRdv = getAppointmentDay($db, $mailDoc, $dayRdv);
            echo "
            <table class='table table-hover'>
                <thead>
                    <tr>
                    <th scope='col'>Heure</th>
                    <th scope='col'>Disponibilité</th>
                    </tr>
                </thead>
                <tbody>";
            
            $count = 9;
            for ($i = 0; $i < 10; $i++){
                if (rdvExists($arrRdv, $count)){
                    echo "<tr class='table-danger'>";
                    echo "<th scope='row'>" . $count . ':00' . "</th>";
                    echo "<td>Horraire non disponible</td>";
                    echo "</tr>";
                }
                else {
                    echo "<tr class='table-success'>";
                    echo "<th scope='row'>" . $count . ':00' . "</th>";
                    echo "<td>Horraire libre</td>";
                    echo "</tr>";
                }
                $count++;
            }                    
                echo "
            </tbody>
            </table>";
        }
    ?>
    
    <form action='takeAppointment.php' method='get'>
        <div class='d-flex p-2 border'>
            <label for='appt'>Choisissez un horraire pour votre rendez-vous : 
                <input type='time' id='appt' name='hour' step='3600' min='09:00' max='18:00' required>
                <small> Rendez-vous possibles entre 9:00 et 18:00 toutes les heures  </small>
            </label>
            <button class='btn btn-outline-success my-2 my-sm-0' type='submit' name='validerHour'>Valider l'heure</button>
        </div>  
    </form>
    
    <!--afficher tableau rdv du jour-->
    <?php
        if (isset($_GET['validerHour'])){
            // getting informations
            $dayRdv = $_SESSION['dayRdv'];
            //$dayRdv = $_GET['calendar'];
            $hourRdv = $_GET['hour'];
            
            // checking if informations are ok and taking appointment             
            $valid = takeAppointment($db, $mailDoc, $mailUser, $dayRdv, $hourRdv);
            if ($valid == '1'){
                echo "<div class='alert alert-success' role='alert'>Rendez vous pris pour le " . $dayRdv . " à " . $hourRdv . "</div>"; 
            }
            else {
                echo "<div class='alert alert-danger' role='alert'>Rendez vous impossible à prendre</div>";
            }
        }
        ?>
        
    <a class="btn btn-primary" href="accueil.php" role="button">Retour à l'accueil</a>
    </div>
    </body>
</html>