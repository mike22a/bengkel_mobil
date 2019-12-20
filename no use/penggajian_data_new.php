<?php

autentikasi();
aksesall();
koneksi_db();

// if ()
$bonus = 1000000;
$tgl = date("Y-m-d");


$dataPerPage = 5;

if (isset($_GET['page'])) {
	$noPage = $_GET['page'];
}else{
	$noPage = 1;
}

$mulai = isset($_REQUEST['mulai']) ? $_REQUEST['mulai'] : ''; 
$selesai = isset($_REQUEST['selesai']) ? $_REQUEST['selesai'] : '';


$offset = ($noPage - 1) * $dataPerPage;
//membuat variabel cari
$cari = isset($_REQUEST['cari']) ? $_REQUEST['cari'] : '';

$query = mysqli_query($koneksi, "SELECT * FROM $loc_penggajian where nama='$cari'");

// $date = '2019-12-08';

$date1=date_create("$mulai");
$date2=date_create("$selesai");

$diff = hitunghari($date1,$date2);
// echo $diff->format('%a');
// exit;

$query2 = mysqli_query($koneksi, "SELECT * FROM $loc_penggajian");
?>



<section class="wrapper">
	<h3><i class="fa fa-angle-right"></i> Data Gaji</h3>

	<div class="row mt">
		<div class="col-md-12">
			<div class="content-panel">
      <!-- <form method="post" action="dashboard.php?tengah=data_user">
        <div class="col-lg-6 pull-right">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" aria-hidden="true" type="submit" name="tampil1" value=1>1</button>
              <button class="btn btn-default" aria-hidden="true" type="submit" name="tampil2" value=2>2</button>
            </span>
          </div>
        </div>
    </form> -->
    <!-- <form method="post" action="penggajian_proses.php"> -->
    <a href="dashboard.php?tengah=penggajian_filter"  ><button aria-hidden="true">Tambah Gaji</button></a>
    <form method="post" action="dashboard.php?tengah=penggajian_data_new">
    	<div class="col-lg-6 pull-right">
    		<div class="input-group">
    			<!-- <input name="cari" type="text" class="form-control" placeholder="Cari nama...">           -->
          <span class="input-group-btn"></span>
    			<select name="cari" class="form-control" >
    				<?php
    				while ($result = mysqli_fetch_object($query2)) {
    					echo '
    					<option value="' . $result->nama . '">' . $result->nama . '</option>';  
    				}
    				?>
    			</select>
    			<span class="input-group-btn"></span>
    			<input name="mulai" type="date" class="form-control" placeholder="Tanggal Masuk">
    			<span class="input-group-btn"></span>
    			<input name="selesai" type="date" class="form-control" placeholder="Tanggal Selesai">
    			<span class="input-group-btn"></span>
    			<span class="input-group-btn">
    				<button class="btn btn-default glyphicon glyphicon-search" aria-hidden="true" type="submit"></button>
    			</span>
    		</div>
    	</div>
    </form>
    <table class="table table-striped table-advance table-hover">
    	<h4><i class="fa fa-angle-right"></i>
    		<?= $cari ?>
    	</h4>
    	<hr>
    	<thead>
    		<tr>
    			<th>#</th>
    			<th class="hidden-phone"><i class="fa fa-archive"></i> Nama</th>
    			<th><i class="fa fa-user"></i> Tanggal </th>
    			<th><i class="fa fa-user"></i> Harian</th>
    			<th><i class=" fa fa-phone"></i> Lemburan</th>
    			<th><i class=" fa fa-key"></i> Bonus</th>
    			<th><i class=" fa fa-key"></i> Total</th>
    			<th><i class=" fa fa-key"></i> Aksi</th>
    			<!-- <th><a href="dashboard.php?tengah=penggajian_tambah" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></a></th> -->
    			<!-- kolom edit -->
    		</tr>
    	</thead>
    	<tbody>
    		<?php $i=$offset+1; $p = 1; $total=0;
    		while ($result = mysqli_fetch_object($query)) {
          // $total  = $result->gaji_harian*$result->harian + $result->gaji_lembur*$result->lembur + $result->gaji_bonus*$result->bonus;
    			if ($p != $result->nama) {
            # code...
    			}
    			$total  = $result->upah_harian*$result->jumlah_masuk + $result->upah_makan*$result->jumlah_masuk + $result->upah_lembur*$result->jam_lembur + $bonus;

          // jumlah masuk, jam lembur, 
          // tanggal mulai, tanggal selesai, tanggal penggajian

          // + $result->gaji_bonus;
    			?>
    			<tr>
    				<td><a href="basic_table.html#"><?= $i ?></a></td>
    				<td><?= $result->nama ?></td>
    				<td><?= $result->jumlah_masuk  ?></td>
    				<td><?= $result->jam_lembur  ?></td>
    				<td><?= $bonus  ?></td>
    				<td><?= $total ?></td>
    				<td>
    					<a href="dashboard.php?tengah=penggajian_view&id=<?= $result->id_user ?>" class="btn btn-success btn-xs" ><i class="fa fa-user"></i></a>
    					<a href="dashboard.php?tengah=penggajian_ubah&id=<?= $result->id_user ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
    					<a href="penggajian_hapus.php?id=<?= $result->id_user ?>" class="btn btn-danger btn-xs" ><i class="fa fa-trash-o"></i></a>
    				</td>
    			</tr>
    			<?php 
    			$i++;}
    			?>
    		</tbody>
    	</table>
    </div><!-- /content-panel -->
