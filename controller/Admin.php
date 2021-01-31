<?php

require_once 'controller/Controller.php';
require_once 'modele/AdminManager.php';
require_once 'modele/OrderManager.php';
require_once 'modele/ClientManager.php';
require_once 'modele/DriverManager.php';
require_once 'modele/NomenclatureManager.php';
require_once 'modele/StructureManager.php';
require_once 'modele/EleveManager.php';
require_once 'modele/Structure.php';
require_once 'modele/LinkDivisionEleveManager.php';
require_once 'application/itemView.php';

class Admin extends Controller
{
    public function __construct()
    {

    }

    public function defaultAction(){
        return $this->getMainDeskAction();
    }

    /*
    public function getAdminDeskAction(){
        $login = $_SESSION['login'];
        $image = "img/avatar6.jpg";

        $items= array();
        array_push($items,itemView::itemMenu("active","#","fa-address-card","Caractéristiques", ""));
        array_push($items,itemView::itemMenu("","#","fa-file-import","Importations","getImportDesk();"));
        $sidebar = itemView::mainSidebar($image,$login,$items);

        $content=$this->adminDesk();
        $return_arr = array(
            "status" => 'ok',
            "content" => $content,
            "sidebar" => $sidebar
        );

        return json_encode($return_arr);

    }*/

    private function adminDesk(){
        $login = $_SESSION['login'];
        $image = "img/avatar6.jpg";

        ob_start();
        require "view/admin/adminDeskView.php";
        return ob_get_clean();

    }

    public function getMainDeskAction(){
        $adminManager = new \DIU\Logixee\Model\AdminManager();
        $login = $_SESSION['login'];

        $order = $adminManager->getAdmin($_SESSION['id']);
        $image = "img/avatar6.jpg";


        $navbarMenu = itemView::navbarRightMenu(4,10,9,$image,$login);


        $items= array();
        array_push($items,itemView::itemMenu("active","#","fa-address-card","Caractéristiques"));
        array_push($items,itemView::itemMenu("","#","fa-file-import","Importations","getImportDesk();"));
        $sidebar = itemView::mainSidebar($image,$login,$items);


        $content = $this->adminDesk();

        ob_start();
        require "view/template.php";
        return ob_get_clean();
    }

    public function postNomenclatureAction(){
        $login = $_SESSION['login'];
        $image = "img/avatar6.jpg";

        $error=array();

        if(isset($_FILES['nomenclatureInputFile']['name'])){

            $nomenclatureManager = new \DIU\Logixee\Model\NomenclatureManager();


            $xml = simplexml_load_file($_FILES['nomenclatureInputFile']['tmp_name']);

            $cont = "";
            $nomenclatureManager->beginTransaction();
            foreach ($xml->DONNEES->MEFS->MEF as $data){
                $code = $data["CODE_MEF"];
                $formation = $data->FORMATION;
                $libelle =  $data->LIBELLE_LONG;
                $edition = $data->LIBELLE_EDITION;
                $rattachement = $data->MEF_RATTACHEMENT;
                $cont = $cont."<br/>".$code." ".$formation." ".$libelle." ".$edition." ".$rattachement;
                if ($nomenclatureManager->exist($code)){
                    $nomenclatureManager->updateNomenclature($error,$code,$formation,$libelle,$edition,$rattachement);
                } else {
                    $nomenclatureManager->insertNomenclature($error, $code, $formation, $libelle, $edition, $rattachement);
                }
            }
            $nomenclatureManager->commit();;
        }
        $items= array();
        array_push($items,itemView::itemMenu("","#","fa-address-card","Caractéristiques", 'getAdminMainDesk();'));
        array_push($items,itemView::itemMenu("active","#","fa-file-import","Importations", ""));
        $sidebar = itemView::mainSidebar($image,$login,$items);

        ob_start();
        require "view/admin/adminInfoNomenclatureView.php";
        print_r($error);
        $content=ob_get_clean();
        $return_arr = array(
            "status" => 'ok',
            "content" => $content,
            "sidebar" => $sidebar,
            "error" => $error
        );

        return json_encode($return_arr);
    }

