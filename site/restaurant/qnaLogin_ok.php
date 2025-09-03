<?php
require_once("DB.php");
require_once("lib.php");

extract($_POST);
$res = DB::fetch("SELECT bEmail as email, bPw as pw FROM reserve WHERE bEmail=? and bPw=?", [$email, $pw]);
if($res) {
    $_SESSION['user'] = $res;
}

back();
