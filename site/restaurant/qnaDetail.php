<?php
require_once("DB.php");
require_once("lib.php");

if(!ss()) {
    view('qnaLogin');
    exit;
}

extract($_GET);
$q = DB::fetch("SELECT * FROM q WHERE idx=?", [$idx]);
$a = DB::fetchAll("SELECT * FROM a WHERE qIdx=?", [$idx]);
// $a - 답변에 대한 데이터

view('qnaDetailContents', ["q"=> $q, "a"=> $a]);