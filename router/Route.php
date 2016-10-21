<?php

class Route{

    private  $name;
    private  $nameFileController;
    private  $nameClassController;
    private  $method;
    private  $pathToControllers = "controllers";

    /**
     * Route constructor.
     * @param $name
     * @param $nameFileController
     * @param $nameClassController
     * @param $method
     */
    public function __construct($name, $nameFileController, $nameClassController, $method)
    {
        $this->name = $name;
        $this->nameFileController = $nameFileController;
        $this->nameClassController = $nameClassController;
        $this->method = $method;
    }


    public function redirect(){
        $fullPathToController= $this->pathToControllers."/".$this->nameFileController.".php";
        require_once $fullPathToController;
        $controller= new $this->nameClassController();
        $method=$this->method;
        $controller->$method();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNameFileController()
    {
        return $this->nameFileController;
    }

    /**
     * @param mixed $nameFileController
     */
    public function setNameFileController($nameFileController)
    {
        $this->nameFileController = $nameFileController;
    }

    /**
     * @return mixed
     */
    public function getNameClassController()
    {
        return $this->nameClassController;
    }

    /**
     * @param mixed $nameClassController
     */
    public function setNameClassController($nameClassController)
    {
        $this->nameClassController = $nameClassController;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }






}
?>
