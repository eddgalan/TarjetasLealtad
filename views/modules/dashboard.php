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
                <div class="container-fluid" style="margin-top:15px;">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0 color_black"> <i class="fas fa-home"></i> Dashboard </h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-left-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col mr-2">
                                            <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Tarjetas</span></div>
                                            <div class="text-dark font-weight-bold h5 mb-0"><span> 100 </span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-credit-card fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-left-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col mr-2">
                                            <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Transacciones realizadas</span></div>
                                            <div class="text-dark font-weight-bold h5 mb-0"><span>$215,000</span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                                    </div>
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
