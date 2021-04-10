<?php
require_once 'libs/conexion_db.php';

Class TarjetaPDO extends Connection_PDO{
  private $id;
  private $num_tarjeta;
  private $propietario;
  private $saldo;


  function __construct($id="", $tarjeta="", $prop="", $saldo="0.00") {
    parent::__construct();
    $this->id = $id;
    $this->num_tarjeta = $tarjeta;
    $this->propietario = $prop;
    $this->saldo = $saldo;
  }

  public function get_tarjetas(){
    $this->connect();
    $stmt = $this->conn->prepare("SELECT * FROM tarjeta");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $this->disconect();
    write_log(serialize($result));
    return $result;
  }

  public function get_tarjeta($id_tarjeta){
    $this->connect();

    $sql = "SELECT *
    FROM tarjeta
    WHERE id = '$id_tarjeta'";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $this->disconect();
    write_log(serialize($result));
    return $result;

  }

  public function insert_tarjeta(){
    $this->connect();
    try{
      $sql = "INSERT INTO `tarjeta` (`Id`, `Tarjeta`, `Propietario`, `Saldo`)
      VALUES (NULL, '$this->num_tarjeta','$this->propietario','0')";
      $this->conn->exec($sql);
      write_log("Se realizó el INSERT de la Tarjeta con Éxito");
      $this->disconect();   // Cierra la conexión a la BD
      return true;
    }catch(PDOException $e) {
      write_log("Ocurrió un error al realizar el INSERT de la Tarjeta\nError: ". $e->getMessage());
      $this->disconect();   // Cierra la conexión a la BD
      return false;
    }
  }

  public function update_tarjeta(){
    $this->connect();
    try{
      $sql = "UPDATE tarjeta SET Propietario='$this->propietario'
      WHERE id = $this->id";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();

      write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
      $this->disconect();
      return true;
    }catch(PDOException $e) {
      write_log("Ocurrió un error al realizar el UPDATE de la Tarjeta\nError: ". $e->getMessage());
      write_log("SQL: ". $sql);
      $this->disconect();
      return false;
    }
  }

  public function get_saldo(){
    $datos_tarjeta = $this->get_tarjeta($this->id);
    $saldo = $datos_tarjeta[0]['Saldo'];
    write_log("Id Tarjeta: " . $this->id . "\nSaldo Tarjeta: $ " . $saldo);
    return $saldo;
  }

  public function recharge_tarjeta($nuevo_saldo){
    $this->saldo = $nuevo_saldo;
    $this->connect();
    try{
      $sql = "UPDATE tarjeta SET Saldo='$this->saldo'
      WHERE id = $this->id";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();

      write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
      $this->disconect();
      return true;
    }catch(PDOException $e) {
      write_log("Ocurrió un error al realizar la Recarga (UPDATE) de la Tarjeta\nError: ". $e->getMessage());
      write_log("SQL: ". $sql);
      $this->disconect();
      return false;
    }
  }


}

?>
