<?php

class BeanFactory{

    private static $dirControllers = "beans";

    public static function getBean($beanName){
        require_once self::$dirControllers."/".strtolower($beanName)."Bean.php";
        $fullBeanName = $beanName."Bean";
        return new $fullBeanName();
    }
}

?>
