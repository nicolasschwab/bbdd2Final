<?php


require_once "controllers/controller.php";

class UserController extends Controller{

    private $nombre;
    private $apellido;
    private $email;
    private $usuario;
    private $contrasena;

    private $usuarioModel;

    public function singUp(){
        if(!SessionManager::validateSession()) {
            $this->asignarVariable();
            if (ValidationManager::noEmptyString($this->nombre) && ValidationManager::noEmptyString($this->apellido) && ValidationManager::noEmptyString($this->email)
                && ValidationManager::noEmptyString($this->usuario) && ValidationManager::noEmptyString($this->contrasena)
            ) {
                $this->setUsuarioModel();
                $result = $this->usuarioModel->singUp($this->nombre, $this->apellido, $this->email, $this->usuario, $this->contrasena);
                if ($result == null) {
                    $this->redireccionarSingUp(array("mensaje" => "El usuario ya existe"));
                } else {
                    $this->redireccionarLogin(array("mensaje" => "Usuario creado!"));
                }
            } else {
                $this->redireccionarSingUp(array("mensaje" => "Tenes que completar todos los campos"));
            }
        }else{
            $this->redireccionarHome();
        }
    }

    public function encontrarUsuarioByEmail($email){
        if(SessionManager::validateSession()){
            $this->setUsuarioModel();
            return $this->usuarioModel->findByExactEmail($email);
        }else{
            $this->redireccionarLogin();
        }
    }

    public function autocomplete(){
        $this->asignarVariable();
        $this->setUsuarioModel();
        $result = $this->usuarioModel->findByEmail($this->email);
        $normalizeResult = DtoManager::crearArrayDtoDeUsuarios($result);
        foreach ($normalizeResult as $user){
          echo $user->email." ";
        }
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

    private function setUsuarioModel(){
        if(!isset($this->usuarioModel)){
            $this->usuarioModel = ModelManager::getModel("usuario");
        }
    }


}
?>