<?php
    include ('constants.php');
    
    
    //dbConnect(...)
    function dbConnect(){

        $dsn = 'pgsql:dbname='.DB_NAME.';host='.DB_SERVER.';port='.DB_PORT.";";
        $user = DB_USER;
        $password = DB_PASSWORD;

        try{
            $conn = new PDO($dsn, $user, $password);
            return $conn;
        }
        catch (PDOException $e){

            echo 'Connexion échouée : ' . $e->getMessage();

            return false;
        }
    }
         
    
    //----------------------------------------------------------------------------
    //---------------------------------------------------------- Additional functions ----------------------------------------------------------
    //----------------------------------------------------------------------------
  
    
    //isStringSame(...)
    function isStringSame($string1, $string2){
        return ($string1 == $string2);
    }
    
    
    //isGoodLogin(...)
    function isGoodLogin($conn, $mail, $mdp, $user){ 
        if ($user == true){
            $arrComptes = getComptes($conn, $mail, $mdp, true);
        } else {
            $arrComptes = getComptes($conn, $mail, $mdp, false);
        }
        //$count = 0; Old version
        //foreach ($arrComptes as $val){
        //    if ($val[mail] == $id && $val[mdp] == $mdp){
        //        $count = $count + 1;
        //    }
        //}
        //if ($count != 0){
        //    return true;
        //}
        //else {
        //    return false;
        //}
        foreach ($arrComptes as $val){
            if ($val[mail] == $id && $val[mdp] == $mdp){
                return true;
            }
        }
        return false;
    }
    
    
    //mailExists(...)
    function mailExists($db, $mail, $user){
        if ($user == true){
            $arrComptes = getComptes($conn, $mail, $mdp, true);
        } else {
            $arrComptes = getComptes($conn, $mail, $mdp, false);
        }
        foreach ($arrComptes as $val){
            if ($val[mail] == $mail){
                return true;
            }
        }
        return false;
    }
    
     
    //----------------------------------------------------------------------------
    //---------------------------------------------------------- Functions to add information to tables ----------------------------------------------------------
    //----------------------------------------------------------------------------
  
        
    //addUser(...)
    function addUser($db, $mdp, $firstName, $lastName, $mail, $telephone){
        // Statement compte patient
        $stmt = $db->prepare("INSERT INTO patient (mail, nom, prenom, mdp, telephone) VALUES (:mail, :nom, :prenom, :mdp, :telephone)");
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mdp', $mdp);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->execute();
        echo "$mdp\n";
        echo "$firstName\n";
        echo "$lastName\n";
        echo "$mail\n";
        echo "$telephone\n";
        
        // Updating user array
        $commptes = getComptes($db, $mail, $mdp, true);
    }
    
    
    //addDoc(...) 
    function addDoc($db, $mdp, $firstName, $lastName, $mail, $telephone, $specialite, $etablissement, $adresse, $ville, $code_postal){
        // Statement compte doc
        $stmtDocTable = $db->prepare("INSERT INTO doc (mail, mdp, nom, prenom, specialite, telephone) VALUES (:mail, :mdp, :nom, :prenom, :specialite, :telephone)");
        $stmtDocTable->bindParam(':nom', $nom);
        $stmtDocTable->bindParam(':prenom', $prenom);
        $stmtDocTable->bindParam(':mail', $mail);
        $stmtDocTable->bindParam(':mdp', $mdp);
        $stmtDocTable->bindParam(':telephone', $telephone);
        $stmtDocTable->bindParam(':specialite', $specialite);
        $stmtDocTable->execute();
        
        // Statement etablissement table
        addEtablissement($db, $etablissement, $adresse, $ville, $code_postal);
        
        // Statement appartenir table
        addAppartenir($db, $etablissement, $mail, $code_postal);
        
        // Updating user array
        $commptes = getComptes($db, $mail, $mdp, false);
    }
    
    
    //addEtablissement(...)
    function addEtablissement($db, $etablissement, $adresse, $ville, $code_postal){
        $arr = getEtablissement($db, $etablissement, $code_postal);
        if (count($arr) == 0){
            $stmtEtablissementTable = $db->prepare("INSERT INTO etablisssement (etablissement, adresse, ville, code_postal) VALUES (:etablissement, :adresse, :ville, :code_postal)");
            $stmtEtablissementTable->bindParam(':etablissement', $etablissement);
            $stmtEtablissementTable->bindParam(':adresse', $adresse);
            $stmtEtablissementTable->bindParam(':ville', $ville);
            $stmtEtablissementTable->bindParam(':code_postal', $code_postal);
            $stmtEtablissementTable->execute();
        }
    }
    
    
    //addAppartenir(..)
    function addAppartenir($db, $etablissement, $mail, $code_postal){
        $stmtAppartenirTable = $db->prepare("INSERT INTO appartenir (etablissement, mail, code_postal) VALUES (:etablissement, :mail, :code_postal)");
        $stmtAppartenirTable->bindParam(':mail', $mail);
        $stmtAppartenirTable->bindParam(':etablissement', $etablissement);
        $stmtAppartenirTable->bindParam(':code_postal', $code_postal);
        $stmtAppartenirTable->execute();
        echo "jfzeop";
    }
    
    
    //takeAppointment(...)
    function takeAppointment($db, $mail, $mail_patient, $heure, $jour){
        $stmt = $db->prepare("INSERT INTO prendre (mail, mail_patient, heure, jour) VALUES (:mail, :mail_patient, :heure, :jour)");
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':mail_patient', $mail_patient);
        $stmt->bindParam(':heure', $heure);
        $stmt->bindParam(':jour', $jour);
        $stmt->execute();
    }
    
    
    //----------------------------------------------------------------------------
    //---------------------------------------------------------- Functions to get tables ----------------------------------------------------------
    //----------------------------------------------------------------------------
    
    
    //getEtablissements(...)
    function getEtablissements($db){
        $statement = $conn->query('SELECT * FROM etablissement');
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getEtablissement(...)
    function getEtablissement($db, $etablissement, $code_postal){
        $request = 'SELECT * FROM etablissement WHERE etablissement=:etablissement and code_postal=:code_postal';
        $statement = $conn->prepare($request);
        $statement->bindParam(':code_postal', $code_postal);
        $statement->bindParam(':etablissement', $etablissement);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getAppointmentsDoc(...)
    function getAppointmentsDoc($db, $mail){
        $request = 'SELECT * FROM prendre WHERE mail=:mail';
        $statement = $conn->prepare($request);
        $statement->bindParam(':mail', $mail);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getOldAppointmentsUser(...)
    function getOldAppointmentsUser($db, $mail_patient, $mail){
        $request = 'SELECT * FROM prendre WHERE mail=:mail and mail_patient=:mail_patient';
        $statement = $conn->prepare($request);
        $statement->bindParam(':mail', $mail);
        $statement->bindParam(':mail_patient', $mail_patient);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getComptes(...)
    function getComptes($conn, $mail, $mdp, $user){
        if ($user == true){
            $request = 'SELECT * FROM patient WHERE mail=:mail';
        } else {
            $request = 'SELECT * FROM doc WHERE mail=:mail';
        }
        $statement = $conn->prepare($request);
        $statement->bindParam(':mail', $mail);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }    
?>
