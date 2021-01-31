<?php

require_once 'controller/Controller.php';
require_once 'modele/UserManager.php';

class Log extends Controller
{

    public function defaultAction()
    {
        if (!isset($_SESSION["id"])){
            return $this->showLogAction();
        } else {
            header('Location: index.php');
        }
    }

    public function showLogAction(){
        ob_start();
        require_once "view/log/loginView.php";
        return ob_get_clean();
    }

    public function validateLogAction($request){
        $userManager = new \DIU\Logixee\Model\UserManager();
        $login = $request->request['username'];

        $user = $userManager->getUser($login);

        if (!$user)
        {
            $_SESSION['login_error']=1;
            header('Location: index.php');
        } else{
            $isPasswordCorrect = password_verify($request->request['password'],$user['password']);
            if ($isPasswordCorrect){
                unset($_SESSION['login_error']);
                session_start();
                $_SESSION['id']=$user['idUser'];
                $_SESSION['login']=$login;
                $_SESSION['role']=$user['role'];

            }
        }

        $request->setRole($user['role']);

        header('Location: index.php');
    }

    public function disconnectAction(){
        // Suppression des variables de session et de la session
        $_SESSION = array();
        session_destroy();

        // Suppression des cookies de connexion automatique
        setcookie('login', '');
        setcookie('pass_hache', '');

        header('Location: index.php?log');
    }
}