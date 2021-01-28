<?php

//[PluginId] => df537dc9-8358-4c28-9ab9-ddb8d364a9fc
//[Name] => Rubric Object Criteria
//[Description] => The rubric object criteria data set returns the basic details for all rubric object criteria.
//[CreatedDate] => 2020-02-02T05:02:43.572Z
//[DownloadLink] => https://georgiasouthern.desire2learn.com/d2l/api/lp/1.25/dataexport/bds/download/df537dc9-8358-4c28-9ab9-ddb8d364a9fc
//[DownloadSize] => 11768655

//Set the Variable below to '1' to enter debugging mode
$page_debug = 1;

if ($page_debug == 1) {
  ini_set('display_errors','1');
  echo '<pre>';
  print_r($_POST);
  print_r($_SESSION);
  echo '</pre>';
}



include("./config/mysql_config.php");
require("./config/d2l_functions.php");


$test = d2l_get_datahub_list();

date_default_timezone_set('America/New_York');
$sql = "delete from datahub_downloads";
$stmt= $conn->prepare($sql);
$stmt->execute();


$i=0;
while ($i < sizeof($test)) 
{
	
	$name 	      = $test[$i]->Name;
	$plugin 	  = $test[$i]->PluginId;
	$created_date = $test[$i]->CreatedDate;
	$downloadlink = $test[$i]->DownloadLink;
	$reset_date   = date("m/d/Y - h:i:sa");
	$description  = $test[$i]->Description;

	$i++;
	$sql = "INSERT INTO datahub_downloads (name, pluginid, created_date, dowloadlink, reset_date, description) VALUES (?,?,?,?,?,?)";
	$stmt= $conn->prepare($sql);
	$stmt->execute([$name, $plugin, $created_date, $downloadlink, $reset_date, $description]);




}


?>