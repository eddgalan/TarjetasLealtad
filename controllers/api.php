<?php

  class API{
    private $datos;
    private $response;

    public function return_data($msg, $code, $data=null){
      $this->response['code'] = $code;
      $this->response['msg'] = $msg;
      $this->response['data'] = $data;
      print_r(json_encode($this->response));
    }
  }

  class TarjetaAPI extends API{
    public function get_tarjeta($datos){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id = $datos[1];
          $tarjeta = new TarjetaPDO($id);
          $tarjetas = $tarjeta->get_tarjeta();
          $this -> return_data("Mostrando Tarjeta API", 200, $tarjetas);
        }else{
          write_log("Token NO válido | TarjetaAPI");
          $this->return_data("Ocurrió un error... No es posible procesar su solicitud", 400);
        }
      }else{
        write_log("TarjetaAPI | get_tarjeta\nNO se recibieron datos por POST");
        $this->return_data("No es posible procesar su solicitud", 400);
      }
    }

    public function get_tarjeta_by_num($datos){
      if($_POST){
        $token = $_POST['token'];
        $session = new UserSession();

        if($session->validate_token($token)){
          $num_tarjeta = $datos[1];
          $tarjeta = new TarjetaPDO("", $num_tarjeta);
          $datos_tarjeta = $tarjeta->get_tarjeta_by_num();
          $this->return_data("Mostrando Datos Tarjeta API", 200, $datos_tarjeta);
        }else{
          write_log("Token NO válido | TarjetaAPI");
          $this->return_data("Ocurrió un error... NO es posible procesar su solicitud",400);
        }
      }else{
        write_log("TarjetaAPI | get_tarjeta_by_num\nNO se recibieron datos por POST");
        $this->return_data("NO es posible procesar su solicitud", 400);
      }
    }
  }

?>
