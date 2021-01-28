<?php

$page_debug = 0;

if ($page_debug == 1) {
  ini_set('display_errors','1');
  echo '<pre>';
  print_r($_POST);
  print_r($_SESSION);
  echo '</pre>';
}

include("./config/mysql_config.php");
require("./config/d2l_functions.php");

date_default_timezone_set('America/New_York');

var_dump(d2l_get_datahub_advlist_download("828de55d-1705-49e6-bbac-5b40d228edc0"));

?>