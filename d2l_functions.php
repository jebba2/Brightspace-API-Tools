<?php
/**
 * Production configuration
 */
define("D2L_HOST", "https://georgiasouthern.desire2learn.com");
define("D2L_APP_ID", "");
define("D2L_APP_KEY", "");
define("D2L_USER_ID", "");
define("D2L_USER_KEY", "");
define("D2L_LP_VERSION", "/d2l/api/lp/1.25");
define("D2L_LE_VERSION", "/d2l/api/le/1.34");
define("D2L_ORG_UNIT_ID", "6606");



/**
 * Test configuration
 */
//define("D2L_HOST", "https://gsutest.desire2learn.com");
//define("D2L_APP_ID", "");
//define("D2L_APP_KEY", "");
//define("D2L_USER_ID", "");
//define("D2L_USER_KEY", "");
//define("D2L_LP_VERSION", "/d2l/api/lp/1.25");
//define("D2L_ORG_UNIT_ID", "6606");


/**
 * Usage/Examples
 */
// var_dump(d2l_call_api('GET', '/d2l/api/versions/'));
// var_dump(d2l_call_api('GET', '/d2l/api/lp/1.25/roles/103'));
// var_dump(d2l_get_user("mforest"));
// var_dump(d2l_get_user_names(160178));


/**
 * Retrieve the current user context.s user information.
 */
function d2l_whoami($config = null) {
  d2l_config($config);

  return d2l_call_api("GET", $config->lpVersion."/users/whoami", $config);
}


/**
 * Retrieve data for a particular user
 */
function d2l_get_user($banTPI = null, $eagleID = null, $emailAddress = null, $d2lUserID = null, $config = null) {
  d2l_config($config);

  if ($d2lUserID) {
    return d2l_call_api("GET", $config->lpVersion."/users/".$d2lUserID, null, null, $config);
  }

  $params = array();
  if($banTPI) $params["userName"] = $banTPI;
  if($eagleID) $params["orgDefinedId"] = $eagleID;
  if($emailAddress) $params["externalEmail"] = $emailAddress;

  return count($params) ? d2l_call_api("GET", $config->lpVersion."/users/", $params, null, $config) : false;
}


/**
 * Retrieve data for all users
 */
function d2l_get_all_users($callback = null, $config = null) {
  d2l_config($config);

  $users = array();
  $bookmark = '';
  $hasMoreItems = false;

  do {
    if (!$response = d2l_call_api("GET", $config->lpVersion."/users/", array("bookmark"=>$bookmark))) {
      return false;
    }

    $bookmark = $response->PagingInfo->Bookmark;
    $hasMoreItems = $response->PagingInfo->HasMoreItems;

    foreach($response->Items as $item) {
      $users[$item->UserName] = $item;
    }

    if($callback && is_callable($callback)) $callback($response, $users);
  } while($hasMoreItems);

  return $users;
}


/**
 * Retrieve the collection of users enrolled in the identified org unit
 */
function d2l_get_all_enrolled_users($callback = null, $config = null) {
  d2l_config($config);

  $users = array();
  $bookmark = '';
  $hasMoreItems = false;

  do {
    if (!$response = d2l_call_api("GET", $config->lpVersion."/enrollments/orgUnits/".$config->orgUnitID."/users/", array("bookmark"=>$bookmark))) {
      return false;
    }

    $bookmark = $response->PagingInfo->Bookmark;
    $hasMoreItems = $response->PagingInfo->HasMoreItems;

    foreach($response->Items as $item) {
      $users[$item->User->Identifier] = $item;
    }

    if($callback && is_callable($callback)) $callback($response, $users);
  } while($hasMoreItems);

  return $users;

}


/**
 * Retrieve legal and preferred names for a particular user
 */
function d2l_get_user_names($d2lUserID, $config = null) {
  d2l_config($config);

  return d2l_call_api("GET", $config->lpVersion."/users/".$d2lUserID."/names", null, null, $config);
}


/**
 * Update legal and preferred name data for a particular user
 */
