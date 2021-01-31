<?php


namespace DIU\Logixee\Model;

use \PDO;

require_once 'modele/Manager.php';

class EleveManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function isValideId($id,&$error): bool{
        /*
        if (strlen($id)==7){
            return true;
        } else {
            $error['id'] = 'L\'identifiant '.$id.' est incorrect';
            return false;
        }*/

        return $this::isValideString($id,7,true,'id','L\'identifiant '.$id.' est incorrect',$error);
    }

    public function isValideElenoet($no,&$error): bool{
        return $this::isValideString($no,5,true,'elenoet','Le numéro elenoet '.$no.' est incorrect',$error);
    }

    public function isValideIne($ine,&$error): bool{
        return $this::isValideString($ine,11,true,'ine','L\'identifiant INE '.$ine.' est incorrect',$error);
    }

    public function isValideNom($text,&$error): bool{
        return $this::isValideString($text,100,false,'nom','Le nom est trop long',$error);
    }

    public function isValidePrenom1($text,&$error): bool{
        return $this::isValideString($text,100,false,'prenom1','Le prénom1 est trop long',$error);
    }

    public function isValidePrenom2($text,&$error): bool{
        return $this::isValideString($text,100,false,'prenom2','Le prénom2 est trop long',$error);
    }

    public function isValidePrenom3($text,&$error): bool{
        return $this::isValideString($text,100,false,'prenom3','Le prénom3 est trop long',$error);
    }

    public function isValideNaissance($text,&$error): bool{
        return $this::isValideDate($text,'naissance','La date de naissance n\est pas correcte',$error);
    }

    public function isValideMel($text,&$error): bool{
        return $this::isValideEmail($text,'mel','Adresse de messagerie invalide',true,$error);
    }

    public function isValideMef($text,&$error): bool{
        return $this::isValideString($text,11,true,'mef','Code MEF invalide',$error);
    }

    public function insertEleve(&$error,$id,$elenoet,$ine,$nom,$prenom1,$prenom2,$prenom3,$naissance,$mel,$mef){
        $datas = array(
            "id" => $id,
            "elenoet" => $elenoet,
            "ine" => $ine,
            "nom" => $nom,
            "prenom1" => $prenom1,
            "prenom2" => $prenom2,
            "prenom3" => $prenom3,
            "naissance" => $naissance,
            "mel" => $mel,
            "mef" => $mef
        );

        if (!($error = $this->validateData($datas))) {
            $sql = "INSERT INTO eleves (IdEleve, elenoet, ine, nom, prenom1, prenom2, prenom3, date_naissance, mel, codemef) VALUES (:id,:elenoet,:ine,:nom,
            :prenom1,:prenom2,:prenom3,:naissance,:mel,:mef)";
            $req = $this->db->prepare($sql);
            $req->bindValue(":id",$id);
            $req->bindValue(":elenoet",$elenoet);
            $req->bindValue(":ine",$ine);
            $req->bindValue(":nom",$nom);
            $req->bindValue(":prenom1",$prenom1);
            $this::bindValue($req,":prenom2",$prenom2);
            $this::bindValue($req,":prenom3",$prenom3);

            list($jour,$mois,$annee)=explode("/",$naissance);
            $naissance=date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
            $req->bindValue(":naissance",$naissance);
            $this::bindValue($req,":mel",$mel);
            $req->bindValue(":mef",$mef);

            if (!$req->execute()) {
                print_r($req->errorInfo());
                die("message ici");
            }
        }
    }

}