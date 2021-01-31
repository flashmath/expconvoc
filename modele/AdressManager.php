<?php


namespace DIU\Logixee\Model;

require_once 'modele/Manager.php';

class AdressManager extends Manager
{

    public function __construct()
    {
        parent::__construct();
    }

    private function isValideAdresse($adr,&$error,$key){
        if (strlen($adr)<100){
            return true;
        } else {
            $error[$key] = 'La partie d\'adresse ne doit pas dépasser 100 caractères';
            return false;
        }
    }

    public function isValideAdresse1($adr,&$error){
        return $this->isValideAdresse($adr,$error,'adresse1');
    }

    public function isValideAdresse2($adr,&$error){
        return $this->isValideAdresse($adr,$error,'adresse2');
    }

    public function isValideCode($adr,&$error){
        if (preg_match('/[0-9]{5}/',$adr)==1){
            return true;
        } else {
            $error['code'] = 'Le code postal doit contenir 5 chiffres';
            return false;
        }
    }

    public function isValideId($id,&$error){
        return filter_var($id,FILTER_VALIDATE_INT);
    }

    public function isValideVille($ville,&$error){
        if (strlen($ville)<100){
            return true;
        } else {
            $error['ville'] = 'Le nom de la ville ne doit pas dépasser 100 caractères';
            return false;
        }
    }

    public function updateAdress($id,$adress1,$adress2,$code,$ville,&$error){
        $datas = array(
            "adresse1" => $adress1,
            "adresse2" => $adress2,
            "code" => $code,
            "ville" => $ville,
            "id" => $id
        );
        if (!($error = $this->validateData($datas))) {
            $sql = "UPDATE adresse SET Adresse1=:adresse1,Adresse2=!adresse2,code=:code, Ville=:ville WHERE idAdresse=:id";
            $req = $this->db->prepare($sql);
            if (!$req->execute($datas)) {
                print_r($req->errorInfo());
                die();
            }
        }
    }

}