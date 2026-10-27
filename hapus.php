<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

require "koneksi.php";

if (isset($_POST["id"])) {
    $id = filter_var($_POST["id"], FILTER_VALIDATE_INT);

    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE id = :id");
            $stmt->execute([":id" => $id]);
        } catch (PDOException $e) {
            die("Gagal menghapus data: ".$e->getMessage());
        }
    }
}

header("Location: index.php?pesan=hapus");
exit;
