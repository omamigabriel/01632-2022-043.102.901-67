<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
        <title>FIESC</title>
        <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/font-awesome/css/font-awesome.min.css')) ?>">   
        <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/dist/css/adminlte.css')) ?>">
        <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/notify/notify.css')) ?>">   
        <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/datatables/dataTables.bootstrap4.css')) ?>">
        <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/select2/select2.css')) ?>">
    </head>

    <body class="sidebar-mini">
        <nav class="navbar navbar-expand bg-white navbar-light border-bottom">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="<?= base_url('Home'); ?>"><b>FIESC</b></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="javascript:void(0);" onclick="pagina_01()" class="nav-link">Página 01</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="javascript:void(0);" onclick="pagina_02()" class="nav-link">Página 02</a>
                </li> -->
            </ul>
            <ul class="navbar-nav ml-auto">                    
                <?php echo substr(ucfirst($this->session->nome), 0, 20); ?>
                <li class="nav-item">
                    <a href="<?php echo base_url("Login/logout") ?>" class="nav-link">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div id="resultado">
            <div id="exibe" style="display:none;"></div>



    