<?php
$conn = mysqli_connect("localhost", "root", "", "pihole_sim");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
