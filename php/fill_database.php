<?php
    include ('database.php');
    include ('constants.php');
    
    // Enable all warnings and errors.
    ini_set('display_errors', 1);
    error_reporting(E_ALL);


    $arrLastName = ['ROM-PUISAIS', 'ROM DANE', 'ROLZOU', 'ROLZHAUSEN', 'ROLZEN'	, 'ROLZ', 'ROLU', 'ROLTMIT'	, 'ROLTHMEIR', 'ROLT-LEVEQUE', 'ROBICOUET', 'ROBICO', 'ROBICKEZ', 'ROBICHOY', 'ROBICHOU', 'RIESSE'];
    $arrFirstName = ['Bernard', 'Thomas' , 'Petit', 'Robert', 'Richard', 'Durand', 'Dubois', 'Moreau', 'Laurent', 'Simon', 'Michel', 'Lefebvre', 'Leroy', 'Roux', 'David', 'Bertrand'];
    //16
    $mdp = 'aze';
    $tel = '0783069282';
    
    $arrSpecialite = ['proctologue', 'urologue', 'cardiologue', 'OLR', 'chirurgien de la face', 'psychiatre']; //6
    $arrEtablissement = ['CHU', 'Hopital Dieu', 'Clinique Anatole France']; ///3
    $arrAdresse = ['1 Pl. Alexis-Ricordeau', '12 boulevard de Alsace', '3 place Anatole France']; 
    $arrCodePostal = ['44093', '69120', '44100'];  
    $arrVille = ['Nantes', 'Vaulx-en-velin', 'Nantes'];
    
    $n = count($arrLastName);
    $db = dbConnect();
    
    for ($i = 0; $i < 16; $i++){
        $mail = $arrFirstName[$i] . "." . $arrLastName[$i] . "@gmail.com";
        if ($i < 7){
            addUser($db, $mdp, $arrFirstName[$i], $arrLastName[$i], $mail, $tel);
        } else {
            $randI = rand(0, 5);
            $randJ = rand(0, 2);
            addDoc($db, $mdp, $arrFirstName[$i], $arrLastName[$i], $mail, $tel, $arrSpecialite[$randI], $arrEtablissement[$randJ], $arrAdresse[$randJ], $arrVille[$randJ], $arrCodePostal[$randJ]);
        }
    }
    
    
    // prendre un rdv
    
?>