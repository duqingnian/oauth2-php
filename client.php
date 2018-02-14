<?php
$self_url       = urldecode('http://code.thinkh5.com/oauth/index.php');
$client_id      = 'demoapp';
$client_secret  = 'demopass';
define('API_URL', 'http://9poc.com/api/');
define('API_AUTHORIZE', API_URL.'authorize');
define('API_TOKEN', API_URL.'token');
define('API_RESOURCE', API_URL.'resource');
if(!isset($_GET['code'])){
    $api_code       = API_AUTHORIZE.'?response_type=code&client_id='.$client_id.'&redirect_uri='.$self_url.'&state=NULL';
    header('location:'.$api_code);
    exit();
}else{
    $code = $_GET['code'];
    $query = array(
        'grant_type'    => 'authorization_code',
        'code'          => $code,
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri'  => $self_url,
    );

    $response = http(API_TOKEN,$query);
    $json = json_decode($response,true);
    if(array_key_exists('error', $json)){
        echo $json['error_description'];
        exit();
    }else{
        $access_token = $json['access_token'];
        $response = http(API_RESOURCE.'?action=debug&access_token='.$access_token);
        print_r($response);die();
    }
}

function http($url, $data = null) {
        $curl = curl_init ();
        curl_setopt ( $curl, CURLOPT_URL, $url );
        curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
        if (! empty ( $data )) {
            curl_setopt ( $curl, CURLOPT_POST, 1 );
            curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
        }
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
        $output = curl_exec ( $curl );
        curl_close ( $curl );
        return $output;
    }