    public function postStructureAction(){
        $login = $_SESSION['login'];
        $image = "img/avatar6.jpg";

        $error=array();

        if(isset($_FILES['structureInputFile']['name'])){

           // $filename = $_FILES['structureInputFile']['name'];

            $structureManager = new \DIU\Logixee\Model\StructureManager();
            $xml = simplexml_load_file($_FILES['structureInputFile']['tmp_name']);

            $structureManager->beginTransaction();
            foreach ($xml->DONNEES->DIVISIONS->DIVISION as $data){
                $code = $data["CODE_STRUCTURE"];
                $libelle =  $data->LIBELLE_LONG;

                $structureManager->insertStructure($error,$code,$libelle);
                $structure = new \DIU\Logixee\Model\Structure($code);

                foreach ($data->MEFS_APPARTENANCE->MEF_APPARTENANCE as $mef){
                    $structure->addMef($mef->CODE_MEF);
                }
            }
            $structureManager->commit();
        }
        $items= array();
        array_push($items,itemView::itemMenu("","#","fa-address-card","Caractéristiques", 'getAdminMainDesk();'));
        array_push($items,itemView::itemMenu("active","#","fa-file-import","Importations", ""));
        $sidebar = itemView::mainSidebar($image,$login,$items);

        ob_start();
        require "view/admin/adminInfoStructureView.php";
        //print_r($error);
        $content=ob_get_clean();
        $return_arr = array(
            "status" => 'ok',
            "content" => $content,
            "sidebar" => $sidebar,
            "error" => $error
        );

        return json_encode($return_arr);
    }

    public function postElevesAction(){
        $login = $_SESSION['login'];
        $image = "img/avatar6.jpg";

        $error=array();

        if(isset($_FILES['eleveInputFile']['name'])){

            // $filename = $_FILES['eleveInputFile']['name'];

            $eleveManager = new \DIU\Logixee\Model\EleveManager();
            $xml = simplexml_load_file($_FILES['eleveInputFile']['tmp_name']);

            $eleveManager->beginTransaction();
            foreach ($xml->DONNEES->ELEVES->ELEVE as $data){
                if (!isset($data->DATE_SORTIE)){
                    $id = $data["ELEVE_ID"];
                    $elenoet =$data["ELENOET"];
                    $ine = $data->ID_NATIONAL;
                    $nom = $data->NOM_DE_FAMILLE;
                    $prenom1= $data->PRENOM;
                    $prenom2= $data->PRENOM2;
                    $prenom3= $data->PRENOM3;
                    $naissance = $data->DATE_NAISS;
                    $mel = $data->MEL;
                    $mef = $data->CODE_MEF;


                    $eleveManager->insertEleve($error,$id,$elenoet,$ine,$nom,$prenom1,$prenom2,$prenom3,$naissance,$mel,$mef);
                    //$structure = new \DIU\Logixee\Model\Structure($mef);

                }

            }
            $eleveManager->commit();

            $lnkDivisionEleveManager = new \DIU\Logixee\Model\LinkDivisionEleveManager();

            $lnkDivisionEleveManager->beginTransaction();
            foreach ($xml->DONNEES->STRUCTURES->STRUCTURES_ELEVE as $structure){
                $idEleve = $structure['ELEVE_ID'];
                $elenoet = $structure['ELENOET'];
                $codeStructure = "";
                foreach ($structure->STRUCTURE as $subStructure){
                    if ($subStructure->TYPE_STRUCTURE=="D"){
                        $codeStructure = $subStructure->CODE_STRUCTURE;
                    }
                }

                if ($codeStructure!=""){
                    $lnkDivisionEleveManager->insertLink($codeStructure,$idEleve);
                }
            }
            $lnkDivisionEleveManager->commit();
        }
        $items= array();
        array_push($items,itemView::itemMenu("","#","fa-address-card","Caractéristiques", 'getAdminMainDesk();'));
        array_push($items,itemView::itemMenu("active","#","fa-file-import","Importations", ""));
        $sidebar = itemView::mainSidebar($image,$login,$items);

        ob_start();
        require "view/admin/adminInfoStructureView.php";
        //print_r($error);
        $content=ob_get_clean();
        $return_arr = array(
            "status" => 'ok',
            "content" => $content,
            "sidebar" => $sidebar,
            "error" => $error
        );

        return json_encode($return_arr);
    }
}