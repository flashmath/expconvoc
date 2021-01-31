<?php


class itemView
{
    public static function formGroup($id,$name,$value,$label,$error){
        ob_start();
        include "view/fragment/formgroup.php";
        return ob_get_clean();
    }

    public static function headerBox($titlebox){
        ob_start();
        include "view/fragment/headerbox.php";
        return ob_get_clean();
    }

    public static function navbarRightMenu($nbMessage,$nbNotification,$nbTasks,$image,$login){
        ob_start();
        include "view/fragment/navbarRightMenu.php";
        return ob_get_clean();
    }

    public static function mainSidebar($image,$login,$items){
        ob_start();
        include "view/fragment/mainSidebar.php";
        return ob_get_clean();
    }

    public static function itemMenu($state,$link,$image,$texte,$click=""){
        ob_start();
        include "view/fragment/itemMenu.php";
        return ob_get_clean();
    }

    public static function itemLevelMenu($state,$link,$image,$texte){
        ob_start();
        include "view/fragment/itemLevelMenu.php";
        return ob_get_clean();
    }

    public static function rowTable($datas){
        ob_start();
        include "view/fragment/itemTable.php";
        return ob_get_clean();
    }
}