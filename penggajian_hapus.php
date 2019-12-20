<?php

session_start();
include 'app.php';
autentikasi();
koneksi_db();
aksesadmin();

$id_gaji = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";

// $tmpNama = "select nama_teknisi from penggajian where id_gaji = '$id_penggajian'"

$query = mysqli_query($koneksi, "DELETE FROM penggajian WHERE id_gaji='$id_gaji'");

if ($query) {
	echo "
		<script>
			alert('Data berhasil dihapus.');
			window.location.href='dashboard.php?tengah=penggajian_data';
		</script>
	";
}else{
	echo "
		<script>
			alert('Data gagal untuk dihapus.');
			window.history.go(-1);
		</script>
	";
};