function d2l_update_user_names($d2lUserID, $names, $config = null) {
  d2l_config($config);

  return d2l_call_api("PUT", $config->lpVersion."/users/".$d2lUserID."/names", null, $names, $config);
}


/**
 * Update Course Name
 */
function d2l_update_course($d2lCourseID, $courseinfo, $config = null) {
  d2l_config($config);

  return d2l_call_api("PUT", $config->lpVersion."/courses/$d2lCourseID", null, $courseinfo, $config);
}

/**
 * Create Course 
 */
function d2l_create_course($data, $config = null) {
  d2l_config($config);

  return d2l_call_api("POST", $config->lpVersion."/courses/", null, $data, $config);
}


/**
 * Create News Item
 *
 *
     "Title": <string>,
    "Body": { <composite:RichText> },
    "StartDate": <string:UTCDateTime>,
    "EndDate": <string:UTCDateTime>|null,
    "IsGlobal": <boolean>,
    "IsPublished": <boolean>,
    "ShowOnlyInCourseOfferings": <boolean>,
    "IsAuthorInfoShown": <boolean>  // Added with LE v1.42 API
}

{

"Title": "Test News Item",
"Body": { "Text": "test new annoucement", "Html": null },
"StartDate": "2020-01-01T01:00:00.0000000Z",
"EndDate": null,
"IsGlobal": true,
"IsPublished": true,
"ShowOnlyInCourseOfferings": true,
"IsAuthorInfoShown": true

}
*
 */



function d2l_create_news_item($orgUnitId, $data, $config = null) {
  $LP = "/d2l/api/le/1.42";
  d2l_config($config);
  return d2l_call_api2("POST", $LP."/".$orgUnitId."/news/", null, $data, $config);



}

/**
 * Delete News Item
 */

function d2l_update_news_item($orgUnitId, $newsitem, $data, $config = null) {
  $LP = "/d2l/api/le/1.42";
  d2l_config($config);
  return d2l_call_api2("PUT", $LP."/".$orgUnitId."/news/".$newsitem, null, $data, $config);
}

/**
 * Delete News Item
 */

function d2l_delete_news_item($orgUnitId, $newsitem, $config = null) {
  $LP = "/d2l/api/le/1.42";
  d2l_config($config);
  return d2l_call_api("DELETE", $LP."/".$orgUnitId."/news/".$newsitem, null, null, $config);
}

/**
 * Get Quizzes that are in a course
 */
function d2l_get_quizzes($orgUnitID, $config = null) {
  d2l_config($config);

  return d2l_call_api("GET",$config->leVersion."/".$orgUnitID."/quizzes/", null, null, $config);

}

/**
 * Get Individual Quiz Information
 */
function d2l_get_quiz_info($orgUnitID, $quizID, $config = null) {
  d2l_config($config);

  return d2l_call_api("GET",$config->leVersion."/".$orgUnitID."/quizzes/".$quizID, null, $data, $config);

}

/**
 * Update Individual Quiz
 */
function d2l_put_quiz($orgUnitID, $quizID, $data, $config = null) {
  d2l_config($config);

  return d2l_call_api2("PUT",$config->leVersion."/".$orgUnitID."/quizzes/".$quizID, null, $data, $config);

}

function d2l_delete_quiz($orgUnitId, $quizId, $config = null) {
  $LP = "/d2l/api/le/1.42";
  d2l_config($config);
  return d2l_call_api("DELETE", $LP."/".$orgUnitId."/quizzes/".$quizId, null, null, $config);
}


/**
 * Get Course Information
 */
function d2l_get_course_info($orgUnitID, $config = null) {
  d2l_config($config);

  return d2l_call_api("GET", $config->lpVersion."/courses/".$orgUnitID, null, null, $config);
}


/**
*Get Datahub dataexport list data set
*/
function d2l_get_datahub_list($config = null) {
  d2l_config($config);

  return d2l_call_api("GET", $config->lpVersion."/dataExport/bds/list", null, null, $config);
}

