<?php

session_start();
include "app.php";
autentikasi();
koneksi_db();
aksesadmin();
// aksesowner();

// $id_gaji = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : "";
$mulai = isset($_REQUEST['mulai']) ? $_REQUEST['mulai'] : "";
$selesai = isset($_REQUEST['selesai']) ? $_REQUEST['selesai'] : "";
$tanggal_gaji = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : "";
$masuk = isset($_REQUEST['masuk']) ? $_REQUEST['masuk'] : "";
$lembur = isset($_REQUEST['lembur']) ? $_REQUEST['lembur'] : "";
$upah_harian = isset($_REQUEST['upah_harian']) ? $_REQUEST['upah_harian'] : "";
$upah_makan = isset($_REQUEST['upah_makan']) ? $_REQUEST['upah_makan'] : "";
$upah_lembur = isset($_REQUEST['upah_lembur']) ? $_REQUEST['upah_lembur'] : "";
$tools = isset($_REQUEST['tools']) ? $_REQUEST['tools'] : "";
$bonus = isset($_REQUEST['bonus']) ? $_REQUEST['bonus'] : "";

// rekap
$rekap_upah_harian = isset($_REQUEST['rekap_upah_harian']) ? $_REQUEST['rekap_upah_harian'] : "";
$rekap_upah_makan = isset($_REQUEST['rekap_upah_makan']) ? $_REQUEST['rekap_upah_makan'] : "";
$rekap_upah_lembur = isset($_REQUEST['rekap_upah_lembur']) ? $_REQUEST['rekap_upah_lembur'] : "";

$bobot_total = isset($_REQUEST['total']) ? $_REQUEST['total'] : "";

// cek apakah sudah pernah direkap sebelumnya
// $cek1 = mysqli_query($koneksi, "SELECT * FROM penggajian where tanggal_mulai <= '$mulai' and tanggal_selesai >= '$mulai' ");
// $cek2 = mysqli_query($koneksi, "SELECT * FROM penggajian where tanggal_mulai <= '$selesai' and tanggal_selesai >= '$selesai' ");
// print_r(mysqli_fetch_object($cek1));
// print_r($cek1);
// print_r($cek2);
// exit;
// if ($cek1 || $cek2) {
// $query = 0;
// }else{
// $query = mysqli_query($koneksi, "INSERT INTO penggajian values ('','$id', '$mulai','$selesai','$tanggal_gaji','$bonus','$bobot_total','$lembur','$tools','$masuk','$rekap_upah_lembur','$rekap_upah_harian','$rekap_upah_makan')");
// $query = 1;

// }


if ($query) {
	echo "
	<script>
	alert('Data berhasil diupdate');
	window.location.href='dashboard.php?tengah=penggajian_data';
	</script>
	";
}else{
	echo "
	<script>
	alert('Data gagal untuk diupdate');
	window.history.go(-1);
	</script>
	";
};

// echo "query selalu bernilai 1";
