<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>FIESC | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/font-awesome/css/font-awesome.min.css')) ?>">   
        <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/dist/css/adminlte.css')) ?>">   
        <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/notify/notify.css')) ?>">   
        <script src="<?php echo (base_url('assets/AdminLTE_300/plugins/jquery/jquery.min.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/AdminLTE_300/plugins/notify/notify.js')) ?>"></script>
        <script src="<?php echo ('assets/js/home/login.js') ?>" type="text/javascript"></script>
    </head>

    <body class="hold-transition login-page" oncontextmenu="return false" cz-shortcut-listen="true">
        <div class="login-box">
            <div class="login-logo">
                <a><b>FIESC</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Olá, insira seu login</p>
                    <form method="post" id="form_login" class="form-login">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" placeholder="Email" name="nume_matricula" id="nume_matricula">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" name="codi_senha" id="codi_senha">
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" id="btn-entrar"  class="btn btn-primary btn-block btn-flat">Entrar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </body>
</html>