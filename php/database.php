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
            $arrCompte = getCompte($conn, $mail, $mdp, true);
        } else {
            $arrCompte = getCompte($conn, $mail, $mdp, false);
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
        foreach ($arrCompte as $val){
            if ($val['mail'] == $mail && $val['mdp'] == $mdp){
                return true;
            }
        }
        return false;
    }
    
    
    //mailExists(...)
    function mailExists($db, $mail, $user){
        if ($user == true){
            $arrCompte = getCompte($db, $mail, true);
        } else {
            $arrCompte = getCompte($db, $mail, false);
        }
        foreach ($arrCompte as $val){
            if ($val['mail'] == $mail){
                return true;
            }
        }
        return false;
    }
    
     
    //----------------------------------------------------------------------------
    //---------------------------------------------------------- Functions to add information to tables ----------------------------------------------------------
    //----------------------------------------------------------------------------
  
        
    //addUser(...)
    function addUser($db, $mdp, $nom, $prenom, $mail, $telephone){
        // Statement compte patient        
        $stmt = $db->prepare("INSERT INTO patient (mail, nom, prenom, mdp, telephone) VALUES (:mail, :nom, :prenom, :mdp, :telephone)");
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mdp', $mdp);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->execute();
    }
    
    
    //addDoc(...) 
    function addDoc($db, $mdp, $nom, $prenom, $mail, $telephone, $specialite, $etablissement, $adresse, $ville, $code_postal){
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
        
        echo "doc added";
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
    
    
    //getCodeEtablissementDoc(...)
    //function getCodeEtablissementDoc($db, $etablissement, $code_postal){ // faire val par défaut etc... pour fonction recherche
    //    $request = 'SELECT * FROM doc WHERE etablissement=:etablissement and code_postal=:code_postal';
    //    $statement = $conn->prepare($request);
    //    $statement->bindParam(':code_postal', $code_postal);
    //    $statement->bindParam(':etablissement', $etablissement);
    //    $statement->execute();
    //    return $statement->fetchAll(PDO::FETCH_ASSOC); 
    //}

    
    //getVilleEtablissementDoc(...)
    //function getVilleEtablissementDoc($db, $etablissement, $ville){ // faire val par défaut etc... pour fonction recherche
    //    $request = 'SELECT * FROM doc WHERE etablissement=:etablissement and ville=:ville';
    //    $statement = $conn->prepare($request);
    //    $statement->bindParam(':ville', $ville);
    //    $statement->bindParam(':etablissement', $etablissement);
    //    $statement->execute();
    //    return $statement->fetchAll(PDO::FETCH_ASSOC); 
    //}
    
    //getCodeDoc(...)
    function getCodeDoc($db, $code_postal){ // faire val par défaut etc... pour fonction recherche
        $request = 'SELECT * FROM doc WHERE code_postal=:code_postal';
        $statement = $conn->prepare($request);
        $statement->bindParam(':code_postal', $code_postal);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }

    
    //getVilleDoc(...)
    function getVilleDoc($db, $ville){ // faire val par défaut etc... pour fonction recherche
        $request = 'SELECT * FROM doc WHERE ville=:ville';
        $statement = $conn->prepare($request);
        $statement->bindParam(':ville', $ville);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getNomDoc(...)
    function getNomDoc($db, $nse){ // faire val par défaut etc... pour fonction recherche
        $request = 'SELECT * FROM doc WHERE nom=:nom';
        $statement = $conn->prepare($request);
        $statement->bindParam(':nom', $nse);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }

    
    //getSpecialiteDoc(...)
    function getSpecialiteDoc($db, $nse){ // faire val par défaut etc... pour fonction recherche
        $request = 'SELECT * FROM doc WHERE specialite=:specialite';
        $statement = $conn->prepare($request);
        $statement->bindParam(':specialite', $nse);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getEtablissementDoc(...)
    function getEtablissementDoc($db, $nse){ // faire val par défaut etc... pour fonction recherche
        $request = 'SELECT * FROM doc WHERE etablissement=:etablissement';
        $statement = $conn->prepare($request);
        $statement->bindParam(':etablissement', $nse);
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
    
    
    //getCompte(...)
    function getCompte($conn, $mail, $user){
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
    
    
    //getComptes(...)
    function getComptes($conn, $user){
        if ($user == true){
            $request = 'SELECT * FROM patient';
        } else {
            $request = 'SELECT * FROM doc';
        }
        $statement = $conn->prepare($request);
        $statement->bindParam(':mail', $mail);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }   
    
    
    //----------------------------------------------------------------------------
    //---------------------------------------------------------- Functions to research a doctor ----------------------------------------------------------
    //----------------------------------------------------------------------------
 
    //faire une seule fonction avec valeurs par défaut afin d'appeler 
    
    //getDocLieu(...)
    function getDocLieu($db, $lieu){
        $arr = getCodeDoc($db, $lieu);
        if ($count($arr) != 0){
            return $arr;
        }
        else {
            $arr = getVilleDoc($db, $lieu);
            if ($count($arr) != 0){
                return $arr;
            }
            else {
                return $arr;
            }
        }
    }
    
    
    //getDocNSE(...)
    function getDocNSE($db, $lieu){
        echo "rien";
    }
    
    
    //getDocLieuAndNSE(...)
    function getDocLieuAndNSE($db, $lieu){
        echo "rien";
    }
    
?>
