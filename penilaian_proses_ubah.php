<?php

session_start();
include "app.php";
autentikasi();
koneksi_db();
aksesadmin();

$id_workorder = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
$penilaian = isset($_REQUEST['penilaian']) ? $_REQUEST['penilaian'] : "";

$query = mysqli_query($koneksi, "UPDATE workorder SET penilaian='$penilaian' WHERE id_workorder='$id_workorder'");

if ($query) {
	echo "
		<script>
			alert('Data berhasil diupdate');
			window.location.href='dashboard.php?tengah=workorder_data';
		</script>
	";
}else{
	echo "
		<script>
			alert('Data gagal untuk diupdate');
			// window.location.href='dashboard.php?tengah=workorder_data';
			window.history.go(-1);
		</script>
	";
};

// echo "query selalu bernilai 1";
