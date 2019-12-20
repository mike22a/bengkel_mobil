<?php

session_start();
include "app.php";
autentikasi();
koneksi_db();
aksesteknisi();
aksesadmin();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : "";
$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : "";
$lembur = isset($_REQUEST['lembur']) ? $_REQUEST['lembur'] : "";
$tool = isset($_REQUEST['tool']) ? $_REQUEST['tool'] : "";
$presensi = isset($_REQUEST['presensi']) ? $_REQUEST['presensi'] : "";

// cari nama berdasarkan id
$tmp = mysqli_query($koneksi, "SELECT id_user from user where nama='$nama'");
$tmp2 = mysqli_fetch_object($tmp);

// echo $presensi. " " . $id . " " . $tool[1] . " " . $tmp2->id_user . " " . $id . " " . $tanggal;
// exit;

// echo $lembur . " " . $id ;

// exit;
// update data ke presensi harian
$query = mysqli_query($koneksi, "UPDATE presensi_harian set id_user='$tmp2->id_user', tanggal='$tanggal', masuk='$presensi' WHERE id_harian='$id' ");
$cek_id = mysqli_fetch_object( mysqli_query($koneksi, "SELECT * FROM presensi_lembur WHERE id_harian = '$id'" ))->id_harian;
// print_r($cek_id);
// update data ke presensi lembur

// if ( $cek_id == $id) {
// 	$query2 = mysqli_query($koneksi, "UPDATE presensi_lembur set id_harian='$id' , jam = '$lembur' ");
// 	echo "true";
// }else{
// 	echo "false";
// }
$query2a = mysqli_query($koneksi, "DELETE FROM presensi_lembur WHERE id_harian='$id' ");
$query2 = mysqli_query($koneksi, "INSERT INTO presensi_lembur values ('', '$id' ,'$lembur')");


// update data ke cek tools
$query3 = mysqli_query($koneksi, "DELETE FROM cek_tools WHERE id_harian=$id ");
$k=0;
if (count($tool) > 0) {	
	while ($k < count($tool)) {	
		$query4 = mysqli_query($koneksi, "INSERT INTO cek_tools values ('', '$id' , '$tool[$k]')");
		$k++;
	}
}else{
	$query4=1;
}

	// echo "$tool[$k]";

// print_r($query);
// print_r($query2);
// print_r($query3);
// print_r($query4);
// exit;

if ($query AND $query2 AND $query3 AND $query4) {
	echo "
	<script>
	alert('Data berhasil diupdate');
	window.location.href='dashboard.php?tengah=presensi_data';
	</script>
	";
}else{
	echo "
	<script>
	alert('Data gagal untuk diupdate');
			// window.location.href='dashboard.php?tengah=presensi_data';
	window.history.go(-1);
	</script>
	";
};

// echo "query selalu bernilai 1";
