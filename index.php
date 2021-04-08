<?php
  /* ..:: Imports Principales ::.. */
  require 'controllers/routes.php';
  require 'libs/view.php';
  include 'libs/log.php';

  $host_name = "http://localhost/TarjetasLealtad";
  $site_name = "My Web Site";

  $app = new Routes($host_name, $site_name);
?>
