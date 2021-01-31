<?php


namespace DIU\Logixee\Model;

require_once 'modele/Manager.php';

class LnkDivisionMefManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function isValideDivision($code,&$error){
        if (strlen($code)<=10){
            return true;
        } else {
            $error['division'] = 'Le code '.$code.' de division est trop long';
            return false;
        }
    }

    public function isValideMef($code,&$error){
        if (preg_match('/[0-9]{11}/',$code)==1){
            return true;
        } else {
            $error['mef'] = 'Le code '.$code.' de MEF est non conforme';
            return false;
        }
    }

    public function insertLink($codeDivision,$codeMef){
        $datas = array(
            "division" => $codeDivision,
            "mef" => $codeMef
        );

        if (!($error = $this->validateData($datas))) {
            $sql = "INSERT INTO lnkDivisionMef (idDivision,idMef) VALUES (:division,:mef)";
            $req = $this->db->prepare($sql);
            if (!$req->execute($datas)) {
                print_r($req->errorInfo());
                die("message ici");
            }
        }
    }
}