<?php
require_once("DB.php");
require_once("lib.php");

extract($_GET);
DB::execute("UPDATE q SET aIdx=? WHERE idx=?", [$idx, $aIdx]);
back();