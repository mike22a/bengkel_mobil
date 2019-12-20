<?php
autentikasi();
aksesall();

$query = mysqli_query($koneksi, "SELECT user.nama FROM user where nama like '%Teknisi%'");

?>

<section class="wrapper">
 <h3><i class="fa fa-angle-right"></i> Tambah Nominal Upah</h3>


 <div class="row mt">
  <div class="col-lg-12">
    <div class="form-panel">
      <h4 class="mb"><i class="fa fa-angle-right"></i></h4>
      <form class="form-horizontal style-form" method="post" action="penggajian_proses_tambah_nominal.php">
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Nama Teknisi</label>
          <div class="col-sm-10">
            <!-- <input name="nama" type="text" class="form-control"> -->
            <select name="nama" class="form-control" >
              <?php
              while ($result = mysqli_fetch_object($query)) {
                echo '
                <option value="' . $result->nama . '">' . $result->nama . '</option>
                ';  
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Upah Harian</label>
          <div class="col-sm-10">
            <input name="upah_harian" type="text" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Upah Makan</label>
          <div class="col-sm-10">
            <input name="upah_makan" type="text" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Upah Lembur</label>
          <div class="col-sm-10">
            <input name="upah_lembur" type="text" class="form-control" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="submit" class="btn btn-round btn-primary">Tambah</button>
          </div>
        </div>
      </form>  
    </div>
  </div><!-- col-lg-12-->       
</div><!-- /row -->
</section><! --/wrapper -->
