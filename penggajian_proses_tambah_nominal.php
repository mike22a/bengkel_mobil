<?php

//penambahan data butuh koneksi

session_start();
include "app.php";
autentikasi();
aksesowner();
aksesadmin();
koneksi_db();

$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : "";
$upah_harian = isset($_REQUEST['upah_harian']) ? $_REQUEST['upah_harian'] : "";
$upah_makan = isset($_REQUEST['upah_makan']) ? $_REQUEST['upah_makan'] : "";
$upah_lembur = isset($_REQUEST['upah_lembur']) ? $_REQUEST['upah_lembur'] : "";

// cari nama berdasarkan id
$tmp = mysqli_query($koneksi, "SELECT id_user from user where nama='$nama'");
$tmp2 = mysqli_fetch_object($tmp);

$query = mysqli_query($koneksi,"UPDATE user SET upah_harian='$upah_harian', upah_lembur='$upah_lembur', upah_makan='$upah_makan' WHERE id_user='$tmp2->id_user'");

//cek apakah berhasil disimpan apa tidak
if ($query) {
	echo "
	<script>
	alert('Data berhasil ditambahkan');
	window.location.href='dashboard.php?tengah=user_data';
	</script>
	";
}else{
	echo "
	<script>
	alert('Data gagal untuk disimpan');
	window.history.go(-1);
	</script>
	";
};