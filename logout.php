<?php
session_start();

// Simpan bahasa agar tetap sama setelah logout
$bahasa = "id";
if (isset($_SESSION["bahasa"])) {
    $bahasa = $_SESSION["bahasa"];
}

session_unset();
session_destroy();

session_start();
$_SESSION["bahasa"] = $bahasa;

header("Location: login.php");
exit;
