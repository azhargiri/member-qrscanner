<?php

// ================= Start bootstraping =================

$always_https = false;

// Parse URI to get route path
$base_script_name = explode('/', $_SERVER['SCRIPT_NAME']);
$last_array = array_pop($base_script_name);
// This is base application path
$base_application_path = join('/', $base_script_name);

$request_uri = $_SERVER['REQUEST_URI'];
$request_path = substr($request_uri, 0, strlen($request_uri) - strlen($_SERVER['QUERY_STRING']));

// This is current base path
$request_path = rtrim($request_path, '?');

$real_request_path = substr($request_path, strlen($base_application_path));

// $request_path, $real_request_path

if (getenv('ALWAYS_HTTPS')) 
    $always_https = true;


// This is route path
$path = $real_request_path ?: '/';

// -- end Parse URI

function make_route_of_path($path = '', $query_params = [])
{
    global $base_application_path;

    $url = http_or_https() . '://' . $_SERVER['HTTP_HOST'] . $base_application_path . $path;
    $query_string = http_build_query($query_params);
    
    return $url . ($query_string ? '?' . $query_string : '');
}

// Detect HTTPS
$https = false;

( isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS'] == 'ON') ) && $https = true;

function http_or_https()
{
    global $https, $always_https;

    return $https || $always_https ? 'https' : 'http';
}
// -- end Detect HTTPS


// ================= end boostraping =================


// Let's name it controller

if ($path === null) throw new Exception('Unknown route');

if ($path == '/')
{
    include 'scanner.php';
    exit;
}

if ($path == '/member')
{
    $id = @$_GET['id'];

    include 'member.php';
    exit;
}
