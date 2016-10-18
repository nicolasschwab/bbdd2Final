<?php

include 'router/Router.php';
include 'managers/viewManager.php';
include 'managers/exceptionManager.php';

set_exception_handler('exceptionManager');

$router= new Router();
$router->addRoute("/","loginController", "LoginController" ,"home");
$router->addRoute("/singup","loginController", "LoginController" ,"cargarSingUp");
$router->addRoute("/login","loginController", "LoginController" ,"login");
$router->addRoute("/logout","loginController", "LoginController" ,"logout");
$router->addRoute("/user/singup","userController", "UserController" ,"singUp");
$router->addRoute("/user/get","userController", "UserController" ,"autocomplete");
$router->addRoute("/consulta/crear","consultaController", "ConsultaController" ,"crear");
$router->addRoute("/consulta/mostrar","consultaController", "ConsultaController" ,"mostrar");
$router->addRoute("/consulta/editar","consultaController", "ConsultaController" ,"editar");
$router->addRoute("/consulta/eliminar","consultaController", "ConsultaController" ,"eliminar");
$router->addRoute("/consulta/compartidas","consultaController", "ConsultaController" ,"compartidas");
$router->addRoute("/permiso/agregar","permisoController", "PermisoController" ,"agregar");
$router->addRoute("/permiso/quitar","permisoController", "PermisoController" ,"quitar");

$router->redirect($_SERVER['REQUEST_URI']);


?>