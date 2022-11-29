<?php

require __DIR__ . '/vendor/autoload.php';

if ($_SESSION['user'] == false) {
  header("location: ../seguranca/logout.php");
  exit;
}

$autorizado = Security::getUser()['no_autorizado'];
$email = Security::getUser()['ds_email'];

$words = explode(" ", $autorizado);
$initials = null;
foreach ($words as $w) {
  $initials .= $w[0];
}
$iniciais = $initials[0] . $w[0];

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>iMob</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/daterangepicker/daterangepicker.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>

  .circulo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid white;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .required:after {
    content: " *";
    color: red;
  }

  .has-error {
    color: #dc3545;
  }

  .has-error .form-control {
    border: 1px solid #dc3545;
  }

</style>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand bg-gradient-dark navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="false" href="#" role="button">
            <i class="fas fa-cogs"></i>
          </a>
        </li>
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle circulo" data-toggle="dropdown">
          <span class="d-none d-md-inline"><?php echo mb_strtoupper($iniciais); ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <li class="user-header bg-dark">
            <h6 align="left"><?php echo $autorizado ?></h6>
            <p align="left"><small><strong>E-mail:</strong> <?php echo $email ?></small></p>

          </li>
          <li class="user-footer">
            <a href="/seguranca/alterarSenha.php" class="btn btn-default btn-flat">Alterar Senha</a>
            <a href="/seguranca/logout.php" class="btn btn-danger btn-flat float-right"><i class="fa fa-power-off"></i></a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/principal.php" class="brand-link logo-switch bg-gradient-dark">
      <span class="brand-image-xl logo-xs" style="font-size: 50px; margin-left: 15px;">i</span>
      <span class="brand-image-xs logo-xl" style="font-size: 50px; margin-left: 56px;">iMob</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header" style="text-align: center">Menu Principal</li>
          <li class="nav-item">
            <a href="/cliente/index.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p><small>Cliente</small></p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/imovel/index.php" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p><small>Imóvel</small></p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/contrato/index.php" class="nav-link">
              <i class="nav-icon fas fa-file-contract"></i>
              <p><small>Contrato</small></p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/gestao/index.php" class="nav-link">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p><small>Gestão</small></p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
    <aside class="control-sidebar control-sidebar-dark" style="display: none;">
      <div class="p-3 control-sidebar-content" style="">
        <h5 style="text-align: center;">Painel Administrativo</h5>
        <hr class="mb-2">
        <div class="mb-1">
          <a href="/autorizado/index.php" class="nav-link">
            <span class="fa-stack">
                <i class="fa fa-circle fa-stack-2x text-success"></i>
                <i class="fa fa-users fa-stack-1x fa-inverse"></i>
            </span>
            <span><small>Autorizados</small></span>
          </a>
        </div>
      </div>
    </aside>




