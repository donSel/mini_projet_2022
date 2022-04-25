<?php

include ('constants.php');

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

function isGoodPassword($string1, $string2){
    return ($string1 == $string2);
}

echo isGoodPassword(test, test);
echo "ouo";
?>