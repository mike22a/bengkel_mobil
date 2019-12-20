<?php

session_start();
include "app.php";
autentikasi();
koneksi_db();
aksesall();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";  // id harian
$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : "";
$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : "";
$tool = isset($_REQUEST['tool']) ? $_REQUEST['tool'] : "";

// update data ke cek tools
$query3 = mysqli_query($koneksi, "DELETE FROM cek_tools WHERE id_harian=$id ");
$k=0;
while ($k < count($tool)) {	
	$query4 = mysqli_query($koneksi, "INSERT INTO cek_tools values ('', '$id' , '$tool[$k]')");
	// echo "$tool[$k]";
	$k++;
}

if ($query3) {
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