/**
*Get Datahub dataexport list adv data set
*/
function d2l_get_datahub_advlist($config = null) {
  d2l_config($config);

  return d2l_call_api("GET", $config->lpVersion."/dataExport/list", null, null, $config);
}

/**
*Get Datahub dataexport list adv data set
*See d2l_get_datahub_advlist
*/
function d2l_start_datahub_advlist_startjob($data, $config = null) {
  d2l_config($config);
  return d2l_call_api("POST", $config->lpVersion."/dataExport/create", null, $data, $config);
}

/**
*Get Datahub dataexport Advanced Job Status
*See d2l_start_datahub_advlist_startjob
*/
function d2l_get_datahub_advlist_jobstatus($ExportJobId, $config = null) {
  d2l_config($config);
  return d2l_call_api("GET", $config->lpVersion."/dataExport/jobs/".$ExportJobId, null, null, $config);
}

/**
*Get Datahub dataexport Advanced All Jobs Status
*See d2l_start_datahub_advlist_startjob
*/
function d2l_get_datahub_advlist_alljobstatus($config = null) {
  d2l_config($config);
  return d2l_call_api("GET", $config->lpVersion."/dataExport/jobs", null, null, $config);
}

/**
*Download Advanced Datahub dataexport list data set
*/
function d2l_get_datahub_advlist_download($ExportJobId, $config = null) {
  d2l_config($config);


  return d2l_call_api_download("GET", $config->lpVersion."/dataExport/download/".$ExportJobId, null, null, $config);

}

/**
*Get Datahub dataexport list data set
*/
function d2l_get_datahub_list_item_info($fileid, $config = null) {
  d2l_config($config);

  return d2l_call_api("GET", $config->lpVersion."/dataExport/bds/list/".$fileid, null, null, $config);
}

/**
*Download Datahub dataexport list data set 
*/
function d2l_get_datahub_download($fileid, $config = null) {
  d2l_config($config);


  return d2l_call_api_download("GET", $config->lpVersion."/dataExport/bds/download/".$fileid, null, null, $config);

}

/**
 * Make HTTP request to D2L API to download a file
 */
function d2l_call_api_download($action, $route, $params = null, $data = null, $config = null) {
  d2l_config($config);

  $headers = array("Accept: application/json","Content-type: application/json");
  if (!$params || !is_array($params)) $params = array();

  if ($config->oauth2Token) {
    $headers[] = "Authorization: {$config->oauth2Token}";
    $url = $config->host.$route;
  } else {
    $url = d2l_build_url($action, $route, $params, $config);

  }


  $ch = curl_init();
  //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  //curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
  curl_setopt($ch, CURLOPT_URL, $url);
  //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $action);
  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $output = curl_exec($ch);

$file_array = explode("\n\r", $output, 2);
$header_array = explode("\n", $file_array[0]);

foreach($header_array as $header_value) {
    $header_pieces = explode(':', $header_value);
    if(count($header_pieces) == 2) {
        $headers[$header_pieces[0]] = trim($header_pieces[1]);
    }
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


$filename = get_string_between($headers["content-disposition"],'"','"');
header("Content-Disposition: attachment; filename=".$filename."");
header("Content-Type: application/octet-stream;");
echo substr($file_array[1], 1);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

 
}






/**
 * Make HTTP request to D2L API
 */
function d2l_call_api($action, $route, $params = null, $data = null, $config = null) {
  d2l_config($config);

  $headers = array("Accept: application/json","Content-type: application/json");
  if (!$params || !is_array($params)) $params = array();

  if ($config->oauth2Token) {
    $headers[] = "Authorization: {$config->oauth2Token}";
    $url = $config->host.$route;
  } else {
    $url = d2l_build_url($action, $route, $params, $config);
    echo $url;
  }


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $action);
  if ($data) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  }
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $output = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  //return $httpcode == "200" && $output ? @json_decode($output) : false;
  return $output;
}

/**
 * Make HTTP request to D2L API
 */
