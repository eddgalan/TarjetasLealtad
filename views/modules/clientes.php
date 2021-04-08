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
                <?php include './views/modules/components/nav.php'; ?>
                <!-- ..:: Custom Content ::.. -->
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Clientes</h3>
                    <div class="col-md-12">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Telefono</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            foreach ($data['clientes'] as $cliente) {
                              $row = "<tr>\n";
                              $row .= "\t\t\t\t\t\t\t<td class='text-center'>" . $cliente["IdCliente"] . "</td>\n";
                              $row .= "\t\t\t\t\t\t\t<td>" . $cliente["Nombre"] . "</td>\n";
                              $row .= "\t\t\t\t\t\t\t<td>" . $cliente["Telefono"] . "</td>\n";
                              $row .= "\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t";
                              echo $row;
                            }
                          ?>

                        </tbody>
                      </table>
                    </div>
                </div>
            <?php include './views/modules/components/footer.php'; ?>
        </div>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <?php include "./views/modules/components/scripts.php"; ?>
</body>

</html>
