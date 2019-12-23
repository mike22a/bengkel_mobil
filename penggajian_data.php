<?php

autentikasi();
aksesall();
koneksi_db();

// if ()
// $bonus = 1000000;
$tgl = date("Y-m-d");


$dataPerPage = 5;

if (isset($_GET['page'])) {
  $noPage = $_GET['page'];
}else{
  $noPage = 1;
}

// $id_user = isset($_REQUEST['id_user']) ? $_REQUEST['id_user'] : '';
$mulai = isset($_REQUEST['mulai']) ? $_REQUEST['mulai'] : ''; 
$selesai = isset($_REQUEST['selesai']) ? $_REQUEST['selesai'] : '';
$cari = isset($_REQUEST['cari']) ? $_REQUEST['cari'] : '';
$nilai = isset($_REQUEST['nilai']) ? $_REQUEST['nilai'] : '';


// echo "$cari";
// exit;

$nama_user = $_SESSION['nama'];
$akses_user = $_SESSION['akses'];

if ($akses_user == 'teknisi') {
  $cari = $nama_user;
}

$offset = ($noPage - 1) * $dataPerPage;

// cari nama berdasarkan id
if ($cari == '') {
  $tmp = mysqli_query($koneksi, "SELECT id_user from user where nama like '% %'");
  // $id_user = mysqli_fetch_object($tmp);
  // $id_user='';
// }elseif ($cari == 'semua') {
//   $tmp = mysqli_query($koneksi, "SELECT id_user from user where nama like '% %'");
//   $id_user = mysqli_fetch_object($tmp)->id_user;
//   print_r(mysqli_fetch_object($tmp));
}else{
  $tmp = mysqli_query($koneksi, "SELECT id_user from user where nama like '$cari'");
  // $id_user = mysqli_fetch_object($tmp);
  // print_r(mysqli_fetch_object($tmp));
}

// print_r($id_user->id_user);
// exit;


// print_r(mysqli_fetch_object($query4));
// exit;


$query5 = mysqli_query($koneksi, "SELECT distinct user.nama,user.id_user FROM penggajian left JOIN user ON penggajian.id_user=user.id_user");

?>



