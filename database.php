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
    
    //isStringSame(...)
    function isGoodPassword($string1, $string2){
        return ($string1 == $string2);
    }
    
    //isGoodLogin(...)
    function isGoodLogin($conn, $mail, $mdp, $user){ 
        if ($user == true){
            $arrComptes = getComptes($conn, $mail, $mdp, true);
        } else {
            $arrComptes = getComptes($conn, $mail, $mdp, false);
        }
        $count = 0;
        foreach ($arrComptes as $val){
            if ($val[mail] == $id && $val[mdp] == $mdp){
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
    
    //getComptes(...)
    function getComptes($conn, $mail, $mdp, $user){
        if ($user == true){
            $request = 'SELECT * FROM patient WHERE mail=:mail and mdp=:mdp';
        } else {
            $request = 'SELECT * FROM doc WHERE mail=:mail and mdp=:mdp';
        }
        $statement = $conn->prepare($request);
        $statement->bindParam(':mail', $mail);
        $statement->bindParam(':mdp', $mdp);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    //addUser(...)
    function addUser($mdp, $firstName, $lastName, $mail, $telephone){
        // Statement compte patient
        $stmt = $db->prepare("INSERT INTO patient (mail, nom, prenom, mdp, telephone) VALUES (:mail, :nom, :prenom, :mdp, :telephone)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':mdp', $mdp);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->execute();
        
        // Updating user array
        $commptes = getComptes($db, $mail, $mdp, true);
    }
    
    //addDoc(...) 
    function addDoc($mdp, $firstName, $lastName, $mail, $telephone, $specialite, $etablissement, $ville, $code_postal){
        // Statement compte doc
        $stmtDocTable = $db->prepare("INSERT INTO doc (mail, mdp, nom, prenom, specialite, telephone) VALUES (:mail, :mdp, :nom, :prenom, :specialite, :telephone)");
        $stmtDocTable->bindParam(':nom', $nom);
        $stmtDocTable->bindParam(':prenom', $prenom);
        $stmtDocTable->bindParam(':mail', $mail);
        $stmtDocTable->bindParam(':mdp', $mdp);
        $stmtDocTable->bindParam(':telephone', $telephone);
        $stmtDocTable->bindParam(':specialite', $specialite);
        $stmtDocTable->execute();
        
        // Statement appartenir table
        $stmtAppartenirTable = $db->prepare("INSERT INTO appartenir (etablissement, mail) VALUES (:etablissement, :mail)");
        $stmtAppartenirTable->bindParam(':mail', $mail);
        $stmtAppartenirTable->bindParam(':etablissement', $etablissement);
        $stmtAppartenirTable->execute();
        
        // Statement etablissement table
        $stmtEtablissementTable = $db->prepare("INSERT INTO etablissement (etablissement, ville, code_postal) VALUES (:etablissement, :ville, :code_postal)");
        $stmtEtablissementTable->bindParam(':ville', $ville);
        $stmtEtablissementTable->bindParam(':code_postal', $code_postal);
        $stmtEtablissementTable->bindParam(':etablissement', $etablissement);
        $stmtEtablissementTable->execute();
        
        // Updating user array
        $commptes = getComptes($db, $mail, $mdp, false);
    }
    
    //takeAppointment(...)
    function takeAppointment(){
        $stmt = $db->prepare("INSERT INTO prendre (mail_doc, mail_patient, heure) VALUES (:mail_doc, :mail_patient, :heure)");
        $stmt->bindParam(':mail_doc', $id);
        $stmt->bindParam(':mail_patient', $mdp);
        $stmt->bindParam(':heure', $mdp);
        $stmt->execute();
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