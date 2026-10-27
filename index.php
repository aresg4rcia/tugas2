<?php
session_start();

// Halaman ini hanya boleh diakses setelah login
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

require "koneksi.php";
require "bahasa.php";

$pesan = "";
if (isset($_GET["pesan"])) {
    switch ($_GET["pesan"]) {
        case "tambah":
            $pesan = $teks["ok_tambah"];
            break;
        case "ubah":
            $pesan = $teks["ok_ubah"];
            break;
        case "hapus":
            $pesan = $teks["ok_hapus"];
            break;
    }
}

try {
    $result    = $pdo->query("SELECT * FROM mahasiswa ORDER BY id DESC");
    $mahasiswa = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal mengambil data: ".$e->getMessage());
}

require "atas.php";
?>

<h3><?php echo $teks["data_mhs"]; ?></h3>

<?php if ($pesan != "") { ?>
    <p class="sukses"><?php echo $pesan; ?></p>
<?php } ?>

<table>
    <tr>
        <th><?php echo $teks["no"]; ?></th>
        <th><?php echo $teks["nim"]; ?></th>
        <th><?php echo $teks["nama"]; ?></th>
        <th><?php echo $teks["email"]; ?></th>
        <th><?php echo $teks["jurusan"]; ?></th>
        <th><?php echo $teks["angkatan"]; ?></th>
        <th><?php echo $teks["aksi"]; ?></th>
    </tr>

    <?php if (empty($mahasiswa)) { ?>
    <tr>
        <td colspan="7"><?php echo $teks["kosong"]; ?></td>
    </tr>
    <?php } else { ?>
        <?php $no = 1; ?>
        <?php foreach ($mahasiswa as $mhs) { ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $mhs["nim"]; ?></td>
            <td><?php echo $mhs["nama"]; ?></td>
            <td><?php echo $mhs["email"]; ?></td>
            <td><?php echo $mhs["jurusan"]; ?></td>
            <td><?php echo $mhs["angkatan"]; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $mhs["id"]; ?>"><?php echo $teks["ubah"]; ?></a>
                <form method="POST" action="hapus.php" style="display:inline"
                      onsubmit="return confirm('<?php echo $teks["konfirmasi"]; ?>')">
                    <input type="hidden" name="id" value="<?php echo $mhs["id"]; ?>">
                    <button type="submit"><?php echo $teks["hapus"]; ?></button>
                </form>
            </td>
        </tr>
        <?php $no++; ?>
        <?php } ?>
    <?php } ?>
</table>

<?php require "bawah.php"; ?>
