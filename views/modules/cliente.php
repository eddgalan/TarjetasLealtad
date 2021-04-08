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
                    <p>Dato obtenido de la URL: <?= $data['dato_url'] ?></p>
                </div>
            <?php include './views/modules/components/footer.php'; ?>
        </div>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <?php include "./views/modules/components/scripts.php"; ?>
</body>

</html>
