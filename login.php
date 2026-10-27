<?php
session_start();
require "koneksi.php";
require "bahasa.php";

// Jika sudah login, langsung ke halaman utama
if (isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST["login"])) {
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error = $teks["err_isi_login"];
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([":username" => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["username"] = $user["username"];
            header("Location: index.php");
            exit;
        } else {
            $error = $teks["err_login"];
        }
    }
}

require "atas.php";
?>

<h3><?php echo $teks["login"]; ?></h3>

<?php if ($error != "") { ?>
    <p class="error"><?php echo $error; ?></p>
<?php } ?>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <p>
        <label><?php echo $teks["username"]; ?></label><br>
        <input type="text" name="username">
    </p>
    <p>
        <label><?php echo $teks["password"]; ?></label><br>
        <input type="password" name="password">
    </p>
    <button type="submit" name="login"><?php echo $teks["login"]; ?></button>
</form>

<?php require "bawah.php"; ?>
