<?php

$isAllowed = false;

if (isset($_SESSION["username"])) {
    if ($_SESSION["username"] != "") {
        if (isset($_SESSION["role"])) {
            if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "respon") {
                $isAllowed = true;
            }
        }
    }
}

if (!$isAllowed) {
    header("Location: /projectx/default-route.php");
}
