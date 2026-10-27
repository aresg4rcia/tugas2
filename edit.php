<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

require "koneksi.php";
require "bahasa.php";

$id = 0;
if (isset($_GET["id"])) {
    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);
}

if (!$id) {
    header("Location: index.php");
    exit;
}

$error = [];

if (isset($_POST["perbarui"])) {
    $nim      = htmlspecialchars(trim($_POST["nim"]));
    $nama     = htmlspecialchars(trim($_POST["nama"]));
    $email    = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $jurusan  = htmlspecialchars(trim($_POST["jurusan"]));
    $angkatan = htmlspecialchars(trim($_POST["angkatan"]));

    if (empty($nim) || !is_numeric($nim) || strlen($nim) > 10) {
        $error[] = $teks["err_nim"];
    }

    if (empty($nama)) {
        $error[] = $teks["err_nama"];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = $teks["err_email"];
    }

    if (empty($jurusan)) {
        $error[] = $teks["err_jurusan"];
    }

    if (!is_numeric($angkatan)) {
        $error[] = $teks["err_angkatan"];
    } elseif ($angkatan < 2000 || $angkatan > date("Y")) {
        $error[] = $teks["err_angkatan"];
    }

    if (empty($error)) {
        try {
            $stmt = $pdo->prepare(
                "UPDATE mahasiswa
                 SET nim = :nim, nama = :nama, email = :email,
                     jurusan = :jurusan, angkatan = :angkatan
                 WHERE id = :id"
            );
            $stmt->execute([
                ":nim"      => $nim,
                ":nama"     => $nama,
                ":email"    => $email,
                ":jurusan"  => $jurusan,
                ":angkatan" => $angkatan,
                ":id"       => $id
            ]);

            header("Location: index.php?pesan=ubah");
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error[] = $teks["err_nim_ada"];
            } else {
                $error[] = "Gagal mengubah data: ".$e->getMessage();
            }
        }
    }
} else {
    // Pertama kali dibuka: ambil data lama dari database
    $stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE id = :id");
    $stmt->execute([":id" => $id]);
    $mhs = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$mhs) {
        header("Location: index.php");
        exit;
    }

    $nim      = $mhs["nim"];
    $nama     = $mhs["nama"];
    $email    = $mhs["email"];
    $jurusan  = $mhs["jurusan"];
    $angkatan = $mhs["angkatan"];
}

require "atas.php";
?>

<h3><?php echo $teks["ubah"]; ?></h3>

<?php foreach ($error as $e) { ?>
    <p class="error">- <?php echo $e; ?></p>
<?php } ?>

<form method="POST" action="edit.php?id=<?php echo $id; ?>">
    <p>
        <label><?php echo $teks["nim"]; ?></label><br>
        <input type="text" name="nim" value="<?php echo $nim; ?>">
    </p>
    <p>
        <label><?php echo $teks["nama"]; ?></label><br>
        <input type="text" name="nama" value="<?php echo $nama; ?>">
    </p>
    <p>
        <label><?php echo $teks["email"]; ?></label><br>
        <input type="text" name="email" value="<?php echo $email; ?>">
    </p>
    <p>
        <label><?php echo $teks["jurusan"]; ?></label><br>
        <input type="text" name="jurusan" value="<?php echo $jurusan; ?>">
    </p>
    <p>
        <label><?php echo $teks["angkatan"]; ?></label><br>
        <input type="text" name="angkatan" value="<?php echo $angkatan; ?>">
    </p>
    <button type="submit" name="perbarui"><?php echo $teks["perbarui"]; ?></button>
    <a href="index.php"><?php echo $teks["batal"]; ?></a>
</form>

<?php require "bawah.php"; ?>
