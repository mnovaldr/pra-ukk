<?php

$koneksi = mysqli_connect('localhost','root','','db_reservasi');
if (!$koneksi) {
    echo "Koneksi Gagal..";
}