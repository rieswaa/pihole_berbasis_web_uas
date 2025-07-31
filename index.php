<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';

// Ambil data statistik dari database
$query_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM dns_logs");
if (!$query_total) die("Error: " . mysqli_error($conn));
$total_requests = mysqli_fetch_assoc($query_total)['total'];

$query_blocked = mysqli_query($conn, "SELECT COUNT(*) as total FROM dns_logs WHERE status='blocked'");
if (!$query_blocked) die("Error: " . mysqli_error($conn));
$blocked = mysqli_fetch_assoc($query_blocked)['total'];

$allowed = $total_requests - $blocked;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Pi-Hole Simulator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const theme = localStorage.getItem('theme') || 'dark';
        document.body.classList.add(theme);

        const toggle = document.getElementById('toggle-theme');
        if (toggle) {
            toggle.addEventListener('click', () => {
                document.body.classList.toggle('light');
                document.body.classList.toggle('dark');
                localStorage.setItem('theme', document.body.classList.contains('light') ? 'light' : 'dark');
            });
        }
    });
    </script>
    <style>
        body {
            background-color: #121212;
            color: #fff;
        }
        .card {
            background-color: #1e1e1e;
            color: #ffffff;
            border: 1px solid #333;
            box-shadow: 0 0 10px rgba(147, 51, 234, 0.2);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        .card:hover {
            transform: scale(1.03);
            border-color: #9333ea;
        }
        .btn-purple {
            background-color: #9333ea;
            color: white;
        }
        .btn-purple:hover {
            background-color: #7e22ce;
         }
        .card h5, .card h3 {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dashboard Pi-Hole</h2>
    <div class="d-flex gap-2">
        <button id="toggle-theme" class="btn btn-outline-light">🌓</button>
        <a href="logs.php" class="btn btn-outline-light me-2">Lihat Log</a>
        <a href="logout.php" class="btn btn-purple">Logout</a>
    </div>
</div>


        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <h5>Total Requests</h5>
                    <h3><?= $total_requests ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <h5>Permintaan Diblokir</h5>
                    <h3><?= $blocked ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <h5>Permintaan Diizinkan</h5>
                    <h3><?= $allowed ?></h3>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <canvas id="requestChart" height="100"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('requestChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Diblokir', 'Diizinkan'],
                datasets: [{
                    label: 'Permintaan DNS',
                    data: [<?= $blocked ?>, <?= $allowed ?>],
                    backgroundColor: ['#e11d48', '#22c55e'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        enabled: true
                    },
                    legend: { position: 'bottom' }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            }
        });
    </script>
</body>
</html>
