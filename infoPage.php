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
        //echo "session ID : " . session_id();
    ?>
    
    <?php
        //$mailUser = $_SESSION['mail'];
        $mailUser = 'Dubois.ROLU@gmail.com';
        $arrOldAppointment = getOldAppointments($db, $mailUser);
        print_r($arrOldAppointment);
    ?>
        

    </body>
</html>