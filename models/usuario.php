<?php
  require_once 'libs/conexion_db.php';

  Class Usuario extends Connection_PDO{
    private $id_usuario;
    private $nombre;
    private $apellidos;
    private $user_name;
    private $user_pass;

    function __construct() {
      parent::__construct();
    }

    public function get_users(){
      write_log("Función get_users()");
    }
  }

?>