<section class="wrapper">
  <h3><i class="fa fa-angle-right"></i> Data Gaji</h3>

  <div class="row mt">
    <div class="col-md-12">
      <div class="content-panel">  
        <?php 
        if(($_SESSION['akses'] == 'admin') || ($_SESSION['akses'] == 'owner')) {
          echo '
          <a href="dashboard.php?tengah=penggajian_filter"  ><button aria-hidden="true">Tambah Gaji</button></a>
          ';
          // <a href="dashboard.php?tengah=tanggal_merah"  ><button aria-hidden="true">Data Tanggal Merah</button></a>
        }
        ?>
        <form method="post" action="dashboard.php?tengah=penggajian_data">
          <div class="col-lg-6 pull-right">
            <div class="input-group">
              <!-- <input name="cari" type="text" class="form-control" placeholder="Cari nama...">           -->
              <span class="input-group-btn"></span>
              <?php 
              if(($_SESSION['akses'] == 'admin') || ($_SESSION['akses'] == 'owner')) {
                echo '
                <select name="cari" class="form-control" >
                ';
                ?>    
                <?php
                while ($result = mysqli_fetch_object($query5)) {
                  echo '
                  <option value="' . $result->nama . '">' . $result->nama . '</option>';
                  // $k = $result->id_gaji; 
                  // <input name="id_user" type="hidden" value="' . $result->id_user . '">';
                }
              }
              ?>
              <!-- <option value="semua">Semua</option>;                 -->
            </select>
            <span class="input-group-btn">x</span>
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
          <?php
          if ($cari == '') {
            echo "Semua";
          }else{
           echo $cari;
         }

         ?>
         <?php
         if ($mulai != '' AND $selesai != '') {
          echo "Periode ( " . $mulai . " - " . $selesai . " )" ;
        }
        ?>
      </h4>
      <hr>
      <thead>
        <tr>
          <th>#</th>
          <th> Nama</th>
          <th> Tanggal </th>
          <th> Upah Harian</th>
          <th> Upah Makan</th>
          <th> Upah Lembur</th>
          <th> Bonus</th>
          <th> Total</th>
          <!-- <th><i class=" fa fa-key"></i> Aksi</th> -->
          <!-- <th><a href="dashboard.php?tengah=penggajian_tambah" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></a></th> -->
          <th></th>
          <!-- kolom edit -->
        </tr>
      </thead>
      <tbody>
        <?php $i=$offset+1; $p = 1; $total=0;
        while($id_user = mysqli_fetch_object($tmp)){

          if ($mulai != '' AND $selesai != '') {
            $query4 = mysqli_query($koneksi, "SELECT penggajian.*,user.* FROM penggajian left join user on penggajian.id_user=user.id_user where user.id_user='$id_user->id_user' AND (tanggal_mulai between '$mulai' AND '$selesai' OR tanggal_selesai between '$mulai' AND '$selesai')");
          }elseif ($mulai == '' AND $selesai != '') {
            $query4 = mysqli_query($koneksi, "SELECT penggajian.*,user.* FROM penggajian left join user on penggajian.id_user=user.id_user where user.id_user='$id_user->id_user' AND (tanggal_mulai between '0000-00-00' AND '$selesai' OR tanggal_selesai between '0000-00-00' AND '$selesai')");
          }elseif ($mulai != '' AND $selesai == '') {
            $query4 = mysqli_query($koneksi, "SELECT penggajian.*,user.* FROM penggajian left join user on penggajian.id_user=user.id_user where user.id_user='$id_user->id_user' AND (tanggal_mulai between '$mulai' AND '2050-01-01' OR tanggal_selesai between '$mulai' AND '2050-01-01')");
          }else{
            $query4 = mysqli_query($koneksi, "SELECT penggajian.*,user.* FROM penggajian left join user on penggajian.id_user=user.id_user where user.id_user='$id_user->id_user'");  
          }
          while ($result = mysqli_fetch_object($query4)) {
          // $total  = $result->gaji_harian*$result->harian + $result->gaji_lembur*$result->lembur + $result->gaji_bonus*$result->bonus;
            // if ($p != $result->nama) {
            # code...
            // }
            // $total  = $result->upah_harian*$result->jumlah_masuk + $result->upah_makan*$result->jumlah_masuk + $result->upah_lembur*$result->jam_lembur + $bonus;
            $total = $result->bobot_akhir;
            
          // jumlah masuk, jam lembur, 
          // tanggal mulai, tanggal selesai, tanggal penggajian

          // + $result->gaji_bonus;
            ?>
            <tr>
              <td><a href="basic_table.html#"><?= $i ?></a></td>
              <td><?= $result->nama ?></td>
              <td><?= ($result->tanggal_penggajian)  ?></td>              
              <td><?= rupiah($result->rekap_upah_harian)  ?></td>              
              <td><?= rupiah($result->rekap_upah_makan)  ?></td>              
              <td><?= rupiah($result->rekap_upah_lembur)  ?></td>              
              <!-- <td><?= $result->jam_lembur  ?></td> -->
              <td><?= rupiah($result->nominal_tambahan)  ?></td>
              <td><?= rupiah($total) ?></td>            
              <td>
                <a href="dashboard.php?tengah=penggajian_detail&id_gaji=<?= $result->id_gaji ?>" class="btn btn-success btn-xs" ><i class="fa fa-user"></i></a>
                <?php
                if (($_SESSION['akses'] != 'teknisi')) {
                  echo '
                  <a href="penggajian_hapus.php?id=' . $result->id_gaji . '" class="btn btn-danger btn-xs" ><i class="fa fa-trash-o"></i></a>
                  ';
                }
                ?>
              </td>
            </tr>
            <?php 
            $i++;
          }
        }
        ?>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td><button class="btn btn-default" aria-hidden="true"><a href="dashboard.php?tengah=penggajian_data&cari= ">Show All</a></button></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
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
  <a href='" .$_SERVER['PHP_SELF'] . "?cari=" . $cari . "&tengah=penggajian_data&page=" . ($noPage - 1) .  "'>&lt;&lt; Prev</a></li>"
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
        echo "<li><a href = '" . $_SERVER['PHP_SELF'] . "?cari=" . $cari . "&tengah=penggajian_data&page=" . $page . "'>" . $page . "</a></li>";
      $showPage = $page;
    }
  }

  // tombol next  -_-
  if ($noPage < $jumPage)
    echo "<li>
  <a href='" . $_SERVER['PHP_SELF'] . "?cari=" . $cari . "&tengah=penggajian_data&page=" . ($noPage + 1) . "'>Next &gt;&gt;</a></li>
  </ul>";
  ?>


</section>
<! --/wrapper -->

<!-- <script>
  function alert_box() {
    if (confirm("Apakah Anda yakin akan menghapus data?")) {
      window.location.href="hapus.php?id=<?= $result->id_pengguna ?>";
    }else{

    };
  }
</script> -->