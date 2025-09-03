<?php
require_once("DB.php");

extract($_POST);

DB::execute("INSERT INTO reserve SET name=?, pCnt=?, menu=?, mCnt=?, rDate=?, bName=?, bPhone=?, bEmail=?, bPw=?", [$name, $cnt, $menu, $mCnt, "$date $time", $bName, $phone, $bEmail, $bPw]);
echo "<script>alert('예약 성공!')</script>";
echo "<script>location.replace('../index.php')</script>";