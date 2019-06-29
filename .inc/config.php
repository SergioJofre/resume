<?php
//
// SQueRT Settings
//

// DB Info

$dbHost = "127.0.0.1";
$dbName = "securityonion_db";
$dbUser = "readonly";
$dbPass = "securityonion";

// Sguild Info

$sgVer  = "SGUIL-0.9.0 OPENSSL ENABLED";
$sgHost = "127.0.0.1";
$sgPort = "7734";

// Elasticsearch
$clientparams = array();
$clientparams['hosts'] = array(
    'https://10.0.0.1:443'
);

//$clientparams['guzzleOptions'] = array(
//    \Guzzle\Http\Client::SSL_CERT_AUTHORITY => 'system',
//    \Guzzle\Http\Client::CURL_OPTIONS => [
//        CURLOPT_SSL_VERIFYPEER => true,
//        CURLOPT_CAINFO => '/etc/ssl/elasticsearch/es.pem', 
//        CURLOPT_SSLCERTTYPE => 'PEM',
//    ]   
//);

//$clientparams['connectionParams']['auth'] = array(
//    'username',  // Username
//    'password',  // Password
//    'Basic'      // Auth: Basic, Digest, NTLM, Any
//);

// Where are the rules? If you have multiple dirs, separate each with: ||
$rulePath = "/etc/nsm/rules";
?>
