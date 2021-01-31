<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date dans le passé
?>
<?php
session_start();
//include 'startuser.php';
//require_once 'modele\Manager.php';
require_once 'application/Kernel.php';
require_once 'application/Request.php';

$kernel = new Kernel();

$request = Request::createFromGlobals();


$response = $kernel->handle($request);


echo $response;




