<?php

include 'startuser.php';

require_once 'controller/Controller.php';
require_once 'modele/OrderManager.php';
require_once 'modele/AdressManager.php';
require_once 'application/itemView.php';

function getError($error,$type){

    if (isset($error) and isset($error[$type])){
        return $error[$type];
    } else {
        return "";
    }
}

class Order extends Controller
{
    private  $manager;

    public function __construct()
    {
        $this->manager = new \DIU\Logixee\Model\OrderManager();
    }

    public function defaultAction()
    {
        return $this->getMainDeskAction();
    }

    public function getMainDeskAction(){

        $login = $_SESSION['login'];
        $order = $this->manager->getOrder($_SESSION['id']);
        $image = "img/company.png";

        $navbarMenu = itemView::navbarRightMenu(4,10,9,$image,$login);
        if (isset($_SESSION['form_error'])){
            $error = $_SESSION['form_error'];
            unset($_SESSION['form_error']);
        } else {
            $error = array();
        }
        $siren = itemView::formGroup('inputSiren','siren',$order['siren'],'Siren',getError($error,'siren'));
        $contact = itemView::formGroup('inputContact','contact',$order['Contact'],'Contact',getError($error,'contact'));
        $email = itemView::formGroup('inputMail','mail',$order['email'],'Couriel',getError($error,'email'));

        $items= array();
        array_push($items,itemView::itemMenu("active","#","fa-address-card","Caractéristiques","getMainOrder();"));
        array_push($items,itemView::itemMenu("","#","fa-industry","Agences","getAgencyDesk();"));
        array_push($items,itemView::itemLevelMenu("","#","fa-link","Autres"));
        $sidebar = itemView::mainSidebar($image,$login,$items);

        ob_start();
        require "view/order/orderMainDeskView.php";
        $content=ob_get_clean();
        ob_start();
        require "view/template.php";
        return ob_get_clean();
    }

    public function getAgencyDeskAction($request){
        $login = $_SESSION['login'];
        $image = "img/company.png";

        $items= array();
        array_push($items,itemView::itemMenu("","#","fa-address-card","Caractéristiques","getMainOrder();"));
        array_push($items,itemView::itemMenu("active","#","fa-industry","Agences","getAgencyDesk();"));
        array_push($items,itemView::itemLevelMenu("","#","fa-link","Autres"));
        $sidebar = itemView::mainSidebar($image,$login,$items);

        ob_start();
        require "view/order/orderAgencyDeskView.php";
        $content=ob_get_clean();

        $return_arr = array(
            "status" => 'ok',
            "content" => $content,
            "sidebar" => $sidebar
        );

        return json_encode($return_arr);
    }

    function getDeskAction($request){
        $login = $_SESSION['login'];
        $order = $this->manager->getOrder($_SESSION['id']);
        $image = "img/company.png";

        //$navbarMenu = itemView::navbarRightMenu(4,10,9,$image,$login);


        $items= array();
        array_push($items,itemView::itemMenu("active","#","fa-address-card","Caractéristiques","getMainOrder();"));
        array_push($items,itemView::itemMenu("","#","fa-industry","Agences","getAgencyDesk();"));
        array_push($items,itemView::itemLevelMenu("","#","fa-link","Autres"));
        $sidebar = itemView::mainSidebar($image,$login,$items);

        ob_start();
        require "view/order/orderMainDeskView.php";
        $content=ob_get_clean();
        $return_arr = array(
            "status" => 'ok',
            "content" => $content,
            "sidebar" => $sidebar
        );

        return json_encode($return_arr);
    }

    public function postInfoAction($request){

        $error=array();

        $this->manager->updateOrder($_SESSION['id'],$request->request['contact'],$request->request['mail'],$request->request['siren'],$error);

        if ($error){

            $_SESSION['form_error']=$error;

            $order = $this->manager->getOrder($_SESSION['id']);

            $siren = itemView::formGroup('inputSiren','siren',$order['siren'],'Siren',getError($error,'siren'));
            $contact = itemView::formGroup('inputContact','contact',$order['Contact'],'Contact',getError($error,'contact'));
            $email = itemView::formGroup('inputMail','mail',$order['email'],'Couriel',getError($error,'email'));

            ob_start();
            include "view/order/orderFormInfoView.php";
            $content=ob_get_clean();
            $return_arr = array(
                "status" => 'not',
                "content" => $content
            );

        } else {
            $return_arr = array(
                "status" => 'ok',
                "content" => ''
            );
        }

        /*
        $return_arr = array(
            "status" => 'ok',
            "content" => ''
        );*/

        //header('Location : index.php');
        return json_encode($return_arr);


    }
    private function updateHandle($error,$title,$modif,$func,$view){
        if ($error){

            $header = itemView::headerBox($title);
            $adress1="";
            $adress2="";
            $code="";
            $ville="";
            $this->$func($adress1,$adress2,$code,$ville,$error,$modif);

            ob_start();
            include $view;
            $content = ob_get_clean();

            $return_arr = array(
                "status" => 'not',
                "content" => $content
            );

        } else {
            $return_arr = array(
                "status" => 'ok',
                "content" => ''
            );
        }
        return json_encode($return_arr);
    }

    private function validateAdress($request, $id,$action){
        $error=array();
        $order = $this->manager->getOrder($_SESSION['id']);
        $adressManager = new \DIU\Logixee\Model\AdressManager();
        $adressManager->$action($order[$id],
            $request->request['adresse1'],
            $request->request['adresse2'],
            $request->request['code'],
            $request->request['ville'],
            $error);
        return $error;
    }

