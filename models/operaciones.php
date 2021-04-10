<?php
require_once 'libs/conexion_db.php';

Class OperacionPDO extends Connection_PDO{
  private $id;
  private $tarjeta;
  private $monto;
  private $contepto;
  private $fecha;

  function __construct($id="", $tarjeta="", $monto=0, $concepto="", $fecha="") {
    parent::__construct();
    $this->id = $id;
    $this->tarjeta = $tarjeta;
    $this->monto = $monto;
    $this->concepto = $concepto;
    $this->fecha = $fecha;
  }

  public function get_operaciones(){
    $this->connect();

    $sql = "SELECT *
    FROM operaciones
    WHERE tarjeta = '$this->tarjeta'";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $this->disconect();
    write_log(serialize($result));
    return $result;
  }

  public function insert_operacion(){
    $this->connect();
    try{
      $sql = "INSERT INTO `operaciones` (`Id`, `Tarjeta`, `Monto`, `Concepto`, `Fecha`)
      VALUES (NULL, '$this->tarjeta', '$this->monto', '$this->concepto', current_timestamp())";
      /*
      INSERT INTO `operaciones` (`Id`, `Tarjeta`, `Monto`, `Concepto`, `Fecha`)
      VALUES (NULL, '1234567887654321', '45', 'Prueba', current_timestamp());
      */
      $this->conn->exec($sql);
      write_log("Se realizó el INSERT de la Operación con Éxito");
      $this->disconect();   // Cierra la conexión a la BD
      return true;
    }catch(PDOException $e) {
      write_log("Ocurrió un error al realizar el INSERT de la Operación\nError: ". $e->getMessage());
      write_log("SQL: ". $sql);
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
