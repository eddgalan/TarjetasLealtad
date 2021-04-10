<?php
  require 'models/usuario.php';
  require 'models/cliente.php';
  require 'models/tarjeta.php';

  class Tarjetas {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Tarjetas de Lealtad | Dashboard";
      $data['host'] = $host_name;
      $data['sitio'] = $site_name;

      $tarjeta = new TarjetaPDO();
      $data['tarjetas'] = $tarjeta->get_tarjetas();

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();

      $this->view = new View();
      $this->view->render('views/modules/tarjetas.php', $data, true);
    }
  }

  class ProcessTarjeta {
    function __construct($host_name="", $site_name="", $variables=null){
      if ($_POST){

        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          if (empty($_POST['id_tarjeta'])){
            // INSERT Tarjeta
            $tarjeta = $_POST['num_tarjeta'];
            $cliente = $_POST['nom_cliente'];
            // Crea una instancia de TarjetaPDO con los datos del formulario
            $tarjeta = new TarjetaPDO('0', $tarjeta, $cliente);
            // Hace el INSERT y verifica que se haga con éxito
            if($tarjeta->insert_tarjeta()){
              $data['status'] = "OK";
              $data['msg'] = "Usuario creado con éxito";
            }else{
              $data['status'] = "ERROR";
              $data['msg'] = "Ocurrió un error al crear el usuario";
            }
          }else{
            // UPDATE Tarjeta
            $id_tarjeta = $_POST['id_tarjeta'];
            $tarjeta = $_POST['num_tarjeta_edit'];
            $cliente = $_POST['nom_cliente_edit'];
            // Crea una instancia de TarjetaPDO con los datos del formulario
            $tarjeta = new TarjetaPDO($id_tarjeta, $tarjeta, $cliente);
            // Realiza el UPDATE y verifica que se haga con éxito
            if($tarjeta->update_tarjeta()){
              $data['status'] = "OK";
              $data['msg'] = "Se actualizaron los datos de la tarjeta";
            }else{
              $data['status'] = "ERROR";
              $data['msg'] = "Ocurrió un error al actualizar la tarjeta. Intente de nuevo";
            }
          }
        }

      }else{
        write_log("ProcessUsuario\nNO se recibieron datos por POST");
      }
      // Redirecciona a la página de administrar/usuarios
      header("location: " . $host_name . "/tarjetas");
    }
  }

  class Login {
    function __construct($host_name="", $site_name="", $variables=null){
      if($_POST){
        if(isset($_POST['username']) && isset($_POST['password'])) {
          $usr_name = $_POST['username'];
          $usr_pass = $_POST['password'];

          $usuario = new Usuario();

          if($usuario->validate_user($usr_name, $usr_pass)){
            $session = new UserSession();
            $session->set_session($usuario->get_userdata($usr_name));
            header("location: ./tarjetas");
          }else{
            header("location: ./login");
          }
        }
      }else{
        $data['title'] = "Tarjetas de Lealtad | Login";
        $data['host'] = $host_name;
        $data['sitio'] = $site_name;
        $this->view = new View();
        $this->view->render('views/modules/login.php', $data);
      }
    }
  }

  class Logout{
    function __construct(){
      $session = new UserSession();
      $session->close_sesion();
      header("location: ./login");
    }
  }

  class ErrorURL {
    function __construct(){
      $data['title'] = 'Tarjetas de Lealtad | Error 404';
      $vista = new View();
      $vista->render('views/modules/error.php');
    }
  }

?>
