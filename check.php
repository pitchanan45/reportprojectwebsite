<?php

session_start();

if (isset($_GET["isLoggedIn"])) {
    if ($_GET["isLoggedIn"] == "false") {
        if (!isset($_SESSION["username"])) {
            echo true;
        }
    }
}


if (isset($_SESSION["role"])) {
    if (isset($_GET["support"])) {
        if ($_GET["support"] == $_SESSION["role"]) {
            echo true;
        }
    }
}

echo false;
