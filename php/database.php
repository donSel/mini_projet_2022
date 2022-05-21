<?php
    include ('constants.php');
    
    
    //dbConnect(...)
    function dbConnect(){

        $dsn = 'pgsql:dbname='.DB_NAME.';host='.DB_SERVER.';port='.DB_PORT.';';
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
        $stmt = $db->prepare("INSERT INTO patient (mail, nom, prenom, mdp, telephone) VALUES (:mail, :nom, :prenom, :mdp, 89654)");
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mdp', $mdp);
        //$stmt->bindParam(':telephone', $telephone);
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
        $stmtDocTable = $db->prepare("INSERT INTO doc (mail, mdp, nom, prenom, specialite, telephone, etablissement, adresse, ville, code_postal) 
                                    VALUES (:mail, :mdp, :nom, :prenom, :specialite, :telephone, :etablissement, :adresse, :ville, :code_postal)");
        $stmtDocTable->bindParam(':nom', $nom);
        $stmtDocTable->bindParam(':prenom', $prenom);
        $stmtDocTable->bindParam(':mail', $mail);
        $stmtDocTable->bindParam(':mdp', $mdp);
        $stmtDocTable->bindParam(':telephone', $telephone);
        $stmtDocTable->bindParam(':specialite', $specialite);
        $stmtDocTable->bindParam(':etablissement', $etablissement);
        $stmtDocTable->bindParam(':adresse', $adresse);
        $stmtDocTable->bindParam(':ville', $ville);
        $stmtDocTable->bindParam(':code_postal', $code_postal);
        $stmtDocTable->execute();
        
        // Updating user array
        $commptes = getComptes($db, $mail, $mdp, false);
    }
    
    
    //takeAppointment(...)
    function takeAppointment($db, $mail, $mail_patient, $jour_heure){
        $stmt = $db->prepare("INSERT INTO prendre (mail, mail_patient, jour_jeure) VALUES (:mail, :mail_patient, :jour_heure)");
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':mail_patient', $mail_patient);
        $stmt->bindParam(':jour_heure', $jour_heure);
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
    function getEtablissement($db, $etablissement, $code_postal){ // faire val par défaut etc... pour fonction recherche
        $request = 'SELECT * FROM doc WHERE etablissement=:etablissement and code_postal=:code_postal';
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
    
    
    //takeAppointment(...)
    
    
    
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
