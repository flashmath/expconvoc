<?php

namespace DIU\Logixee\Model;

require_once "modele/Manager.php";

class AgencyManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAgencies($id){
        $datas = array(
            "id" => $id
        );
        $req = $this->db->prepare("SELECT a.*, ad.Adresse1, ad.Adresse2, ad.Code_Postal as Code, ad.Ville 
            FROM agence a INNER JOIN adresse ad ON a.adresse = ad.idAdresse 
            WHERE a.idOrder = :id");
        $req->execute($datas);

    }
}