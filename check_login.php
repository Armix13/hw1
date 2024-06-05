<?php

require_once './dbconfig.php';
session_start();

function checkLogin()
{
    if (isset($_SESSION["id"])) {
        return $_SESSION["id"];
    } else {
        return 0;
    }
}
