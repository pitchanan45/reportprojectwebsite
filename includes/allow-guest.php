<?php

$isAllowed = false;

if (isset($_SESSION["username"])) {
    if ($_SESSION["username"] == "") {
        $isAllowed = true;
    }
} else {
    $isAllowed = true;
}

if (!$isAllowed) {
    header("Location: /projectx/default-route.php");
}
