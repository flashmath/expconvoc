<?php


namespace DIU\Logixee\Model;

require_once 'modele/Manager.php';

class ClientManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getNbCients(){
        $req = $this->db->prepare('SELECT count(*) as nb FROM client');
        $req->execute();
        $response = $req->fetch();
        return $response['nb'];
    }
}