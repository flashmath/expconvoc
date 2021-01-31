<?php
   session_start();
try {
    $bdd = new PDO('mysql:host=localhost;dbname=diu-eil;charset=utf8', 'test', '2487fa');
} catch (Exception $e) {
    die('erreur : ' . $e->getMessage());

}

?>
