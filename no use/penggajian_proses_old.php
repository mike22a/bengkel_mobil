<?php

session_start();
include "app.php";
autentikasi();
koneksi_db();
aksesadmin();

// $id_gaji = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : "";
$mulai = isset($_REQUEST['mulai']) ? $_REQUEST['mulai'] : "";
$selesai = isset($_REQUEST['selesai']) ? $_REQUEST['selesai'] : "";
$tanggal_gaji = isset($_REQUEST['tgl']) ? $_REQUEST['tgl'] : "";

// echo "$tanggal_gaji";
// exit;

// cari id berdasarkan nama
$tmp = mysqli_query($koneksi, "SELECT id_user from user where nama='$nama'");
$nama_id = mysqli_fetch_object($tmp)->id_user;

echo $nama_id . " " . $selesai . " "  ;

// cari jumlah hari masuk dan jam lembur
$jml_masuk_lembur = mysqli_query($koneksi, "SELECT user.nama,  COUNT(presensi_harian.masuk) as masuk, SUM(presensi_lembur.jam) as jam FROM `user` left JOIN presensi_harian on user.id_user=presensi_harian.id_user left join presensi_lembur on presensi_harian.id_harian=presensi_lembur.id_harian where user.id_user='$nama_id'");
$tmp2 = mysqli_fetch_object($jml_masuk_lembur);

print_r($tmp2);

// cari jumlah tools total
$jml_tools = mysqli_query($koneksi, "SELECT user.nama, SUM(cek_tools.id_tools) as tools FROM `user` left JOIN presensi_harian on user.id_user=presensi_harian.id_user LEFT JOIN cek_tools ON presensi_harian.id_harian=cek_tools.id_harian where user.id_user='$nama_id'");
$tmp3 = mysqli_fetch_object($jml_tools)->tools;	

print_r($tmp3);

// exit;

$upah = mysqli_query($koneksi, "SELECT upah_harian,upah_lembur, upah_makan FROM `user` ");
$tmp4 = mysqli_fetch_object($upah);

$k1 = $upah->upah_harian*$tmp2->masuk; 
$k2 = $upah->upah_makan*$tmp2->masuk;
$k3 = $upah->upah_lembur*$tmp2->jam ;

$query = mysqli_query($koneksi, "INSERT INTO penggajian values ('','$nama_id', '$mulai','$selesai','$tanggal_gaji','','','$tmp2->jam','$tmp3','$tmp2->masuk','$k1','$k3','$k2')");

if ($query) {
// if (1) {
	echo "
	<script>
	alert('Data berhasil diupdate');
	window.location.href='dashboard.php?tengah=penggajian_data_new';
	</script>
	";
}else{
	echo "
	<script>
	alert('Data gagal untuk diupdate');
	// window.history.go(-1);
	</script>
	";
};

// echo "query selalu bernilai 1";
