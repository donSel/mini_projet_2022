<?php
    include ('constants.php');

    //dbConnect(...)
    function dbConnect(){

        $dsn = 'pgsql:dbname='.DB_NAME.';host='.DB_SERVER.';port='.DB_PORT;
        $user = DB_USER;
        $password = DB_PASSWORD;

        try{
            return new PDO($dsn, $user, $password);
        }
        catch (PDOException $e){

            echo 'Connexion échouée : ' . $e->getMessage();

            return false;
        }
    }
    
    //isGoodPassword(...)
    function isGoodPassword($string1, $string2){
        return ($string1 == $string2);
    }
    
    //isGoodUserLogin(...)
    function isGoodUserLogin($conn, $id, $mdp){
        $arrComptes = getComptesUsers($conn, $id, $mdp);
        $count = 0;
        foreach ($arrComptes as $val){
            if ($val[id_user] == $id && $val[mdp] == $mdp){
                $count = $count + 1;
            }
        }
        if ($count != 0){
            return true;
        }
        else {
            return false;
        }
    }

    //getComptesUsers(...)
    function getComptesUsers($conn, $id_user, $mdp){
        $request = 'SELECT * FROM user WHERE id_user=:id_user and mdp=:mdp';
        $statement = $conn->prepare($request);
        $statement->bindParam(':id_user', $id_user);
        $statement->bindParam(':mdp', $mdp);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }

    //getComptesDocs(...)
    function getComptesDocs($conn, $id_doc, $mdp){
        $request = 'SELECT * FROM user WHERE id_doc=:id_doc and mdp=:mdp';
        $statement = $conn->prepare($request);
        $statement->bindParam(':id_doc', $id_user);
        $statement->bindParam(':mdp', $mdp);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    //addUser(...)
    function addUser($id, $mdp, $firstName, $lastName, $mail, $telephone){
        // Statement compte user
        $stmt = $db->prepare("INSERT INTO user (id_user, nom, prenom, mail, mdp, telephone) VALUES (:id_user, :nom, :prenom, :mail, :mdp, :telephone)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':mdp', $mdp);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->execute();
        
        // Updating user array
        $commptes = getComptes($db, $id, $mdp);
        $solde = getSolde($db, $id);
    }

    echo isGoodPassword(test, test);
    echo "ouo";
?>
<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta charset=utf-8>
        <title></title>
    </head>
    <body>
        sheesh
    </body>
</html>