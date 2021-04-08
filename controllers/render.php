<?php
  require 'models/usuario.php';
  require 'models/cliente.php';

  class Dashboard {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Tarjetas de Lealtad | Dashboard";
      $data['host'] = $host_name;
      $data['sitio'] = $site_name;
      $this->view = new View();
      $this->view->render('views/modules/dashboard.php', $data);
    }
  }

  class Tarjetas {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Tarjetas de Lealtad | Dashboard";
      $data['host'] = $host_name;
      $data['sitio'] = $site_name;
      $this->view = new View();
      $this->view->render('views/modules/tarjetas.php', $data);
    }
  }

  class Login {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Tarjetas de Lealtad | Login";
      $data['host'] = $host_name;
      $data['sitio'] = $site_name;
      $this->view = new View();
      $this->view->render('views/modules/login.php', $data);
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
