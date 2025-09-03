<?php
session_start();

function ss() {
    return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}

function view($fileName, $d = []) {
    extract($d);

    require_once("./$fileName.php");
}

function move($tg, $t='') {
    if(!empty($t)) {
        echo "<script>alert('$t')</script>";
    }
    echo "<script>location.replace('$tg')</script>";
    exit;
}

function back($t = '') {
    if(!empty($t)) {
        echo "<script>alert('$t')</script>";
    }
    echo "<script>history.back()</script>";
    exit;
}