<?php


namespace DIU\Logixee\Model;

require_once 'modele/Manager.php';

class AdminManager extends Manager
{
    public function getAdmin($adminID){
        $db = $this->dbConnect();
    }

}