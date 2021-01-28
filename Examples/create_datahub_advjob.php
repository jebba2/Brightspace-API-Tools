<?php

//[PluginId] => df537dc9-8358-4c28-9ab9-ddb8d364a9fc
//[Name] => Rubric Object Criteria
//[Description] => The rubric object criteria data set returns the basic details for all rubric object criteria.
//[CreatedDate] => 2020-02-02T05:02:43.572Z
//[DownloadLink] => https://georgiasouthern.desire2learn.com/d2l/api/lp/1.25/dataexport/bds/download/df537dc9-8358-4c28-9ab9-ddb8d364a9fc
//[DownloadSize] => 11768655

//Set the Variable below to '1' to enter debugging mode
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
$endDate   = date("Y-m-d")."T23:59:59.000Z";
$startDate = date('Y-m-d', strtotime('-2 year'))."T00:00:00.000Z";



//Enrollments and Withdrawals
$filter_array = array();
$filter_array['DataSetId'] = "c1bf7603-669f-4bef-8cf4-651b914c4678";
$filter_array["Filters"]=array(
	array( 
        "name" => "startDate", 
        "value" => "$startDate"
    ), 
    array( 
        "name" => "endDate", 
        "value" => "$endDate"
    )
);
$result = d2l_start_datahub_advlist_startjob($filter_array);
$sql = "INSERT INTO datahub_queuedjobs (Name, SubmitDate, ExportJobId, DataSetId, DownloadDate) VALUES (?,?,?,?,?)";
$stmt= $conn->prepare($sql);
$stmt->execute([$result->Name, $result->SubmitDate, $result->ExportJobId, $result->DataSetId, $result->DownloadDate]);
//End Enrollments and Withdrawals

//Learner Usage
$filter_array = array();
$filter_array['DataSetId'] = "c195aa85-b2be-4444-aa52-570e19bfee9e";
$filter_array["Filters"]=array(
  
    array( 
        "name" => "parentOrgUnitId", 
        "value" => "6606"
    ), 
    array( 
        "name" => "roles", 
        "value" => "103"
    ), 

    array( 
        "name" => "startDate", 
        "value" => "$startDate"
    ), 
    array( 
        "name" => "endDate", 
        "value" => "$endDate"
    )
);

$result = d2l_start_datahub_advlist_startjob($filter_array);
$sql = "INSERT INTO datahub_queuedjobs (Name, SubmitDate, ExportJobId, DataSetId, DownloadDate) VALUES (?,?,?,?,?)";
$stmt= $conn->prepare($sql);
$stmt->execute([$result->Name, $result->SubmitDate, $result->ExportJobId, $result->DataSetId, $result->DownloadDate]);
//End Learner Usage

//instructor Usage
$filter_array = array();
$filter_array['DataSetId'] = "df7d0ef3-bcab-4171-bc37-5929d5867cd8";
$filter_array["Filters"]=array(
  
    array( 
        "name" => "parentOrgUnitId", 
        "value" => "6606"
    ), 
    array( 
        "name" => "roles", 
        "value" => "102"
    ), 

    array( 
        "name" => "startDate", 
        "value" => "$startDate"
    ), 
    array( 
        "name" => "endDate", 
        "value" => "$endDate"
    )
);

$result = d2l_start_datahub_advlist_startjob($filter_array);
$sql = "INSERT INTO datahub_queuedjobs (Name, SubmitDate, ExportJobId, DataSetId, DownloadDate) VALUES (?,?,?,?,?)";
$stmt= $conn->prepare($sql);
$stmt->execute([$result->Name, $result->SubmitDate, $result->ExportJobId, $result->DataSetId, $result->DownloadDate]);
//instructor Usage

?>