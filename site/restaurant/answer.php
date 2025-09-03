<?php

require_once("DB.php");
require_once("lib.php");

extract($_POST);
DB::execute("INSERT INTO a SET content=?, qIdx=?", [$content, $qIdx]);