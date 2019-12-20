<?php

session_start();
include "app.php";
autentikasi();
koneksi_db();
aksesall();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";  // id harian
$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : "";
$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : "";
$lembur = isset($_REQUEST['lembur']) ? $_REQUEST['lembur'] : "";

$query = mysqli_query($koneksi, "UPDATE presensi_lembur set jam='$lembur' WHERE id_harian='$id' ");


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
