<?php
    include ('constants.php');
    
    
    //dbdbect(...)
    function dbConnect(){

        $dsn = 'pgsql:dbname='.DB_NAME.';host='.DB_SERVER.';port='.DB_PORT.';';
        $user = DB_USER;
        $password = DB_PASSWORD;

        try{
            $db = new PDO($dsn, $user, $password);
            return $db;
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
    function isGoodLogin($db, $mail, $mdp, $user){ 
        if ($user == true){
            $arrCompte = getCompte($db, $mail, $mdp, true);
        } else {
            $arrCompte = getCompte($db, $mail, $mdp, false);
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
        // converting to lower case informations
        $specialite = strtolower($specialite);
        $etablissement = strtolower($etablissement);
        $ville = strtolower($ville);
        $nom = strtolower($nom);
        $prenom = strtolower($prenom);
                
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
        $statement = $db->query('SELECT * FROM etablissement');
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
    function getCodeDoc($db, $code_postal){ 
        $request = 'SELECT * FROM doc WHERE code_postal=:code_postal';
        $statement = $db->prepare($request);
        $statement->bindParam(':code_postal', $code_postal);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }

    
    //getVilleDoc(...)
    function getVilleDoc($db, $ville){ 
        $request = 'SELECT * FROM doc WHERE ville=:ville';
        $statement = $db->prepare($request);
        $statement->bindParam(':ville', $ville);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getNomDoc(...)
    function getNomDoc($db, $nse){ 
        $request = 'SELECT * FROM doc WHERE nom=:nom';
        $statement = $db->prepare($request);
        $statement->bindParam(':nom', $nse);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }

    
    //getSpecialiteDoc(...)
    function getSpecialiteDoc($db, $nse){ 
        $request = 'SELECT * FROM doc WHERE specialite=:specialite';
        $statement = $db->prepare($request);
        $statement->bindParam(':specialite', $nse);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getEtablissementDoc(...)
    function getEtablissementDoc($db, $nse){
        $request = 'SELECT * FROM doc WHERE etablissement=:etablissement';
        $statement = $db->prepare($request);
        $statement->bindParam(':etablissement', $nse);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getLieuNomDoc(...)
    function getLieuNomDoc($db, $nom, $ville){ 
        $request = 'SELECT * FROM doc WHERE nom=:nom and ville=:ville';
        $statement = $db->prepare($request);
        $statement->bindParam(':nom', $nom);
        $statement->bindParam(':ville', $ville);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }

    
    //getLieuSpecialiteDoc(...)
    function getLieuSpecialiteDoc($db, $nom, $specialite){ 
        $request = 'SELECT * FROM doc WHERE nom=:nom and specialite=:specialite';
        $statement = $db->prepare($request);
        $statement->bindParam(':nom', $nom);
        $statement->bindParam(':specialite', $specialite);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getLieuEtablissementDoc(...)
    function getLieuEtablissementDoc($db, $nom, $etablissement){
        $request = 'SELECT * FROM doc WHERE nom=:nom and etablissement=:etablissement';
        $statement = $db->prepare($request);
        $statement->bindParam(':nom', $nom);
        $statement->bindParam(':etablissement', $etablissement);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getAppointmentsDoc(...)
    function getAppointmentsDoc($db, $mail){
        $request = 'SELECT * FROM prendre WHERE mail=:mail';
        $statement = $db->prepare($request);
        $statement->bindParam(':mail', $mail);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getOldAppointmentsUser(...)
    function getOldAppointmentsUser($db, $mail_patient, $mail){
        $request = 'SELECT * FROM prendre WHERE mail=:mail and mail_patient=:mail_patient';
        $statement = $db->prepare($request);
        $statement->bindParam(':mail', $mail);
        $statement->bindParam(':mail_patient', $mail_patient);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //takeAppointment(...)
    
    
    //getCompte(...)
    function getCompte($db, $mail, $user){
        if ($user == true){
            $request = 'SELECT * FROM patient WHERE mail=:mail';
        } else {
            $request = 'SELECT * FROM doc WHERE mail=:mail';
        }
        $statement = $db->prepare($request);
        $statement->bindParam(':mail', $mail);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }    
    
    
    //getComptes(...)
    function getComptes($db, $user){
        if ($user == true){
            $request = 'SELECT * FROM patient';
        } else {
            $request = 'SELECT * FROM doc';
        }
        $statement = $db->prepare($request);
        $statement->bindParam(':mail', $mail);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }   
    
    
    //----------------------------------------------------------------------------
    //---------------------------------------------------------- Functions to research a doctor ----------------------------------------------------------
    //----------------------------------------------------------------------------
 
    //faire une seule fonction avec valeurs par défaut afin d'appeler 
    
    //getDocLieu(...) //fonctionne avec code postal et nom ville
    function getDocLieu($db, $lieu){
        $lowerLieu = strtolower($lieu);
        $arr = getCodeDoc($db, $lowerLieu);
        if (count($arr) != 0){
            return $arr;
        }
        else {
            $arr = getVilleDoc($db, $lowerLieu);
            if (count($arr) != 0){
                return $arr;
            }
            else {  // array is empty
                return $arr;
            }
        }
    }
    
    
    //getDocNSE(...)
    function getDocNSE($db, $nse){
        $nse = strtolower($nse);
        $arr = getNomDoc($db, $nse);
        if (count($arr) != 0){
            return $arr;
        }
        else {
            $arr = getSpecialiteDoc($db, $nse);
            if (count($arr) != 0){
                return $arr;
            } 
            else {
                $arr = getEtablissementDoc($db, $nse);
                if (count($arr) != 0){
                    return $arr;
                }
                else { // array is empty
                    return $arr;
                }
            }
        }
    }
    
    
    //getDocLieuAndNSE(...) fonctionne suelement avec le nom des villes
    function getDocLieuAndNSE($db, $lieu, $nse){ 
        $lieu = strtolower($lieu);
        $nse = strtolower($nse);
        $arr = getLieuNomDoc($db, $nse, $lieu);
        if (count($arr) != 0){
            return $arr;
        }
        else {
            $arr = getLieuSpecialiteDoc($db, $nse, $lieu);
            if (count($arr) != 0){
                return $arr;
            } 
            else {
                $arr = getLieuEtablissementDoc($db, $nse, $lieu);
                if (count($arr) != 0){
                    return $arr;
                }
                else { // array is empty
                    return $arr;
                }
            }
        }
    }
    
    
    //searchDoc(...)
    function searchDoc($db, $lieu = '', $nse = ''){
        if ($lieu == ''){
            return getDocNSE($db, $nse);
        }
        elseif ($nse == ''){
            return getDocLieu($db, $lieu);
        }
        return getDocLieuAndNSE($db, $lieu, $nse);
    }
    
?>
