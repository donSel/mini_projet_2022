<?php
    $arrLastName = ['ROM-PUISAIS', 'ROM DANE', 'ROLZOU', 'ROLZHAUSEN', 'ROLZEN'	, 'ROLZ', 'ROLU', 'ROLTMIT'	, 'ROLTHMEIR', 'ROLT-LEVEQUE', 'ROBICOUET', 'ROBICO', 'ROBICKEZ', 'ROBICHOY', 'ROBICHOU', 'RIESSE'];
    $arrFirstName = ['Bernard', 'Thomas' , 'Petit', 'Robert', 'Richard', 'Durand', 'Dubois', 'Moreau', 'Laurent', 'Simon', 'Michel', 'Lefebvre', 'Leroy', 'Roux', 'David', 'Bertrand'];
    //16
    $mdp = "password";
    $tel = '0783069282';
    
    $arrSpecialite = ['proctologue', 'urologue', 'cardiologue', 'OLR', 'chirurgien de la face', 'psychiatre']; //6
    $arrEtablissement = ['CHU', 'Hopital Dieu', 'Clinique Anatole France']; ///3
    $arrAdresse = ['1 Pl. Alexis-Ricordeau', '12 boulevard d\'Alsace', '3 place Anatole France']; 
    $arrCodePostal = [44093, 69120, 4400];  
    $arrVille = ['Nantes', 'Vaulx-en-velin', 'Nantes'];
    
    $n = count($arrLastName);
    $db = dbConnect();
    
    for ($i = 0; $i < $n; $i++){
        $mail = $arrFirstName[$i] . "." . $arrLastName[$i] . "@gmail.com";
        if ($i < ($n / 2)){
            addUser($db, $mdp, $arrFirstName[$i], $arrLastName[$i], $mail, $tel);
        } else {
            $randI = rand(6);
            $rabJ = rand(3);
            addDoc($db, $mdp, $arrFirstName[$i], $arrLastName[$i], $mail, $tel, $arrSpecialite[$randI], $arrEtablissement[$randJ], $arrAdresse[$randJ], $arrCodePostal[$randJ], $arrVille[$randJ]);
        }
    }
    
    // vérifier s on peut inserer 2 add mail pareil
    
    // prendre un rdv
    
    //get Etablissement/AppointmentUser/Doc/Comptes/Etablissements
?>