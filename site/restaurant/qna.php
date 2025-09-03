<?php
require_once("DB.php");
require_once("lib.php");

if(!ss()) {
    view('qnaLogin');
    exit;
}

$list = DB::fetchAll("SELECT * FROM q WHERE rName=?", [isset($_GET['rName']) ? $_GET['rName'] : '서동한식당']);
var_dump($list);
view('list', ['list' => $list]);