<?php

autentikasi();
aksesall();
koneksi_db();

// if ()
$dataPerPage = 5;

if (isset($_GET['page'])) {
  $noPage = $_GET['page'];
}else{
  $noPage = 1;
}

$nama_user = $_SESSION['nama'];
$akses_user = $_SESSION['akses'];

// $noPage = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($noPage - 1) * $dataPerPage;
//membuat variabel cari
$cari = isset($_REQUEST['cari']) ? $_REQUEST['cari'] : '';


if ($akses_user == 'teknisi') {
  $cari = $nama_user;
}

// echo $cari . " " . $nama_user ;
// exit;

$query = mysqli_query($koneksi, "SELECT workorder.*,user.nama FROM $loc_workorder WHERE nama like '%$cari%' limit $offset,$dataPerPage");
// $result = mysqli_fetch_object($query);

// print_r($query);
// print_r($result);
// exit;

if(mysqli_num_rows($query)==0) {
  echo "
  <script>
  alert('Data tidak ada');
  // window.location.href='dashboard.php?tengah=workorder_data';
  </script>
  ";
}

?>


<section class="wrapper">
 <h3><i class="fa fa-angle-right"></i> Data Workorder</h3>

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
      <form method="post" action="dashboard.php?tengah=data_user">
        <div class="col-lg-4 pull-right">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default glyphicon glyphicon-search" aria-hidden="true" type="submit"></button>
            </span>
            <input name="cari" type="text" class="form-control" placeholder="Cari nama pelanggan...">
          </div>
        </div>
      </form>
      <table class="table table-striped table-advance table-hover">
       <h4><i class="fa fa-angle-right"></i> Workorder</h4>
       <hr>
       <thead>
        <tr>
          <th>#</th>
          <th><i ></i> Tanggal</th>
          <th><i ></i> Pelanggan</th>
          <th><i ></i> Alamat</th>
          <th><i ></i> No. Telp</th>
          <th><i ></i>Kendaraan</th>
          <th><i ></i>Keluhan</th>
          <th><i ></i>Nama Teknisi</th>
          <th><i ></i>Penilaian</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=$offset+1; 
        while ($result = mysqli_fetch_object($query)) {
          ?>
          <tr>
            <td><a href="basic_table.html#"><?= $i ?></a></td>
            <td><?= $result->tanggal ?></td>
            <td><?= $result->nama_pelanggan ?></td>
            <td><?= $result->alamat  ?></td>
            <td><?= $result->no_telp  ?></td>
            <td><?= $result->kendaraan  ?></td>
            <td><?= $result->keluhan  ?></td>
            <td><?= $result->nama  ?></td>            
            <td><?= $result->penilaian  ?></td>
          </tr>
          <?php
        $i++;
        }
        ?>          
      </tbody>
    </table>
  </div><!-- /content-panel -->
</div><!-- /col-md-12 -->
</div><!-- /row -->


<?php
// $tengah = 'workorder_teknisi';
// $db = $loc_workorder;

// include 'pagination.php';
?>

<?php
  $qcount = "SELECT count(*) AS jumData FROM $loc_workorder where nama_pelanggan like '%$cari%'"; 
  $hasil = mysqli_query($koneksi,$qcount);
  //SELECT count (*) menghitung semua row yang ada pada tabel pengguna baik isi ataupun null
  $data = mysqli_fetch_array($hasil);

  $jumData = $data['jumData']; //$data->jumData fetch object

  $jumPage = ceil($jumData / $dataPerPage);

  //link untuk previous tampilan
  echo "<ul class='pagination'>";
  if ($noPage > 1)
    echo " <li>
                <a href='" .$_SERVER['PHP_SELF'] . "?cari=" . $cari . "&tengah=workorder_teknisi&page=" . ($noPage - 1) .  "'>&lt;&lt; Prev</a></li>"
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
        echo "<li><a href = '" . $_SERVER['PHP_SELF'] . "?cari=" . $cari . "&tengah=workorder_teknisi&page=" . $page . "'>" . $page . "</a></li>";
      $showPage = $page;
    }
  }

  // tombol next  -_-
  if ($noPage < $jumPage)
    echo "<li>
              <a href='" . $_SERVER['PHP_SELF'] . "?cari=" . $cari . "&tengah=workorder_teknisi&page=" . ($noPage + 1) . "'>Next &gt;&gt;</a></li>
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
