<?php

session_start();
include "app.php";
autentikasi();
koneksi_db();
aksesall();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";  // id harian
$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : "";
$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : "";
$presensi = isset($_REQUEST['presensi']) ? $_REQUEST['presensi'] : "";

$query = mysqli_query($koneksi, "UPDATE presensi_harian set masuk='$presensi' WHERE id_harian='$id' ");

$tmp = mysqli_fetch_object(mysqli_query($koneksi, "SELECT masuk from presensi_harian WHERE id_harian='$id' "))->masuk;

// jika masuk = ya input lembur dan tools
if ($tmp == 'ya') {
	$query2 = mysqli_query($koneksi, "INSERT INTO presensi_lembur values ('','$id','0')");
	$query2 = mysqli_query($koneksi, "INSERT INTO cek_tools values ('','$id','1')");
}elseif ($tmp == 'tidak') {
	$query2 = mysqli_query($koneksi, "DELETE FROM presensi_lembur WHERE id_harian='$id'");
	$query2 = mysqli_query($koneksi, "DELETE FROM cek_tools WHERE id_harian='$id'");
}

if ($query) {
	echo "
	<script>
	alert('Data berhasil diupdate');
			// window.location.href='dashboard.php?tengah=tools_data';
	window.history.go(-2);
	</script>
	";
}else{
	echo "
	<script>
	alert('Data gagal untuk diupdate');
			// window.location.href='dashboard.php?tengah=tools_data';
	window.history.go(-1);
	</script>
	";
};

// echo "query selalu bernilai 1";
