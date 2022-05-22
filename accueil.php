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
    ?>
   
    <!-- Top bar -->   
    <div class="container-fluid bg-primary">
        <nav class="navbar navbar-dark">
            <div class="container-fluid">
            <a class="navbar-brand" href="accueil.php">
                <img src="images/caduceus-2029254_640.webp" width="50" height="60">
                здоровье
            </a>
            <div class="barre">
                <button class="btn btn-outline-light" type="submit" onclick="window.location.href = 'loginUser.php';">Se connecter</button>
            </div>
            </div>
        </nav>
    </div>
    
    <br><br>
    
    <!-- Search Bar -->  
    <div class="container-fluid bg-primary">
        <nav class="navbar navbar-light bg-light">
            <form class="form-inline">
                <input class="form-control mr-sm-2" name="nse" type="search" placeholder="Nom, spécialité, établissement" aria-label="Search">
                <input class="form-control mr-sm-2" name="lieu" type="search" placeholder="Lieu" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
            </form>
        </nav> 
    </div>
    
   </body>
</html>
