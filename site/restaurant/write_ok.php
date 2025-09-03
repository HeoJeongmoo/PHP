<?php
require_once("DB.php");
require_once("lib.php");
extract($_POST);
DB::execute("INSERT INTO q SET title=?, content=?, rName=?, auth=?, attach=?", [$title, $content, $rName, ss()->email.':'.ss()->pw, '']);
move("./qna.php");