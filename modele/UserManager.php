<?php
namespace DIU\Logixee\Model;

require_once 'modele/Manager.php';

class UserManager extends Manager
{
    public function getUser($login){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT idUser,password,role FROM user WHERE login = :pseudo');
        $req->execute(array(
            'pseudo' => $login
        ));
        return $req->fetch();
    }
}