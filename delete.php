<?php

$foto_id = $_GET["foto_id"];

include './koneksi.php';

mysqli_query($koneksi, "DELETE FROM foto WHERE foto_id = $foto_id");

header('Location: ' . $_SERVER['HTTP_REFERER']);
