  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Datacenter | <?= $title ?> </title>

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Maitree" rel="stylesheet">

    <!-- jQuery -->
    <script src="<?= base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="<?= base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <link href="<?= base_url() ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="<?= base_url() ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url() ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">

        <!-- Datatables -->
    <link href="<?= base_url() ?>assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- PNotify -->
    <link href="<?= base_url() ?>assets/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">


    <?php
      if(isset($cssSrc)){
        foreach($cssSrc as $css):
    ?>
        <script src="<?= base_url(); ?><?= $css ?>"></script>
    <?php
        endforeach;
      }
    ?>

    <!-- Custom Theme Style -->
    <link href="<?= base_url() ?>assets/css/custom.css" rel="stylesheet">
  </head>


