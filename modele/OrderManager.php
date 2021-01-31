<?php

namespace DIU\Logixee\Model;

require_once 'modele/Manager.php';

class OrderManager extends Manager
{

    public function __construct()
    {
        parent::__construct();
    }

    public function isValideContact($contact,&$error){
        if (strlen($contact)<100){
            return true;
        } else {
            $error['contact'] = 'Le nom du contact ne doit pas dépasser 255 caractères';
            return false;
        }
    }

    /*
    public function isValideEmail($email,&$error){
        $return = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($return){
            return true;
        } else {
            $error['email'] = 'L\'adresse mail n\'est pas valide';
            return false;
        }
    }*/

    public function isValideSiren($siren,&$error){
        if (preg_match('/[0-9]{9}/',$siren)==1){
            return true;
        } else {
            $error['siren'] = 'Le siren doit contenir 9 chiffres';
            return false;
        }
    }

    public function isValideId($id,&$error){
        return filter_var($id,FILTER_VALIDATE_INT);
    }

    public function getOrder($orderID){
            $req = $this->db->prepare('SELECT O.*, a1.idAdresse AS localID, a1.Adresse1 AS localAdr1, a1.Adresse2 AS localAdr2, a1.Code_Postal AS localCode, a1.Ville AS localVille,
a2.idAdresse AS factID, a2.Adresse1 AS factAdr1, a2.Adresse2 AS factAdr2, a2.Code_Postal AS factCode, a2.Ville AS factVille
FROM `order` O 
INNER JOIN adresse a1 ON O.`localisation`=a1.idAdresse
INNER JOIN adresse a2 ON O.`adresse_facturation`=a2.idAdresse WHERE O.idOrder = :ID');
            $req->execute(array(
                'ID' => $orderID
            ));
            return $req->fetch();
    }

    public function updateOrder($orderID,$contact,$email,$siren,&$error){
        $datas = array(
            "contact" => $contact,
            "email" => $email,
            "siren" => $siren,
            "id" => $orderID
        );
        if (!($error = $this->validateData($datas))) {
            $sql = "UPDATE `order` SET Contact=:contact,email=:email,siren=:siren WHERE idOrder=:id";
            $req = $this->db->prepare($sql);
            if (!$req->execute($datas)) {
                print_r($req->errorInfo());
                die();
            }
        }
    }

    public function getOrders($min=0,$len=0){
        $sql = 'SELECT O.*, a1.idAdresse AS localID, a1.Adresse1 AS localAdr1, a1.Adresse2 AS localAdr2, a1.Code_Postal AS localCode, a1.Ville AS localVille,
a2.idAdresse AS factID, a2.Adresse1 AS factAdr1, a2.Adresse2 AS factAdr2, a2.Code_Postal AS factCode, a2.Ville AS factVille
FROM `order` O 
INNER JOIN adresse a1 ON O.`localisation`=a1.idAdresse
INNER JOIN adresse a2 ON O.`adresse_facturation`=a2.idAdresse order by IdOrder';
        if ( $len!=0){
            $sql = $sql." LIMIT $min, $len";
        }
        $req = $this->db->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    public function getNbOrders(){
        $req = $this->db->prepare('SELECT count(*) as nb FROM `order`');
        $req->execute();
        $response = $req->fetch();
        return $response['nb'];
    }
}