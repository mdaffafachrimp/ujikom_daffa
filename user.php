<?php

session_start();
include './koneksi.php';

$user_id = $_GET['user_id'];

if (!isset($user_id)) {
    header('Location: index.php');
}

if (isset($_SESSION['user']) && $user_id === $_SESSION['user']['user_id']) {
    header('Location: profile.php');
}

$query_user = mysqli_query($koneksi, "SELECT * FROM user WHERE user_id = $user_id LIMIT 1");

$query_postingan = mysqli_query($koneksi, "SELECT * FROM foto WHERE user_id = $user_id ORDER BY user_id ASC");

$user = mysqli_fetch_assoc($query_user);


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
                    <a class="nav-link" href="./index.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
</svg></a>
                </li>
                <?php if (!empty($_SESSION['user'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./insert.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5"/>
  <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z"/>
</svg></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./profile.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
</svg></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
  <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
  <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z"/>
</svg></a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
  <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
</svg></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./register.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-heading" viewBox="0 0 16 16">
  <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
  <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z"/>
</svg></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div> <!-- Tutup container -->
</nav>

<div class="" style="display: flex; flex-direction: column; gap: 25px;  ">
    <div style="display: flex; flex-direction: column; padding: 16px; border-radius: 6px; max-width: 400px; margin: 0 auto; margin-top: 20px; margin-left: 500px;">
    <h1 style="text-align: left;"><svg xmlns="http://www.w3.org/2000/svg" width="100" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
</svg><?= $user['username'] ?></h1>
 
        <p><b><?= $user['nama_lengkap'] ?></b></p>
    </div>
</div>
<div class="" style="display: flex; flex-direction: column; gap: 25px;">
    <h2 style="text-align: center;">POSTINGAN</h2>
    <?php while ($row = mysqli_fetch_assoc($query_postingan)) : ?>
        <div style="display: flex; flex-direction: column; border: 3px solid black; padding: 16px; border-radius: 6px; max-width: 400px; margin: 0 auto; background: white; margin-top: 20px">
            <img src="./foto/<?= $row['lokasi_file'] ?>" alt="" width="" style="100%">
            <div style="display: flex; align-items: center; gap: 20px;">
            <?php if (!empty($_SESSION['user'])) : ?>
                        <a class="text" href="./like.php?foto_id=<?= $row['foto_id'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
</svg> <?= jumlah_like($row['foto_id']) ?></a>
                        <a class="text"href="./detail-post.php?foto_id=<?= $row['foto_id'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-heart-fill" viewBox="0 0 16 16">
  <path d="M8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6-.097 1.016-.417 2.13-.771 2.966-.079.186.074.394.273.362 2.256-.37 3.597-.938 4.18-1.234A9 9 0 0 0 8 15m0-9.007c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132"/>
</svg> <?= jumlah_komen($row['foto_id']) ?></a>
                    <?php else : ?>
                       
                  
                    <?php endif; ?>
                      </div>
                    <h1><?= $row['judul_foto'] ?></h1>
                    <p><?= $row['deskripsi_foto'] ?></p>
                    <p><?= $row['tanggal_unggah'] ?></p>
        </div>
                    <?php if (!empty($_SESSION['user'])) : ?>
                        <?php if ($_SESSION['user']['user_id'] == $row['user_id']) : ?>
                            <a href="./update.php?foto_id=<?= $row['foto_id'] ?>">Update</a>
                            <a onclick="return confirm('Yakin ingin menghapus?')" href="./delete.php?foto_id=<?= $row['foto_id'] ?>">Delete</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
    <?php endwhile; ?>
</div>

</html>