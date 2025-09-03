<?php
require_once("DB.php");

extract($_GET);

$data = DB::fetchAll("SELECT * FROM reserve WHERE bEmail=? and bPw=?", [$email, $pw]);
header('Content-type: application/json');
echo json_encode($data);