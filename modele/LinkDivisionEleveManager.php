<?php


namespace DIU\Logixee\Model;

require_once 'modele/Manager.php';

class LinkDivisionEleveManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function isValideDivision($code,&$error): bool{
        if (strlen($code)<=10){
            return true;
        } else {
            $error['division'] = 'Le code '.$code.' de division est trop long';
            return false;
        }
    }

    public function isValideEleve($code,&$error): bool{
        if (preg_match('/[0-9]{7}/',$code)==1){
            return true;
        } else {
            $error['eleve'] = 'Le code '.$code.' élève est non conforme';
            return false;
        }
    }

    public function insertLink($codeDivision,$codeEleve){
        $datas = array(
            "division" => $codeDivision,
            "eleve" => $codeEleve
        );

        if (!($error = $this->validateData($datas))) {
            $sql = "INSERT INTO lnkDivisionEleve (idDivision,idEleve) VALUES (:division,:eleve)";
            $req = $this->db->prepare($sql);
            if (!$req->execute($datas)) {
                print_r($req->errorInfo());
                die("message ici");
            }
        }
    }
}