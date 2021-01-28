<?php

require("./config/d2l_functions.php");

$data = array(
    "Name" => "Spring 2020 - Quantitative Reasoning (MATH-1001-A)",
    "Code" => "202001-MATH-1001-A",
    "StartDate" => "2020-01-13T05:00:00.0000000Z",
    "EndDate" => "2020-05-08T03:59:00.0000000Z",
    "IsActive" => True
);

var_dump(d2l_update_course(542485, $data));



?>