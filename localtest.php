<?php

define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../../../config.php');

$pwd = get_config('logstore_xapi', 'password');
if (!$_SERVER || empty($_SERVER['PHP_AUTH_PW']) || $_SERVER['PHP_AUTH_PW'] !== $pwd) {
    header('HTTP/1.0 403 Forbidden');
    die;
}

$getvalues = !empty($_GET) ? json_encode($_GET) : '';
$postvalues = !empty($_POST) ? json_encode($_POST) : '';
$postbody = file_get_contents('php://input');
$servervalues = json_encode($_SERVER);

$data = (object)[
    'timecreated' => time(),
    'byget' => $getvalues,
    'bypost' => $postvalues,
    'bypostbody' => $postbody,
    'byserver' => $servervalues,
];

$DB->insert_record('logstore_xapi_localtest', $data);

echo 1;