    public function postUpdateBillAdressAction($request){
        $error=$this->validateAdress($request,"factID","updateAdress");

        return $this->updateHandle($error,
            "Modification de l'adresse",
            "Modif",
            getFactAdresse,
            "view/order/orderFormUpdateAdressView.php");
    }

    public function postChangeLocalAdressAction($request){
        $error=$this->validateAdress($request,"localID","insertAdress");

        //TODO modification de l'adresse locale

        return $this->updateHandle($error,
        "Nouvelle adresse",
        "New",
        getLocalAdresse,
        "view/order/orderFormNewAdressView.php");
    }

    public function postChangeBillAdressAction($request){
        $error=$this->validateAdress($request,"factID","insertAdress");

        //TODO modification de l'adresse de facturation

        return $this->updateHandle($error,
            "Nouvelle adresse de facturation",
            "New",
            getFactAdresse,
            "view/order/orderFormUpdateAdressBillView.php");
    }

    public function postUpdateLocalAdressAction($request){

        //TODO gérer les adresses identiques pour plusieurs entreprises

        $error=array();
        $order = $this->manager->getOrder($_SESSION['id']);
        $adressManager = new \DIU\Logixee\Model\AdressManager();
        $adressManager->updateAdress($order['localID'],
            $request->request['adresse1'],
            $request->request['adresse2'],
            $request->request['code'],
            $request->request['ville'],
        $error);

        if ($error){

            $header = itemView::headerBox("Modification de l'adresse");
            $this->getLocalAdresse($adress1,$adress2,$code,$ville,$error,"Modif");

            ob_start();
            include "view/order/orderFormUpdateAdressView.php";
            $content = ob_get_clean();

            $return_arr = array(
                "status" => 'not',
                "content" => $content
            );

        } else {
            $return_arr = array(
                "status" => 'ok',
                "content" => ''
            );
        }
        return json_encode($return_arr);
    }

    public function getInfoAction($request){
        $order = $this->manager->getOrder($_SESSION['id']);
        $siren = itemView::formGroup('inputSiren','siren',$order['siren'],'Siren',"");
        $contact = itemView::formGroup('inputContact','contact',$order['Contact'],'Contact',"");
        $email = itemView::formGroup('inputMail','mail',$order['email'],'Couriel',"");

        ob_start();
        include "view/order/orderFormInfoView.php";
        return ob_get_clean();
    }

    public function getAdressAction($request){

        $header = itemView::headerBox("Modification de l'adresse");
        $this->getLocalAdresse($adress1,$adress2,$code,$ville,NULL,"Modif");

        ob_start();
        include "view/order/orderFormUpdateAdressView.php";
        return ob_get_clean();
    }

    private function getLocalAdresse(&$adress1,&$adress2,&$code,&$ville,$error,$modif =""){
        $order = $this->manager->getOrder($_SESSION['id']);
        $adress1 = itemView::formGroup('input'.$modif.'Adresse1','adresse1',$order['localAdr1'],'Adresse 1',getError($error,'adresse1'));
        $adress2 = itemView::formGroup('input'.$modif.'Adresse2','adresse2',$order['localAdr2'],'Adresse 2',getError($error,'adresse2'));
        $code = itemView::formGroup('input'.$modif.'Code','code',$order['localCode'],'Code Postal',getError($error,'code'));
        $ville = itemView::formGroup('input'.$modif.'Ville','ville',$order['localVille'],'Ville',getError($error,'ville'));
    }

    private function getFactAdresse(&$adress1,&$adress2,&$code,&$ville,$error,$modif=""){
        $order = $this->manager->getOrder($_SESSION['id']);
        $adress1 = itemView::formGroup('input'.$modif.'FactAdresse1','adresse1',$order['factAdr1'],'Adresse 1',"");
        $adress2 = itemView::formGroup('input'.$modif.'FactAdresse2','adresse2',$order['factAdr2'],'Adresse 2',"");
        $code = itemView::formGroup('input'.$modif.'FactCode','code',$order['factCode'],'Code Postal',"");
        $ville = itemView::formGroup('input'.$modif.'FactVille','ville',$order['factVille'],'Ville',"");
    }

    public function getAdressBillAction($request){
        $header = itemView::headerBox("Modification de l'adresse de facturation");
        $this->getFactAdresse($adress1,$adress2,$code,$ville,"Modif");

        ob_start();
        include "view/order/orderFormUpdateAdressBillView.php";
        return ob_get_clean();
    }

    public function getNewAdressAction($request){
        $header = itemView::headerBox("Nouvelle adresse");
        $this->getLocalAdresse($adress1,$adress2,$code,$ville,NUll,"New");

        ob_start();
        include "view/order/orderFormNewAdressView.php";
        return ob_get_clean();
    }

    public function getNewAdressBillAction($request){
        $header = itemView::headerBox("Nouvelle adresse de facturation");
        $this->getFactAdresse($adress1,$adress2,$code,$ville,Null,"New");

        ob_start();
        include "view/order/orderFormUpdateAdressBillView.php";
        return ob_get_clean();
    }

    public function getTestAction(){
        $return_arr = array(
            "status" => 'ok',
            "content" => $this->getInfoAction(null)
        );

        return json_encode($return_arr);
    }
}