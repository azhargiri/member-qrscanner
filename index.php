<?php

// var_dump($_SERVER); die();
$path = ($_SERVER['PATH_INFO'] ?: '/');

if ($path === null) throw new Exception('unknown route');


if ($path == '/')
{
    include 'scanner.php';
    exit;
}

if ($path == '/member')
{
    $id = @$_GET['id'];

    echo "<h1>Halo member {$id}</h1>";
    echo "<hr>";
    echo "<a href=\"https://{$_SERVER['HTTP_HOST']}/\">Kembali</a>";

    exit;
}





?>
