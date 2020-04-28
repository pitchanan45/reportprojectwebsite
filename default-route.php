<?php

session_start();

if (isset($_SESSION["role"])) {
    $role = $_SESSION["role"];

    $redirectTo = "";
    if ($role == "admin") $redirectTo = "/projectx/admin.php";
    if ($role == "respon") $redirectTo = "/projectx/respon.php";
    if ($role == "manager") $redirectTo = "/projectx/manager.php";

    header("Location: " . $redirectTo);
} else {
    header("Location: /projectx/login.html");
}
