<?php
require_once("DB.php");

extract($_GET);
if(!$name || !$date || !$time) {
    echo 'false';
    exit;
}

$data = DB::fetch("SELECT * FROM reserve WHERE name=? and rDate=?", [$name, "$date $time"]);
if($data) {
    echo 'false';
    exit;
}

echo 'true';
