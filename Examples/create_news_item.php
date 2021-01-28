<?php

require("./config/d2l_functions.php");


$filter_array = array();
$filter_array['Title'] = "Test News Item";
$filter_array['Body']=array(
	array( 
        "Text" => "test new annoucement", 
        "Html" => null
    )
 );
$filter_array['StartDate'] = "2020-01-01T01:00:00.0000000Z";
$filter_array['EndDate'] = null;
$filter_array['IsGlobal'] = false;
$filter_array['IsPublished'] = true;
$filter_array['ShowOnlyInCourseOfferings'] = false;
$filter_array['IsAuthorInfoShown'] = false;






$test = '
{
"Title": "Test News Item2",
"Body": { "Text": "test new announcement2 - TAM testing creating new news item2", "Html": null },
"StartDate": "2020-01-01T01:00:00.0000000Z",
"EndDate": null,
"IsGlobal": false,
"IsPublished": true,
"ShowOnlyInCourseOfferings": false,
"IsAuthorInfoShown": true
}';

echo "<br><br><br><br>";

var_dump(d2l_create_news_item(467238, $test));

echo "<br><br><br><br>";

//var_dump(d2l_get_user("mforest"));

//echo "<br><br><br><br>";

//var_dump(d2l_update_news_item(467238, 557116, $test));

//var_dump(d2l_delete_news_item(467238,557081));



?>