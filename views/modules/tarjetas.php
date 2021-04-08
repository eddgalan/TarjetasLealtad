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
                        <h3 class="text-dark mb-0"><i class="fas fa-credit-card"></i> Tarjetas </h3>
                        <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#">
                          <i class="fas fa-plus-circle fa-sm text-white-50"></i>
                          &nbsp;Nueva Tarjeta
                        </a>
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
                    							<tr>
                    								<td class="text-center">1</td>
                    								<td> Edson Galan Rosano </td>
                    								<td class="text-center"> $ 0.00 </td>
                    								<td>
                    									<div class="btn-group" role="group" aria-label="Button group with nested dropdown" style="width:100%;">
                    										<button id="btnGroupDrop1" type="button" class="btn btn-info btn_options text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    											<i class="fas fa-ellipsis-h icon_btn_options"></i>
                    										</button>
                    										<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    											<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_editar_tarjeta" onclick="carga_datos_tarjeta(1)"> <i class="fas fa-edit"></i> Editar tarjeta </a>
                    											<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_cargar_tarjeta" onclick="carga_datos_tarjeta(1)"> <i class="fas fa-dollar-sign"></i> Recargar tarjeta </a>
                    										</div>
                    									</div>
                    								</td>
                    							</tr>
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
    <?php include "./views/modules/components/scripts.php"; ?>
</body>

</html>
