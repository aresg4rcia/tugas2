<?php
session_start();

if (isset($_GET["bahasa"])) {
    switch ($_GET["bahasa"]) {
        case "en":
            $_SESSION["bahasa"] = "en";
            break;
        default:
            $_SESSION["bahasa"] = "id";
    }
}

// Kembali ke halaman asal
$halaman_boleh = ["index.php", "login.php", "tambah.php", "edit.php"];
$kembali = "index.php";

if (isset($_GET["kembali"]) && in_array($_GET["kembali"], $halaman_boleh)) {
    $kembali = $_GET["kembali"];
}

if ($kembali == "edit.php" && isset($_GET["id"])) {
    $kembali = "edit.php?id=".(int)$_GET["id"];
}

header("Location: ".$kembali);
exit;
