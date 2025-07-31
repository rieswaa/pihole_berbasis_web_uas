<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';

// Tambah domain ke whitelist
if (isset($_POST['domain'])) {
    $domain = mysqli_real_escape_string($conn, $_POST['domain']);
    mysqli_query($conn, "INSERT INTO whitelist (domain) VALUES ('$domain')");
    header("Location: whitelist.php");
    exit;
}

// Hapus domain dari whitelist
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM whitelist WHERE id = $id");
    header("Location: whitelist.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM whitelist ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Blacklist | Pi-Hole</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #121212; color: #fff; }
        .card { background-color: #1e1e1e; }
        .btn-purple { background-color: #9333ea; color: white; }
        .btn-purple:hover { background-color: #7e22ce; }
    </style>
</head>
<body>
<div class="container py-4">
    <h3>Daftar Blacklist</h3>
    <form method="post" class="d-flex gap-2 my-3">
        <input type="text" name="domain" placeholder="Contoh: ads.example.com" required class="form-control">
        <button class="btn btn-purple">Tambah</button>
    </form>

    <table class="table table-dark table-striped table-bordered">
        <thead><tr><th>#</th><th>Domain</th><th>Aksi</th></tr></thead>
        <tbody>
        <?php $i = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($row['domain']) ?></td>
                <td><a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Hapus</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
