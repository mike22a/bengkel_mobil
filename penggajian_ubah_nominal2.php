<?php
autentikasi();
aksesall();

$query = mysqli_query($koneksi, "SELECT user.nama FROM user where nama like '%Teknisi%'");

$id_user = isset($_REQUEST['id_user']) ? $_REQUEST['id_user'] : '';
$query2 = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id_user'");
$result = mysqli_fetch_object($query2);
?>

<section class="wrapper">
 <h3><i class="fa fa-angle-right"></i> Ubah Nominal Upah</h3>


 <div class="row mt">
  <div class="col-lg-12">
    <div class="form-panel">
      <h4 class="mb"><i class="fa fa-angle-right"></i></h4>
      <form class="form-horizontal style-form" method="post" action="penggajian_proses_tambah_nominal.php">
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label"><?= $result->nama ?></label>
          <div class="col-sm-10">
            <input name="nama" type="text" class="form-control" readonly value="<?= $result->nama ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Upah Harian</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" class="form-control" readonly value="<?= rupiah($result->upah_harian) ?>"> 
              <span class="input-group-btn">x</span>
              <input name="upah_harian" type="text" class="form-control">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Upah Lembur</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" class="form-control" readonly value="<?= rupiah($result->upah_lembur) ?>"> 
              <span class="input-group-btn">x</span>
              <input name="upah_lembur" type="text" class="form-control">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Upah Makan</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" class="form-control" readonly value="<?= rupiah($result->upah_makan) ?>"> 
              <span class="input-group-btn">x</span>
              <input name="upah_makan" type="text" class="form-control">
            </div>
          </div>
        </div>
        <!-- <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Upah Harian Baru</label>
          <div class="col-sm-10">
            <input name="upah_harian" type="text" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Upah Makan Lama</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" readonly value="<?= rupiah($result->upah_makan) ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Upah Makan Baru</label>
          <div class="col-sm-10">
            <input name="upah_makan" type="text" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Upah Lembur Lama</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" readonly value="<?= rupiah($result->upah_lembur) ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Upah Lembur Baru</label>
          <div class="col-sm-10">
            <input name="upah_lembur" type="text" class="form-control">
          </div>
        </div> -->
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="submit" class="btn btn-round btn-success">Simpan</button>
          </div>
        </div>
      </form>
      <span class="input-group-btn">
        <a href="dashboard.php?tengah=penggajian_ubah_nominal">
          <button class="btn btn-default" aria-hidden="true" type="submit" >
            Kembali
          </button>
        </a>
      </span>    
    </div>
  </div><!-- col-lg-12-->       
</div><!-- /row -->
</section><! --/wrapper -->