function d2l_call_api2($action, $route, $params = null, $data = null, $config = null) {
  d2l_config($config);

  $headers = array("Accept: application/json","Content-type: application/json");
  if (!$params || !is_array($params)) $params = array();

  if ($config->oauth2Token) {
    $headers[] = "Authorization: {$config->oauth2Token}";
    $url = $config->host.$route;
  } else {
    $url = d2l_build_url($action, $route, $params, $config);
    echo $url;
  }


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $action);
  if ($data) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  }
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $output = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  //return $httpcode == "200" && $output ? @json_decode($output) : false;
  return $output;
}


/**
 * Build URL string for calling D2L API
 */
function d2l_build_url($action, $route, $params = array(), $config = null) {
  d2l_config($config);

  $timestamp = time();
  $userSignature = strtoupper($action) . "&" . strtolower($route) . "&" . $timestamp;
  $params["x_a"] = $config->appID;
  $params["x_b"] = $config->userID;
  $params["x_c"] = d2l_base64_hash($config->appKey, $userSignature);
  $params["x_d"] = d2l_base64_hash($config->userKey, $userSignature);
  $params["x_t"] = $timestamp;
  return $config->host.$route.d2l_build_query($params);
}


/**
 * Build URL string for requesting an authentication token from the Learning System Framework API.
 */
function d2l_build_auth_url($redirectURL, $config = null) {
  d2l_config($config);

  $route = "/d2l/auth/api/token";
  $params = array(
    "x_a" => $config->appID,
    "x_b" => d2l_base64_hash($config->appKey, $redirectURL),
    "x_target" => $redirectURL
  );

  return $host.$route.d2l_build_query($params);
}


/**
 * New OAUTH2 token
 */
function d2l_new_oauth2_token($code, $redirectURL, $clientID, $clientSecret, $config = null) {
  if ($_SESSION['oauth2_state'] != $_GET['state']) {
    throw new Exception('State mismatch');
  }

  $redirectURL = rawurlencode($redirectURL);
  $params = "grant_type=authorization_code"
          . "&code={$code}"
          . "&redirect_uri={$redirectURL}"
          . "&client_id={$clientID}"
          . "&client_secret={$clientSecret}";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
  curl_setopt($ch, CURLOPT_URL, 'https://auth.brightspace.com/core/connect/token');
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json","Content-type: application/json"));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  return $httpcode == "200" && $response ? @json_decode($response) : false;
}


/**
 * Generate HMAC-SHA256 signature hash for use in authenticating with D2L
 */
function d2l_base64_hash($key, $data) {
  $hash = base64_encode(hash_hmac("sha256", utf8_encode($data), utf8_encode($key), true));
  foreach(array("="=>"","+"=>"-","/"=>"_") as $search => $replace) {
    $hash = str_replace($search,$replace,$hash);
  }
  return $hash;
}


/**
 * Convert array into URL query string
 */
function d2l_build_query($params) {
  if(!$params || !count($params)) return "";

  $queryString = array();
  foreach($params as $key => $value) {
    $queryString[] = "${key}=${value}";
  }
  return "?" . implode("&", $queryString);
}


/**
 * Initialize D2L config object
 */
function d2l_config(&$config) {
  static $defaultConfig;

  if (!$defaultConfig) {
    $defaultConfig = json_decode(json_encode(array(
      "host" => D2L_HOST,
      "appID" => D2L_APP_ID,
      "appKey" => D2L_APP_KEY,
      "userID" => D2L_USER_ID,
      "userKey" => D2L_USER_KEY,
      "oauth2Token" => '',
      "lpVersion" => D2L_LP_VERSION,
      "leVersion" => D2L_LE_VERSION,
      "orgUnitID" => D2L_ORG_UNIT_ID
    )));
  }

  if ($config) {
    if (is_array($config)) {
      $config = json_decode(json_encode($config));
    } else if(!is_object($config)) {
      $config = $defaultConfig;
    }

    foreach($defaultConfig as $name => $value) {
      if (!isset($config->$name)) {
        $config->$name = $value;
      }
    }
  } else {
    $config = $defaultConfig;
  }
}