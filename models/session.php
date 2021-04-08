<?php

  Class UserSession{
      private $id_user;
      private $user;
      private $user_name;
      private $user_lastname;
      private $groups;
      private $status;
      private $token;

      public function __construct(){
        // Inicia la sesión si no está iniciada
        if(session_status() == 1){
          session_start();
        }
      }

      public function set_token(){
        $token = bin2hex(random_bytes(8));
        $this->token = $token;
        $_SESSION['token'] = $token;
        return $this->token;
      }

      public function get_token(){
        if(isset($_SESSION['token'])){
          return $_SESSION['token'];
        }else{
          write_log("ERROR | El token no existe");
        }
      }

      public function validate_token($token_form){
        if(isset($_SESSION['token'])){
          $token = $_SESSION['token'];
          if ($token == $token_form){
            return true;
          }else{
            return false;
          }
        }else{
          write_log("ERROR | Token does not exist");
          return false;
        }
      }

      public function set_sesion_actual($datos_usuario){
        $_SESSION['id_user'] = $datos_usuario['id_user'];
        $_SESSION['user'] = $datos_usuario['user'];
        $_SESSION['user_name'] = $datos_usuario['user_name'];
        $_SESSION['user_lastname'] = $datos_usuario['user_lastname'];
        $_SESSION['status'] = $datos_usuario['status'];
        $_SESSION['groups'] = $datos_usuario['groups'];
      }

      public function get_datos_sesion(){
        $datos_sesion['usr_id'] = $_SESSION['usr_id'];
        $datos_sesion['usr'] = $_SESSION['usr'];
        $datos_sesion['usr_status'] = $_SESSION['usr_status'];
        $datos_sesion['usr_type'] = $_SESSION['usr_type'];
        $datos_sesion['usr_name'] = $_SESSION['usr_name'];
        $datos_sesion['usr_ap_paterno'] = $_SESSION['usr_ap_paterno'];
        $datos_sesion['usr_ap_materno'] = $_SESSION['usr_ap_materno'];
        $datos_sesion['usr_fecha_alta'] = $_SESSION['usr_fecha_alta'];
        return $datos_sesion;
      }

      public function close_sesion(){
        session_unset();  // Limpia
        session_destroy();  // Elimina
      }
  }
?>
