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

$test = d2l_start_datahub_advlist_alljobstatus();
print_r($test);


?>