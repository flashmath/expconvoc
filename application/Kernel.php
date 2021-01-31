<?php



class Kernel
{
    function __construct()
    {
    }

    public function handle($request){
        try {
            $controller = new $request->controllerName();
        } catch (Exception $e){
            header('Location: index.php');
        }
        $action = $request->action;
        if (method_exists($controller,$action)) {
            return $controller->$action($request);
        } else {
            header('Location: index.php?'.$controller);
        }
    }
}