<?php

session_start();
include './koneksi.php';

$user_id = $_SESSION['user']['user_id'];
$foto_id = $_POST['foto_id'];
$isi_komentar = $_POST['isi_komentar'];
$tanggal_komentar = date('Y-m-d');

mysqli_query($koneksi, "INSERT INTO komentar_foto VALUES ('', '$foto_id', '$user_id', '$isi_komentar', '$tanggal_komentar')");

echo "<script>
    window.location = 'detail-post.php?foto_id=$foto_id';
</script>";
