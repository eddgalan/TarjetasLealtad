<!DOCTYPE html>
<html>
<head>
    <?php include './views/modules/components/head.php'; ?>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;./views/modules/assets/img/banking.jpg&quot;);"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Bienvenido</h4>
                                    </div>
                                    <form class="user" method="POST" action="<?= $data['host'] ?>/login">
                                        <div class="form-group">
                                          <label for="username">Nombre de usuario: </label>
                                          <input class="form-control form-control-user" type="text" name="username" placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                          <label for="password">Contraseña: </label>
                                          <input class="form-control form-control-user" type="password" name="password" placeholder="* * * * * * * " required>
                                        </div>
                                        <?php include './views/modules/components/notifications.php'; ?>
                                        <hr>
                                        <button class="btn btn-primary btn-block text-white btn-user" type="submit">Entrar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include './views/modules/components/scripts.php'; ?>
</body>

</html>
