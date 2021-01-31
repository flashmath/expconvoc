<?php


namespace DIU\Logixee\Model;

require_once 'modele/LnkDivisionMefManager.php';

class Structure
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function addMef($code){
        $lnk = new LnkDivisionMefManager();
        $lnk->insertLink($this->id,$code);
    }
}