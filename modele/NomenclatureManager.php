<?php


namespace DIU\Logixee\Model;

require_once 'modele/Manager.php';


class NomenclatureManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function isValideCode($code,&$error): bool
    {
        if (preg_match('/[0-9]{11}/',$code)==1){
            return true;
        } else {
            $error['code'] = 'Le code '.$code.' de MEF est non conforme';
            return false;
        }
    }

    public function isValideFormation($formation,&$error): bool{
        if (strlen($formation)<=10){
            return true;
        } else {
            $error['formation'] = 'La formation '.$formation.' a un nom trop long';
            return false;
        }
    }

    public function isValideLibelle($lib,&$error): bool{
        if (strlen($lib)<=255){
            return true;
        } else {
            $error['libelle'] = 'Le libelle '.$lib.' est trop long';
            return false;
        }
    }

    public function isValideEdition($lib,&$error): bool{
        if (strlen($lib)<=255){
            return true;
        } else {
            $error['edition'] = 'Le texte d\'edition '.$lib.' est trop long';
            return false;
        }
    }

    public function isValideRattachement($rattachement,&$error): bool{
        if ((preg_match('/[0-9]{11}/',$rattachement)==1) or ($rattachement=="")){
            return true;
        } else {
            $error['rattachement'] = 'Le code de rattachement '.$rattachement.' n\'est pas conforme';
            return false;
        }
    }

    public function insertNomenclature(&$error,$code,$formation,$libelle,$edition = null,$rattachement = null){
        $datas = array(
            "code" => $code,
            "formation" => $formation,
            "libelle" => $libelle
        );

        if (isset($edition) && ($edition!="")){
            $datas["edition"]=$edition;
        }

        if (isset($rattachement)){
            $datas["rattachement"]=$rattachement;
        }

        if (!($error = $this->validateData($datas))) {
            $sql = "INSERT INTO mefs (code_mef,formation,libelle_long,libelle_edition,mef_rattachement) VALUES (:code,:formation,:libelle,:edition,:rattachement)";
            $req = $this->db->prepare($sql);
            $req->bindValue(":code",$code, \PDO::PARAM_STR);
            $req->bindValue(":formation",$formation,\PDO::PARAM_STR);
            $req->bindValue(":libelle",$libelle,\PDO::PARAM_STR);
            if ($edition==""){
                $req->bindValue(":edition",null,\PDO::PARAM_NULL);
            } else {
                $req->bindValue(":edition",$edition,\PDO::PARAM_STR);
            }
            if ($rattachement==""){
                $req->bindValue(":rattachement",null,\PDO::PARAM_NULL);
            } else {
                $req->bindValue(":rattachement",$rattachement,\PDO::PARAM_STR);
            }
            if (!$req->execute()) {
                print_r($req->errorInfo());
                die("message ici");
            }
        }
    }

    public function updateNomenclature(&$error,$code,$formation,$libelle,$edition = null,$rattachement = null){
        $datas = array(
            "code" => $code,
            "formation" => $formation,
            "libelle" => $libelle
        );

        if (isset($edition) && ($edition!="")){
            $datas["edition"]=$edition;
        }

        if (isset($rattachement)){
            $datas["rattachement"]=$rattachement;
        }

        if (!($error = $this->validateData($datas))) {
            $sql = "UPDATE mefs SET formation = :formation ,libelle_long = :libelle ,libelle_edition = :edition, mef_rattachement = :rattachement WHERE code_mef = :code";
            $req = $this->db->prepare($sql);
            $req->bindValue(":code",$code, \PDO::PARAM_STR);
            $req->bindValue(":formation",$formation,\PDO::PARAM_STR);
            $req->bindValue(":libelle",$libelle,\PDO::PARAM_STR);
            if ($edition==""){
                $req->bindValue(":edition",null,\PDO::PARAM_NULL);
            } else {
                $req->bindValue(":edition",$edition,\PDO::PARAM_STR);
            }
            if ($rattachement==""){
                $req->bindValue(":rattachement",null,\PDO::PARAM_NULL);
            } else {
                $req->bindValue(":rattachement",$rattachement,\PDO::PARAM_STR);
            }
            if (!$req->execute()) {
                print_r($req->errorInfo());
                die("message ici");
            }
        }
    }

    public function exist($code): bool{
        $result = false;
        $datas = array(
            "code" => $code
        );
        if (!($error = $this->validateData($datas))) {
            $sql = "SELECT * FROM mefs WHERE code_mef = :code";
            $req = $this->db->prepare($sql);
            $req->execute($datas);
            $count = current($req->fetch());
            $result = $count>0;
        }
        return $result;
    }

}