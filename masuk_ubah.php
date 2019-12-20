<?php

// $id_tool = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
// $nama = isset($_REQUEST['nama_teknisi']) ? $_REQUEST['nama_teknisi'] : '';

// id harian buka id user
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$tool = array('','','','','','' );
koneksi_db();
autentikasi();
aksesteknisi();


// $query = mysqli_query($koneksi, "SELECT * FROM presensi_harian WHERE id_harian='$id'" );

$sql = mysqli_query($koneksi, "SELECT user.nama,presensi_harian.tanggal FROM presensi_harian LEFT JOIN user ON user.id_user=presensi_harian.id_user WHERE presensi_harian.id_harian='$id' ");

$tmp = mysqli_fetch_object($sql);

?>


<section class="wrapper">
 <h3><i class="fa fa-angle-right"></i> Form Ubah Data Tools</h3>


 <div class="row mt">
  <div class="col-lg-12">
    <div class="form-panel">
      <h4 class="mb"><i class="fa fa-angle-right"></i> <?= $tmp->nama ?></h4>
      <form class="form-horizontal style-form" method="post" action="masuk_proses_ubah.php">
        <input name="id" type="hidden" class="form-control" value="<?= $id ?>">
        <!-- <?= $tmp->id_tools ?> -->
        <input name="nama" type="hidden" class="form-control" value="<?= $tmp->nama ?>">
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Tanggal</label>
          <div class="col-sm-10">
            <input name="tanggal" type="text" class="form-control" value="<?= $tmp->tanggal ?>" readonly>
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Presensi</label>
          <div class="col-sm-10">
            <select name="presensi" class="form-control"
            <?php 
            if (!($_SESSION['akses'] != 'admin' || $_SESSION['akses'] != 'teknisi')) { echo"readonly"; }
            ?>
            >
            <option value="ya">ya</option>
            <option value="tidak">tidak</option>
          </select>
        </div>

        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="submit" class="btn btn-round btn-primary">Ubah</button>
          </div>
        </div>
      </form>  
    </div>
  </div><!-- col-lg-12-->       
</div><!-- /row -->
</section><! --/wrapper -->
