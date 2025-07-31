<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';

// === PROSES TAMBAH LOG DNS ===
if (isset($_POST['submit_log'])) {
    $domain = mysqli_real_escape_string($conn, $_POST['domain']);
    $status = $_POST['status'];

    $insert = mysqli_query($conn, "INSERT INTO dns_logs (domain, status, timestamp) VALUES ('$domain', '$status', NOW())");
    if ($insert) {
        header("Location: logs.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal menambahkan log</div>";
    }
}

// === FILTER TANGGAL ===
$filter_query = "";
$start = '';
$end = '';

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start = $_GET['start_date'];
    $end = $_GET['end_date'];

    if (!empty($start) && !empty($end)) {
        $filter_query = "WHERE timestamp BETWEEN '$start 00:00:00' AND '$end 23:59:59'";
    }
}

$query_logs = mysqli_query($conn, "SELECT * FROM dns_logs $filter_query ORDER BY timestamp DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat DNS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #fff;
        }
        .card, .table {
            background-color: #1e1e1e;
            color: #fff;
        }
        th, td {
            vertical-align: middle;
        }
        .btn-purple {
            background-color: #9333ea;
            color: white;
        }
        .btn-purple:hover {
            background-color: #7e22ce;
        }
        a {
            color: #9333ea;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Riwayat Permintaan DNS</h3>
        <a href="index.php" class="btn btn-purple">Kembali ke Dashboard</a>
    </div>

    <!-- Form Tambah Log -->
    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-5">
            <label class="form-label">Domain</label>
            <input type="text" name="domain" class="form-control" placeholder="contoh.com" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="allowed">Diizinkan</option>
                <option value="blocked">Diblokir</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" name="submit_log" class="btn btn-purple w-100">+ Tambah Log</button>
        </div>
    </form>

    <!-- Form Filter -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" name="start_date" value="<?= htmlspecialchars($start) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" class="form-control" name="end_date" value="<?= htmlspecialchars($end) ?>">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-purple w-100">Filter</button>
        </div>
    </form>

    <!-- Tabel Riwayat -->
    <div class="card p-3">
        <table class="table table-dark table-hover table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Domain</th>
                    <th>Status</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($query_logs) > 0): $no = 1; ?>
                    <?php while ($log = mysqli_fetch_assoc($query_logs)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($log['domain']) ?></td>
                            <td>
                                <span class="badge <?= $log['status'] === 'blocked' ? 'bg-danger' : 'bg-success' ?>">
                                    <?= $log['status'] ?>
                                </span>
                            </td>
                            <td><?= $log['timestamp'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
