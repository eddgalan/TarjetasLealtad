<!DOCTYPE html>
<html>
<head>
    <?php include './views/modules/components/head.php'; ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include './views/modules/components/navbar.php'; ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <!-- ..:: Custom Content ::.. -->
                <div class="container-fluid" style="margin-top: 15px;">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4" >
                      <div class="col-md-12 row" style="padding: 0px; margin: 0px; margin-bottom:10px;">
                        <div class="col-md-6 col-sm-6">
                          <h3 class="text-dark mb-0 color_black"> <i class="fas fa-credit-card"></i> Tarjetas </h3>
                        </div>
                        <div class="col-md-6 col-sm-6 text-right">
                          <button type="button" class="btn btn-success waves-effect text-capitalize" data-toggle="modal" data-target="#modal_nueva_tarjeta">
                            <i class="fas fa-plus-circle fa-sm"></i> Nueva Tarjeta
                          </button>
                          <button type="button" class="btn btn-primary waves-effect text-capitalize" data-toggle="modal" data-target="#modal_consulta_saldo">
                            <i class="fas fa-search-dollar"></i> Consulta de saldo
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="card col-md-12">
                        <div class="card-body">
                            <div class="table-responsive">
                              <table class="table table-bordered table-dark table-hover">
                                <thead>
                                  <tr>
                                    <th class="text-center"># Tarjeta</th>
                                    <th class="text-center">Propietario</th>
                                    <th class="text-center">Saldo $</th>
                                    <th class="text-center">Opciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    foreach ($data['tarjetas'] as $tarjeta) {
                                      $html_row = ""."\n\t\t\t\t\t\t\t\t\t<tr>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t<td class='text-center'>". $tarjeta['Tarjeta'] ."</td>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t<td>". $tarjeta['Propietario'] ."</td>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t<td class='text-center'> $ ". $tarjeta['Saldo'] ."</td>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t<td>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t\t<div class='btn-group' role='group' aria-label='Button group with nested dropdown' style='width:100%;'>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t\t\t<button id='btnGroupDrop1' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-ellipsis-h icon_btn_options'></i>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t\t\t</button>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t\t\t<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_editar_tarjeta' onclick='carga_datos_tarjeta(". $tarjeta['Id'] .")'> <i class='fas fa-edit color_blue'></i> Editar tarjeta </a>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_recargar_tarjeta' onclick='carga_datos_tarjeta(". $tarjeta['Id'] .")'> <i class='fas fa-dollar-sign color_green'></i> Recargar tarjeta </a>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t\t\t</div>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t\t</div>\n".
                                                    "\t\t\t\t\t\t\t\t\t\t</td>\n".
                                                    "\t\t\t\t\t\t\t\t\t</tr>\n";
                                      echo $html_row;
                                    }
                                  ?>
                                </tbody>
                              </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <?php include './views/modules/components/footer.php'; ?>
        </div>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>

    <!-- ..:: Modal Nueva Tarjeta ::.. -->
    <div class="modal fade" id="modal_nueva_tarjeta">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title color_black"> <i class="fas fa-plus"></i> Alta de Tarjeta </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/tarjetas/procesar">
            <div class="modal-body">
                <div class="col-md-12 row">
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="nombre_usuario">Número de tarjeta: </label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="num_tarjeta" placeholder="0000-0000-0000-0000" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="apellidos">Propietario: </label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="nom_cliente" placeholder="Nombre y apellidos" required>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Agregar tarjeta </button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ..:: Modal Editar Tarjeta ::.. -->
    <div class="modal fade" id="modal_editar_tarjeta">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title color_black"> <i class="fas fa-edit"></i> Editar tarjeta </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/tarjetas/procesar">
            <div class="modal-body">
                <div class="col-md-12 row">
                  <div style="display:none;">
                    <!-- ..:: Token ::.. -->
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                    <!-- ..:: IdTarjeta ::.. -->
                    <input type="hidden" name="id_tarjeta">
                  </div>
                  <div class="col-md-6">
                    <label for="nombre_usuario">Número de tarjeta: </label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="num_tarjeta_edit" placeholder="0000-0000-0000-0000" disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="apellidos">Propietario: </label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="nom_cliente_edit" placeholder="Nombre y apellidos" required>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Guardar cambios </button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ..:: Modal Consulta Saldo ::.. -->
    <div class="modal fade" id="modal_consulta_saldo">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title color_black"> <i class="fas fa-search-dollar"></i> Consulta de saldo </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/usuarios/procesar">
            <div class="modal-body">
                <div class="col-md-12 row">
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                  </div>
                  <div class="col-md-12">
                    <label for="nombre_usuario">Número de tarjeta: </label>
                    <div class="col-md-12">
                      <input type="text" class="form-control text-center" name="num_tarjeta_consulta" placeholder="0000-0000-0000-0000" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="apellidos">Propietario: </label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="saldo_consulta" placeholder="Nombre cliente" disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="apellidos">Saldo $: </label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="saldo_consulta" placeholder="$ 0.00 " disabled>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success"> <i class="fas fa-check"></i> Consultar </button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cerrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ..:: Modal Recargar Tarjeta ::.. -->
    <div class="modal fade" id="modal_recargar_tarjeta">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title color_black"> <i class="fas fa-dollar-sign"></i> Recargar Tarjeta </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/usuarios/procesar">
            <div class="modal-body">
                <div class="col-md-12 row">
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="nombre_usuario">Número de tarjeta: </label>
                    <div class="col-md-12">
                      <input type="text" class="form-control text-center" name="num_tarjeta_recarga" placeholder="0000-0000-0000-0000" disabled required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="apellidos">Propietario: </label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="propietario_recarga" placeholder="Nombre cliente" disabled required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="apellidos">Saldo $: </label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="saldo_recarga" placeholder="$ 0.00 " disabled required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="apellidos">Monto a recargar $: </label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="monto_recarga" placeholder="$ 0.00 " required>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success"> <i class="fas fa-dollar-sign"></i> Recargar </button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php include "./views/modules/components/scripts.php"; ?>
    <script type="text/javascript" src="<?= $data['host']?>/views/modules/assets/js/tarjetas.js"></script>
</body>

</html>
