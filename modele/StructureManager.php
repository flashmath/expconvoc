<?php


namespace DIU\Logixee\Model;

require_once 'modele/Manager.php';

class StructureManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function isValideCode($code,&$error): bool{
        if (strlen($code)<=10){
            return true;
        } else {
            $error['code'] = 'Le code '.$code.' de division est trop long';
            return false;
        }
    }

    public function isValideLibelle($lib,&$error): bool{
        if (strlen($lib)<=100){
            return true;
        } else {
            $error['libelle'] = 'Le libelle '.$lib.' est trop long';
            return false;
        }
    }

    public function insertStructure(&$error,$code,$libelle){
        $datas = array(
            "code" => $code,
            "libelle" => $libelle
        );
        if (!($error = $this->validateData($datas))) {
            $sql = "INSERT INTO division (idDivision,libelle_long) VALUES (:code,:libelle)";
            $req = $this->db->prepare($sql);
            if (!$req->execute($datas)) {
                print_r($req->errorInfo());
                die("message ici");
            }
        }
    }
}