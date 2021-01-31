<?php

namespace DIU\Logixee\Model;

class Manager
{
    protected $db;

    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    protected function dbConnect(){

        //$bdd = new \PDO('mysql:host=localhost;dbname=expconvoc;charset=utf8', 'test', '2487fa');

        $database=parse_ini_file('config/config.ini');
        $host=$database['host'];
        $dbname=$database['dbname'];
        $username=$database['username'];
        $password=$database['password'];
        $bdd = new \PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8',$username,$password);
        return $bdd;
    }

    public function beginTransaction(){
        $this->db->beginTransaction();
    }

    public function commit(){
        $this->db->commit();
    }

    public function rollBack(){
        $this->db->rollBack();
    }

    public function validateData($datas){
        $error=array();
        foreach ($datas as $key => $val) {
            $name = "isValide" . ucfirst(strtolower($key));
            if (method_exists($this, $name)) {
                $this->$name($val, $error);
            }
        }
        return $error;
    }

    public static function isValideString($value,$len,$strict,$key,$ret,&$error){
        if (($strict and (strlen($value)==$len)) or (strlen($value)<=$len)){
                return true;
            } else {
                $error[$key] = $ret;
                return false;
            }
    }

    public static function isValideDate($value,$key,$ret,&$error){
        if (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $value, $matches)) {
            if (!checkdate($matches[2], $matches[1], $matches[3])) {
                $error[$key] = $ret;
                return false;
            } else {
                return true;
            }
        } else {
            $error[$key] = $ret;
            return false;
        }
    }

    public static function isValideEmail($value,$key,$ret,$nullable,&$error){
        if (($nullable and $value="") or filter_var($value,FILTER_VALIDATE_EMAIL)){
            return true;
        } else {
            $error[$key] = $ret;
            return false;
        }
    }

    protected static function bindValue(&$req,$key,$value){
        if ($value==""){
            $req->bindValue($key,null,\PDO::PARAM_NULL);
        } else {
            $req->bindValue($key,$value,\PDO::PARAM_STR);
        }
    }
}