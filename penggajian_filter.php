<?php

autentikasi();
aksesadmin();
// aksesowner();
koneksi_db();

// if ()
$dataPerPage = 5;

if (isset($_GET['page'])) {
  $noPage = $_GET['page'];
}else{
  $noPage = 1;
}
$offset = ($noPage - 1) * $dataPerPage;

// $query = mysqli_query($koneksi, "SELECT * FROM penggajian where nama like '%$cari%' limit $offset,$dataPerPage");

$mulai = isset($_REQUEST['mulai']) ? $_REQUEST['mulai'] : ''; 
$selesai = isset($_REQUEST['selesai']) ? $_REQUEST['selesai'] : '';
$query2 = mysqli_query($koneksi, "SELECT * FROM user WHERE nama like '%teknisi%' ");
$cari = isset($_REQUEST['cari']) ? $_REQUEST['cari'] : '';


// print_r($sql);
// exit;

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
      <form method="post" action="dashboard.php?tengah=penggajian_view">
        <div class="col-lg-8">
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
            <input name="mulai" type="date" class="form-control" value="$mulai">
            <span class="input-group-btn"></span>
            <input name="selesai" type="date" class="form-control" value="$selesai">
            <span class="input-group-btn"></span>
            <!-- <input name="jml_tgl_merah" type="int" class="form-control" placeholder="Jumlah Tanggal Merah"> -->
            <span class="input-group-btn"></span> 
            <span class="input-group-btn">
              <button class="btn btn-default glyphicon glyphicon-search" aria-hidden="true" type="submit"></button>
            </span>
          </div>
        </div>
      </form>
      <table class="table table-striped table-advance table-hover">

      </table>
      <!-- <form method="po" action="dashboard.php?tengah=penggajian_data"> -->
        <span class="input-group-btn">
          <a href="dashboard.php?tengah=penggajian_data">
            <button class="btn btn-default" aria-hidden="true" type="submit" >
              Kembali
            </button>
          </a>
        </span>
        <!-- </form>   -->
      </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
  </div><!-- /row -->

</section><! --/wrapper -->

<!-- <script>
  function alert_box() {
    if (confirm("Apakah Anda yakin akan menghapus data?")) {
      window.location.href="hapus.php?id=<?= $result->id_pengguna ?>";
    }else{

    };
  }
</script> -->