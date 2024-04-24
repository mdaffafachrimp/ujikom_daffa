<?php
session_start();
include './koneksi.php';

$foto_id = $_GET['foto_id'];

$row = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM foto WHERE foto_id = $foto_id LIMIT 1"));
$komentar_query = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE foto_id = $foto_id");

function jumlah_like($foto_id)
{
    global $koneksi;
    $q = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah_like FROM like_foto WHERE foto_id = $foto_id");
    $row = mysqli_fetch_assoc($q);
    return $row['jumlah_like'];
}

function jumlah_komen($foto_id)
{
    global $koneksi;
    $r = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah_komen FROM komentar_foto WHERE foto_id = $foto_id");
    $row = mysqli_fetch_assoc($r);
    return $row['jumlah_komen'];
}

function nama_user($user_id)
{
    global $koneksi;
    $r = mysqli_query($koneksi, "SELECT * FROM user WHERE user_id = $user_id");
    $row = mysqli_fetch_assoc($r);
    return $row['username'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fotogram</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container"> <!-- Tambahkan container untuk penataan -->
        <a class="navbar-brand mr-auto" href="#">
            FOTOGRAM
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Home</a>
                </li>
                <?php if (!empty($_SESSION['user'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./insert.php">Create</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php">Logout</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div> <!-- Tutup container -->
</nav>
<div class="card2" style="display: flex; flex-direction: column; gap: 25px;  ">
<div class="card" style="display: flex; flex-direction: column; border: 3px solid black; padding: 16px; border-radius: 20px; max-width: 400px; margin: 0 auto; margin-top: 20px;">
            <h1>
            <a  href="./user.php?user_id=<?= $row['user_id'] ?>" class="text">
                        <?= nama_user($row['user_id']) ?>
                    </a>
            </h1>
            <img src="./foto/<?= $row['lokasi_file'] ?>" alt="" width="" style="100%">
            <div style="display: flex; align-items: center; gap: 20px;">
                <?php if (!empty($_SESSION['user'])) : ?>
                    <a class="text" href="./like.php?foto_id=<?= $row['foto_id'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
</svg> <?= jumlah_like($row['foto_id']) ?></a>
                    <a class="text" href="./detail-post.php?foto_id=<?= $row['foto_id'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-heart-fill" viewBox="0 0 16 16">
  <path d="M8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6-.097 1.016-.417 2.13-.771 2.966-.079.186.074.394.273.362 2.256-.37 3.597-.938 4.18-1.234A9 9 0 0 0 8 15m0-9.007c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132"/>
</svg> <?= jumlah_komen($row['foto_id']) ?></a>
                <?php else : ?>
                    <p>Like <?= jumlah_like($row['foto_id']) ?></p>
                    <a href="./detail-post.php?foto_id=<?= $row['foto_id'] ?>">Komen <?= jumlah_komen($row['foto_id']) ?></a>
                <?php endif; ?>
                <?php if (!empty($_SESSION['user'])) : ?>
                    <?php if ($_SESSION['user']['user_id'] == $row['user_id']) : ?>
                        <a href="./update.php?foto_id=<?= $row['foto_id'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
  <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z"/>
</svg></a>
                        <a onclick="return confirm('Yakin ingin menghapus?')" href="./delete.php?foto_id=<?= $row['foto_id'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
  <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
</svg></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <b><h2><?= $row['judul_foto'] ?></h2></b>
                <p><?= $row['deskripsi_foto'] ?></p>
                <p><?= $row['tanggal_unggah'] ?></p>
        </div>
        <form action="./create-komentar.php" method="post" style="display: flex; flex-direction: column; border: 3px solid black; padding: 16px; border-radius: 6px; max-width: 400px; margin: 0 auto; width: 100%;">
            <label for="isi_komentar">Komen</label>
            <input type="hidden" name="foto_id" value="<?= $row['foto_id'] ?>">
            <input type="text" name="isi_komentar" placeholder="">
            <br>
            <?php if (!empty($_SESSION['user'])) : ?>
                <button type="submit" name="submit">kirim</button>
            <?php else : ?>
                <button disabled>kirim</button>
                <p style="color: red; text-align: center">harus login terlebih dahulu!</p>
            <?php endif; ?>
        </form>
        <div style="display: flex; flex-direction: column; border: 3px solid black; padding: 16px; border-radius: 6px; max-width: 400px; margin: 0 auto; width: 100%; background: white;">
            <h1 style="text-align: center;">Komentar</h1>
            <?php while ($komentar = mysqli_fetch_assoc($komentar_query)) : ?>
                <div>
                    <h4><?= nama_user($komentar['user_id']) ?></h4>
                    <?= $komentar['tanggal_komentar'] ?>
                   
                    <p>
                        <?= $komentar['isi_komentar'] ?>
                    </p>
                    <p>
                       
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>