</div><!-- /col-md-12 -->
</div><!-- /row -->
<!-- <div>
 <div class="input-group">
  <form class="form-horizontal style-form" method="post" action="penggajian_rekap.php">
   <input name="nama" type="hidden" class="form-control" value="<?= $cari ?>">
   <input name="mulai" type="hidden" class="form-control" value="<?= $mulai ?>">
   <input name="selesai" type="hidden" class="form-control" value="<?= $selesai ?>">
   <input name="tgl" type="hidden" class="form-control" value="<?= $tgl ?>">
   <button aria-hidden="true" type="submit">Gaji</button>          
 </form>
</div>
</div> -->



<?php
$qcount = "SELECT count(*) AS jumData FROM $loc_penggajian where nama like '%$cari%'"; 
$hasil = mysqli_query($koneksi,$qcount);
  //SELECT count (*) menghitung semua row yang ada pada tabel pengguna baik isi ataupun null
$data = mysqli_fetch_array($hasil);

  $jumData = $data['jumData']; //$data->jumData fetch object

  $jumPage = ceil($jumData / $dataPerPage);

  //link untuk previous tampilan
  echo "<ul class='pagination'>";
  if ($noPage > 1)
  	echo " <li>
  <a href='" .$_SERVER['PHP_SELF'] . "?cari=" . $cari . "&tengah=penggajian_data_new&page=" . ($noPage - 1) .  "'>&lt;&lt; Prev</a></li>"
  ;

  //menambah nomor dan link halaman
  //penggunaan -3 dan +3 untuk membatasi posisi kiri maks 3 page dan kanan maks 3 page
  for ($page = 1; $page <= $jumPage; $page++) {
  	if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page ==  $jumPage)) {
  		if ((@$showPage == 1) && ($page != 2))
  			echo "<li><a href= '#'>...</a></li>";
  		if ((@$showPage != ($jumPage-1)) && ($page == $jumPage))
  			echo "<li><a href = '#'>...</a></li>";
  		if ($page == $noPage)
        echo "<li class='active'><a href = '#'>". $page . "</a></li>"; //membuat class active jika page = halaman yang terbuka
    else
    	echo "<li><a href = '" . $_SERVER['PHP_SELF'] . "?cari=" . $cari . "&tengah=penggajian_data_new&page=" . $page . "'>" . $page . "</a></li>";
    $showPage = $page;
}
}

  // tombol next  -_-
if ($noPage < $jumPage)
	echo "<li>
<a href='" . $_SERVER['PHP_SELF'] . "?cari" . $cari . "&tengah=penggajian_data_new&page=" . ($noPage + 1) . "'>Next &gt;&gt;</a></li>
</ul>";
?>




</section><! --/wrapper -->

<!-- <script>
  function alert_box() {
    if (confirm("Apakah Anda yakin akan menghapus data?")) {
      window.location.href="hapus.php?id=<?= $result->id_pengguna ?>";
    }else{

    };
  }
</script> -->