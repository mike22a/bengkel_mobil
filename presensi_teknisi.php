<?php

autentikasi();
aksesall();
koneksi_db();

// if ()
$dataPerPage = 5;

$nama_user = $_SESSION['nama'];

if (isset($_GET['page'])) {
  $noPage = $_GET['page'];
}else{
  $noPage = 1;
}

$cari = isset($_REQUEST['cari']) ? $_REQUEST['cari'] : '';

$nama_user = $_SESSION['nama'];
$akses_user = $_SESSION['akses'];

if ($akses_user == 'teknisi') {
  $cari = $nama_user;
}

$offset = ($noPage - 1) * $dataPerPage;
$query = mysqli_query($koneksi, "SELECT presensi_harian.*,user.nama,presensi_lembur.jam FROM $loc_presensi where nama like '%$cari%'  limit $offset,$dataPerPage");

if(mysqli_num_rows($query)==0) {
  echo "
  <script>
  alert('Data tidak ada');
  // window.location.href='dashboard.php';
  </script>
  ";
}

?>


<section class="wrapper">
 <h3><i class="fa fa-angle-right"></i> Data Presensi</h3>

 <div class="row mt">
  <div class="col-md-12">
    <div class="content-panel">      
      <table class="table table-striped table-advance table-hover">
       <h4><i class="fa fa-angle-right"></i> <?= $nama_user ?></h4>
       <hr>
       <thead>
        <tr>
          <th><i ></i>#</th>
          <th><i ></i> Nama Teknisi</th>
          <th><i ></i> Tanggal Masuk</th>
          <th><i ></i> Lemburan (jam)</th>
          <th><i ></i> Tool</th>
          <th><i ></i> Masuk</th>
          <th><i ></i> Edit</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=$offset+1;
        while ($result = mysqli_fetch_object($query)) {
          $query1 = mysqli_query($koneksi, "SELECT count(*) AS jml_tool,id_tools FROM cek_tools where id_harian='$result->id_harian'");
          $hasil1=mysqli_fetch_object($query1)->jml_tool;
          ?>
          <tr>
            <td><?= $i?></td>
            <td><?= $result->nama ?></td>
            <td><?= $result->tanggal ?></td>
            <td><?= $result->jam  ?></td>
            <!-- <td><a href="dashboard.php?tengah=tools_ubah&id=<?= $result->id_harian ?>"><?= $hasil1  ?></a></td> -->
            <td><?= $hasil1  ?></td>
            <td><?= $result->masuk  ?></td>
            <td>
              <a href="dashboard.php?tengah=presensi_ubah&id=<?= $result->id_harian ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
            </td>            
          </tr>
          <?php
        $i++; }
        ?>          
      </tbody>
    </table>
  </div><!-- /content-panel -->
</div><!-- /col-md-12 -->
</div><!-- /row -->



<?php
// $tengah = 'presensi_teknisi';
// $db = $loc_presensi;

// include 'pagination.php';
?>

<?php
$qcount = "SELECT count(*) AS jumData FROM $loc_presensi where nama like '%$cari%'"; 
$hasil = mysqli_query($koneksi,$qcount);
  //SELECT count (*) menghitung semua row yang ada pada tabel pengguna baik isi ataupun null
$data = mysqli_fetch_array($hasil);

  $jumData = $data['jumData']; //$data->jumData fetch object

  $jumPage = ceil($jumData / $dataPerPage);

  //link untuk previous tampilan
  echo "<ul class='pagination'>";
  if ($noPage > 1)
    echo " <li>
  <a href='" .$_SERVER['PHP_SELF'] . "?cari=" . $cari . "&tengah=presensi_teknisi&page=" . ($noPage - 1) .  "'>&lt;&lt; Prev</a></li>"
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
        echo "<li><a href = '" . $_SERVER['PHP_SELF'] . "?cari=" . $cari . "&tengah=presensi_teknisi&page=" . $page . "'>" . $page . "</a></li>";
      $showPage = $page;
    }
  }

  // tombol next  -_-
  if ($noPage < $jumPage)
    echo "<li>
  <a href='" . $_SERVER['PHP_SELF'] . "?cari" . $cari . "&tengah=presensi_teknisi&page=" . ($noPage + 1) . "'>Next &gt;&gt;</a></li>
  </ul>";
  ?>


</section>

