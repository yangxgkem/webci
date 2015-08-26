<?php

function http_post_data($url, $data_string) {
    
    $cookie_jar = dirname(__FILE__)."/curl.cookie";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json; charset=utf-8',
		'Content-Length: ' . strlen($data_string))
	);
    ob_start();
    curl_exec($ch);
    $return_content = ob_get_contents();
    ob_end_clean();

    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return $return_content;
}

$url  = "http://127.0.0.1:6001/App/checkproto";


$protomsg = array(
    'pname'=>'c2s_login_register',
    'zone' => '+86',
    'id' => '159159159152',
    'pw' => 'root~!@#$%^&*()',
);


$protomsg = array(
    'pname'=>'c2s_login_code',
    'code' => '183475',
);


$protomsg = array(
    'pname'=>'c2s_login_guide_check',
    'name' => '呵呵哒',
    'guide_id' => 'D-1308-001807',
    'id_card' => '540781199110174715',
);
/*

*/

$data = json_encode($protomsg); 
$ret = http_post_data($url, $data);
echo var_dump(json_decode($ret, TRUE));
