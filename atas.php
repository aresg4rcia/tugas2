<?php
$halaman = basename($_SERVER["PHP_SELF"]);
$tambahan_id = "";
if (isset($_GET["id"])) {
    $tambahan_id = "&id=".(int)$_GET["id"];
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION["bahasa"]; ?>">
<head>
<meta charset="UTF-8">
<title><?php echo $teks["judul"]; ?></title>
<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; }
    th, td { border: 1px solid #000; padding: 5px 10px; }
    input[type=text], input[type=password], input[type=email] { width: 250px; }
    .error { color: red; }
    .sukses { color: green; }
</style>
</head>
<body>

<h2><?php echo $teks["judul"]; ?></h2>

<p>
    <?php echo $teks["bahasa"]; ?> :
    <a href="ganti_bahasa.php?bahasa=id&kembali=<?php echo $halaman.$tambahan_id; ?>">Indonesia</a> |
    <a href="ganti_bahasa.php?bahasa=en&kembali=<?php echo $halaman.$tambahan_id; ?>">English</a>
</p>

<?php if (isset($_SESSION["username"])) { ?>
<p>
    <?php echo $teks["halo"].", ".htmlspecialchars($_SESSION["username"]); ?> |
    <a href="index.php"><?php echo $teks["data_mhs"]; ?></a> |
    <a href="tambah.php"><?php echo $teks["tambah"]; ?></a> |
    <a href="logout.php"><?php echo $teks["logout"]; ?></a>
</p>
<?php } ?>
<hr>
