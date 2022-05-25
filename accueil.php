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
    
    <div class='container-fluid mt-3'> <!-- FLEX -->
    <div class='d-flex p-2 border'>
        <!-- Top bar -->   
        <div class="container-fluid bg-primary">
        <nav class="navbar navbar-dark">
            <div class="container-fluid">
            <a class="navbar-brand" href="accueil.php">
                <img src="images/caduceus-2029254_640.webp" width="50" height="60">
                здоровье
            </a>
            <div class="barre">
            <form action="accueil.php" method="get">
                <?php
                    if (!empty($_SESSION['connected']) && $_SESSION['connected']){
                        echo "<a class='btn btn-primary' href='infoPage.php' role='button'>Vos informations</a>";
                        echo "<button class='btn btn-outline-light' type='submit' name='deconnexion'>Déconnexion</button>";
                    }
                ?>
            </form>    
                <button class="btn btn-outline-light" type="submit" onclick="window.location.href = 'loginUser.php';">Se connecter</button>
            </div>
            </div>
        </nav>
    </div>
    </div>
           
    <?php
        if (isset($_GET['deconnexion'])){
            session_destroy();
        }
    
        if (!empty($_SESSION['connected']) && $_SESSION['connected']){
            // Welcome message
            echo "<div class='d-flex justify-content-center'>";
            echo "<h2>Bienvenue " . $_SESSION['nom'] . " " . $_SESSION['prenom'] . " !</h2>";
            echo "</div>";
            if ($_SESSION['isUser'] == true){
                // Search Bar 
                echo "<div class='d-flex justify-content-center'>";
                echo "               
                <div class='m-1 p-1 bg-light'>
                <nav class='navbar navbar-light bg-light'>
                <form class='form-inline' action='accueil.php' method='get'>
                <input class='form-control mr-sm-2' name='nse' type='search' placeholder='Nom, spécialité, établissement' aria-label='Search'>
                <input class='form-control mr-sm-2' name='lieu' type='search' placeholder='Lieu' aria-label='Search'>
                <div class='d-flex justify-content-center'>
                <button class='btn btn-outline-success my-2 my-sm-0' type='submit' name='rechercher'>Rechercher</button>
                </div> 
                </form>
                </nav> 
                </div> 
                ";
                echo "</div>";
            }
        }
    
        if (isset($_GET['rechercher'])){ 
            $searchArr = searchDoc($db, $_GET['lieu'], $_GET['nse']);
            $n = count($searchArr);
            echo "<h4>" . $n . "  résultats trouvés :</h4>";
            
            echo "<form action='takeAppointment.php' method='get'>";
            foreach($searchArr as $value){
                echo "<div class='flex-fill m-1 p-1 bg-light'>";
                echo "<div class='card w-75'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $value['nom'] . " " . $value['prenom'] . "</h5>";
                echo "<p class='card-text'>spécialité : ". $value['specialite'] . ", téléphone : " . $value['telephone'] . ", établissement : " . $value['etablissement'] . ", adresse :  " . $value['adresse']  . " " . $value['ville']  . " " . $value['code_postal']. "</p>";
                echo "<button name='button' type='submit' value=" . $value['mail'] . " class='btn btn-primary'> Prendre un rendez-vous </button>";
                //echo "<a href='takeAppointment.php' class='btn btn-primary' name='selectedDoc'>Button</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</form>";
        }
        
    ?>   
    </div>
   </body>
</html>
