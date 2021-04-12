<?php
  require 'models/usuario.php';
  require 'models/tarjeta.php';
  require 'models/operaciones.php';

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
            $sesion = new UserSession();
            // Hace el INSERT y verifica que se haga con éxito
            if($tarjeta->insert_tarjeta()){
              $sesion->set_notification("OK", "Se agregó la nueva tarjeta.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar la tarjeta. Inténtelo de nuevo.");
            }
          }else{
            // UPDATE Tarjeta
            $id_tarjeta = $_POST['id_tarjeta'];
            $tarjeta = $_POST['num_tarjeta_edit'];
            $cliente = $_POST['nom_cliente_edit'];
            // Crea una instancia de TarjetaPDO con los datos del formulario
            $tarjeta = new TarjetaPDO($id_tarjeta, $tarjeta, $cliente);
            $sesion = new UserSession();
            // Realiza el UPDATE y verifica que se haga con éxito
            if($tarjeta->update_tarjeta()){
              $sesion->set_notification("OK", "Se actualizó el propietario de la tarjeta");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar la tarjeta. Intente de nuevo");
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

  class ProcessRecarga{
    function __construct($host_name="", $site_name="", $variables=null){
      if ($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id_tarjeta = $_POST['id_tarjeta'];
          $monto_recarga = $_POST['monto_recarga'];
          // Obtiene el saldo actual de la tarjeta
          $tarjeta = new TarjetaPDO($id_tarjeta);
          $saldo = floatval($tarjeta->get_saldo());
          // Calcula el nuevo saldo
          $nuevo_saldo = round($saldo + floatval($monto_recarga), 2);
          write_log("Nuevo Saldo: $ " . $nuevo_saldo);
          // Actualiza el saldo
          if($tarjeta->actualizar_saldo($nuevo_saldo)){
            $datos_tar = $tarjeta->get_tarjeta();
            $num_tarjeta = $datos_tar[0]['Tarjeta'];
            // Crea una Transacción de la ingreso en la tarjeta
            $operacion = new OperacionPDO(NULL, $num_tarjeta, $monto_recarga, "Recarga Saldo");
            $sesion = new UserSession();
            if($operacion->insert_operacion()){
              $sesion->set_notification("OK", "Se realizó la recarga de la tarjeta. ");
            }else{
              write_log("ProcessRecarga | Error al realizar operación de recarga (Error al hacer INSERT de Operación)");
              $sesion->set_notification("ERROR", "Ocurrió un error al realizar la recarga. ");
              // Retiramos el Saldo ingresado
              if($tarjeta->actualizar_saldo($saldo)){
                write_log("ProcessRecarga | Se quitó el saldo insertado");
              }else{
                write_log("ProcessRecarga | Se realizó la recarga, pero no se generó Operación");
              }
            }
          }else{
            $sesion->set_notification("ERROR", "Error al realizar la recarga. Intentelo de nuevo");
            write_log("Ocurrió un error al recargar la tarjeta");
          }
        }else{
          write_log("ProcessRecarga\nNO se recibieron datos por POST");
        }
      }
      header("location: ". $host_name . "/tarjetas");
    }
  }

  class ProcessTransaccion{
    function __construct($host_name="", $site_name="", $variables=null){
      if ($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $num_tarjeta = $_POST['num_tarjeta_operacion'];
          $monto_transaccion = floatval($_POST['monto_operacion']);
          // Verifica si se ingresó un concepto en el formulario
          $concepto = "Cargo a tarjeta";
          if(!empty($_POST['concepto'])){
            $concepto = $_POST['concepto'];
          }

          $tarjeta = new TarjetaPDO("", $num_tarjeta);
          $datos_tarjeta = $tarjeta->get_tarjeta_by_num();
          // Obtiene el saldo actual de la tarjeta
          $saldo = floatval($datos_tarjeta[0]['Saldo']);
          // Verifica si el cliente tiene el saldo para realizar la operación
          if($saldo >= $monto_transaccion){
            // Registra la operación o movimiento
            $operacion = new OperacionPDO(NULL, $num_tarjeta, $monto_transaccion, $concepto);
            if( $operacion->insert_operacion() ){
              // Actualizar saldo de la tarjeta
              $nuevo_saldo = round($saldo - $monto_transaccion, 2);
              $tarj = new TarjetaPDO($datos_tarjeta[0]['Id']);
              $sesion = new UserSession();
              if($tarj->actualizar_saldo($nuevo_saldo)){
                $sesion->set_notification("OK", "La transacción se realizó correctamente.");
              }else{
                $sesion->set_notification("ERROR", "Ocurrió un error al realizar la transacción. Inténtelo de nuevo.");
              }
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al realizar la transacción.");
            }
          }else{
            $sesion->set_notification("ERROR", "No fue posible realizar la operación. Saldo insuficiente. ");
          }
        }else{
          write_log("ProcessRecarga\nNO se recibieron datos por POST");
        }
      }
      header("location: ". $host_name . "/tarjetas");
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
