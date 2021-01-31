<?php


namespace DIU\Logixee\Model;

require_once 'modele/Manager.php';

class DriverManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getNbDrivers(){
        $req = $this->db->prepare('SELECT count(*) as nb FROM driver');
        $req->execute();
        $response = $req->fetch();
        return $response['nb'];
    }
}