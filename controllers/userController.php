<?php


require_once "controllers/controller.php";

class UserController extends Controller{

    private $nombre;
    private $apellido;
    private $email;
    private $usuario;
    private $contrasena;
    private $usuarioService;

    private $usuarioModel;

    function __construct(){
        $this->usuarioService = ServiceFactory::getUsuarioService();
    }

    public function singUp(){
        SessionManager::validateNoSession();
        $this->asignarVariable();
        $this->usuarioService->singUp($this->nombre, $this->apellido, $this->email, $this->usuario, $this->contrasena);
        ViewManager::redireccionarSingUp();
    }

    public function autocomplete(){
        SessionManager::validateSession();
        $this->asignarVariable();
        $result = $this->usuarioService->findByEmail($this->email);
        $normalizeResult = DtoManager::crearArrayDtoDeUsuarios($result);
        foreach ($normalizeResult as $user){
          echo $user->email." ";
        }
    }

    public function misConsultas(){
        SessionManager::validateSession();
        $consultas = $this->usuarioService->getMisConsultas(SessionManager::getName());
        ViewManager::setObjeto($consultas);
    }

    private function asignarVariable(){
        if(isset( $_POST["nombre"])){
            $this->nombre = $_POST["nombre"];
        }
        if(isset( $_POST["apellido"])){
            $this->apellido = $_POST["apellido"];
        }
        if(isset( $_POST["email"])){
            $this->email = $_POST["email"];
        }
        if(isset( $_POST["usuario"])){
            $this->usuario = $_POST["usuario"];
        }
        if(isset( $_POST["contrasena"])){
            $this->contrasena = $_POST["contrasena"];
        }
    }

}
?>