<?php

$tanggal = date("Y-m-d");
$hari = $diff->d - $merah;

// $tmpHari = $hari;

// for ($i=0; $i < $tmpHari; $i++) { 
// 	if (condition) {
// 		$hari -= $hari;
// 	}
// }

// $date1=date_create("$masuk");
// $date2=date_create("$selesai");
// $diff=date_diff($date1,$date2);

// bobot masing-masing
$bobot_tools = 0.05;
$bobot_customer = 0.35;
$bobot_presensi = 0.4;
$bobot_pengetahuan = 0.1;
$bobot_durasi = 0.1;

// nilai max min
$tools_min = 30;
$tools_max = 100;
$customer_min = 0;
$customer_max = 100;
$presensi_min = 0;
$presensi_max = 100;
$pengetahuan_min = 5;
$pengetahuan_max = 100;
$durasi_min = 0;
$durasi_max = 100;

// $tmp1 = ;
// $tmp2 = ;
// $tmp3 = ;
// $tmp4 = ;
// $tmp5 = ;

// penilaian awal
// rumus
function rumus($var,$min,$max){
	return 100*($var - $min)/($max - $min);
}

// tools
$query1 = mysqli_query($koneksi, "SELECT COUNT(*) as tools FROM user LEFT JOIN presensi_harian ON user.id_user=presensi_harian.id_user LEFT JOIN cek_tools on presensi_harian.id_harian=cek_tools.id_harian WHERE user.id_user='5' AND presensi_harian.masuk='ya' AND presensi_harian.tanggal BETWEEN '$mulai' AND '$selesai'");
$tmp1 = mysqli_fetch_object($query1)->tools;
if ($hari == 0) {
	$tools = 0;
}else{
	$tools = $tmp1/($hari*5);
}
// tools akhir
if ($tools <= '0.30' && $tools >= '0') {
	$tools2 = $tools_min;
}elseif ($tools <= '0.60' && $tools > '0.30') {
	$tools2 = 60;
}else {
	$tools2 = $tools_max;
}
$hasil_tools = rumus($tools2,$tools_min,$tools_max);

// exit;

// customer
$query21 = mysqli_query($koneksi, "SELECT * FROM presensi_harian INNER JOIN workorder ON presensi_harian.id_user=workorder.id_user WHERE presensi_harian.id_user='$nama_id'AND masuk='ya'  AND presensi_harian.tanggal=workorder.tanggal");
$cst=0;
$i=0;
while ($tmp2 = mysqli_fetch_object($query21)) {
	// switch ($tmp2->penilaian) {
	// 	case 'Kurang Puas':
	// 	$cst += $customer_min;
	// 	echo "1";
	// 	break;
	// 	case ' Puas':
	// 	$cst += 50;
	// 	echo "2";	
	// 	break;
	// 	case 'Sangat Puas':
	// 	$cst += $customer_max;
	// 	echo "3";	
	// 	break;
	// }
	// customer
	$customer = $tmp2->penilaian;
	// echo "$customer";
	if ($customer == 'Kurang Puas' ) {
		$cst += $customer_min;
	}elseif ($customer == 'Puas') {
		$cst += 50;
	}elseif ($customer == 'Sangat Puas') {
		$cst += $customer_max;
	}

	$i+=1;
}
// print_r(mysqli_fetch_object($query21));
if ($i == 0) {
	$rata_rata = 0;
}else{
	$rata_rata = $cst/$i;
}
$hasil_customer = rumus($rata_rata,$customer_min,$customer_max);


// presensi
if ($hari == 0) {
	$presensi = 0;
}else{
	$presensi = $masuk/$hari;
}
// presensi akhir
if ($presensi < '0.8' && $presensi >= '0') {
	$presensi2 = $presensi_min;
}elseif ($presensi < '1' && $presensi >= '0.8') {
	$presensi2 = 60;
// }elseif ($presensi == '1') {
}else{
	$presensi2 = $presensi_max;
}
// echo "$presensi";

$hasil_presensi = rumus($presensi2,$presensi_min,$presensi_max);


// query untuk pengetahuan dan durasi
$query3 = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$nama_id'");
$tmp4 = mysqli_fetch_object($query3);

// pengetahuan
$pengetahuan = $tmp4->pengetahuan_dasar;
// pengetahuan akhir
switch ($pengetahuan) {
	case '1':
	$pengetahuan2 = $pengetahuan_min;
	break;
	case '2':
	$pengetahuan2 = 15;
	break;
	case '3':
	$pengetahuan2 = 20;
	break;
	case '4':
	$pengetahuan2 = 40;
	break;
	case '5':
	$pengetahuan2 = $pengetahuan_max;
	break;
	
	default:
	$pengetahuan2 = 5;
	break;
}
$hasil_pengetahuan = rumus($pengetahuan2,$pengetahuan_min,$pengetahuan_max);


// durasi
$date3 = date_create($tmp4->tanggal_join);
$date4 = date_create($tanggal);
$durasi = date_diff($date3,$date4)->d/365 ;
// durasi
if ($durasi <= '1' && $durasi >= '0') {
	$durasi2 = $durasi_min;
}elseif ($durasi <= '3' && $durasi > '1') {
	$durasi2 = 50;
}elseif ($durasi <= '5' && $durasi > '3') {
	$durasi2 = 75;
}elseif ($durasi > '5') {
	$durasi2 = $durasi_max;
}
$hasil_durasi = rumus($durasi2,$durasi_min,$durasi_max);


// penilaian akhir

// customer
// if ($customer == 'Kurang Puas' ) {
// 	$customer2 = $customer_min;
// }elseif ($customer == 'Puas') {
// 	$customer2 = 50;
// }elseif ($customer == 'Sangat Puas') {
// 	$customer2 = $customer_max;
// }

$hasil_total = $bobot_presensi*$hasil_presensi + $bobot_tools*$hasil_tools + $bobot_customer*$hasil_customer + 
$bobot_pengetahuan*$hasil_pengetahuan + 
$bobot_durasi*$hasil_durasi ;

// echo $hasil_total;

$query4 = mysqli_query($koneksi, "SELECT * FROM bobot_gaji WHERE dari <= '$hasil_total' AND sampai >= '$hasil_total'");
// print_r(mysqli_fetch_object($query4));


$bonus =  mysqli_fetch_object($query4)->besaran_gaji;
// echo "$bonus";
// $bonus= 100000;
// penilaian akhir (rumus smart)
?>