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
    //---------------------------------------------------------- Verification funciton  ----------------------------------------------------------
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
    
    
    //isAppointmentPossible(...)
    function isAppointmentPossible($db, $mailDoc, $jour, $heure){
        // display informations
        //$rdvYear = $jour->format('Y');
        //$rdvMonth = $jour->format('d');
        //$rdvDay = $jour->format('m');
        //$rdvHour = $heure->format('i');
        //echo "<br><br><hr>Rdv date hour : " . $rdvDay . "-" . $rdvMonth . "-" . $rdvYear . "   " . $rdvHour;
        
        // check if the appointment jour/day has not been already taken
        $arrAppointment = getAppointmentDay($db, $mailDoc, $jour);
        foreach ($arrAppointment as $key => $value) {
            if ($value['heure'] == $heure){
                return false;
            }
        }
        return true;
    }    
    
    
    //takeAppointment(...)
    function takeAppointment($db, $mailDoc, $mailPatient, $jour, $heure){
        // check if appointment possible
        if (!isAppointmentPossible($db, $mailDoc, $jour, $heure)){
            echo "Appointment is impossible to take";
            return false;
        }
        
        // adding appointment to the database
        $stmt = $db->prepare("INSERT INTO prendre (mail, mail_patient, jour, heure) VALUES (:mail, :mail_patient, :jour, :heure)");
        $stmt->bindParam(':mail', $mailDoc);
        $stmt->bindParam(':mail_patient', $mailPatient);
        //$jourRdv = $jour->format('Y-m-d'); normalement pas besoin de conversion car chaines de caracteres passée en parametre
        //$heureRdv = $heure->format('Y-m-d');
        $stmt->bindParam(':jour', $jour);
        $stmt->bindParam(':heure', $heure);
        $stmt->execute();
        return true;
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
    }
    
    
    //----------------------------------------------------------------------------
    //---------------------------------------------------------- Functions to get tables ----------------------------------------------------------
    //----------------------------------------------------------------------------
    
    //getAppointmentDay(...)
    function getAppointmentDay($db, $mailDoc, $jour){
        $request = 'SELECT * FROM prendre WHERE mail=:mail and jour=:jour';
        $statement = $db->prepare($request);
        $statement->bindParam(':mail', $mail);
        $statement->bindParam(':jour', $mail);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    //getEtablissements(...)
    function getEtablissements($db){
        $statement = $db->query('SELECT * FROM etablissement');
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
    function getLieuSpecialiteDoc($db, $specialite, $ville){ 
        $request = 'SELECT * FROM doc WHERE ville=:ville and specialite=:specialite';
        $statement = $db->prepare($request);
        $statement->bindParam(':ville', $ville);
        $statement->bindParam(':specialite', $specialite);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    //getLieuEtablissementDoc(...)
    function getLieuEtablissementDoc($db, $etablissement, $ville){
        $request = 'SELECT * FROM doc WHERE ville=:ville and etablissement=:etablissement';
        $statement = $db->prepare($request);
        $statement->bindParam(':etablissement', $etablissement);
        $statement->bindParam(':ville', $ville);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
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
        echo "length array DocLieuNom : " . count($arr);
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
