<?php

autentikasi();
aksesall();
koneksi_db();

$dataPerPage = 5;
// $bonus = 1000000;

if (isset($_GET['page'])) {
  $noPage = $_GET['page'];
}else{
  $noPage = 1;
}

$id_gaji = isset($_REQUEST['id_gaji']) ? $_REQUEST['id_gaji'] : "";

// echo "$id_gaji";
// exit;

$offset = ($noPage - 1) * $dataPerPage;

$query = mysqli_query($koneksi, "SELECT * FROM penggajian left join user on penggajian.id_user=user.id_user where id_gaji='$id_gaji'");

$result = mysqli_fetch_object($query);

// print_r($result);
// exit;

// $rekap_upah_harian = $upah_harian*$masuk;
// $rekap_upah_makan = $upah_makan*$masuk;
// $rekap_upah_lembur = $upah_lembur*$lembur;

$masuk = $result->jumlah_masuk;
$lembur = $result->jam_lembur;
$upah_harian = $result->upah_harian;
$upah_makan = $result->upah_makan;
$upah_lembur = $result->upah_lembur;
$rekap_upah_harian = $result->rekap_upah_harian;
$rekap_upah_makan = $result->rekap_upah_makan;
$rekap_upah_lembur = $result->rekap_upah_lembur;
$bonus = $result->nominal_tambahan;
$total1 = $rekap_upah_harian + $rekap_upah_makan + $rekap_upah_lembur;
$total2 = $total1 + $bonus;

$mulai = $result->tanggal_mulai;
$selesai = $result->tanggal_selesai;

$cari = $result->nama;


?>


<section class="wrapper">
 <h3><i class="fa fa-angle-right"></i> Data Gaji</h3>

 <div class="row mt">
  <div class="col-md-12">
    <div class="content-panel">
      <table class="table table-striped table-advance table-hover">
        <h4><i class="fa fa-angle-right"></i><?= $cari ?> (</i><?= $mulai ?> - </i><?= $selesai ?>)</h4>        
        <hr>
        <thead>
          <tr>
            <th> </th>
            <th> Banyak</th>
            <th> Upah</th>
            <th> Total </th>
          </tr>
        </thead>
        <tbody>          
          <tr>
            <td> Upah Harian </td>
            <td><?= $masuk ?></td>
            <td><?= rupiah($upah_harian)  ?></td>
            <td><?= rupiah($rekap_upah_harian) ?></td>
          </tr>
          <tr>
            <td> Upah Makan </td>
            <td><?= $masuk ?></td>
            <td><?= rupiah($upah_makan)  ?></td>
            <td><?= rupiah($rekap_upah_makan) ?></td>
          </tr>
          <tr>
            <td> Upah Lembur </td>
            <td><?= $lembur ?></td>              
            <td><?= rupiah($upah_lembur) ?></td>
            <td><?= rupiah($rekap_upah_lembur) ?></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><?= rupiah($total2) ?></td>              
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td> Bonus</td>
            <td><?= rupiah($bonus) ?></td>
          </tr>        
          <tr>          
            <td></td>
            <td></td>
            <td> Total</td>
            <td><?= rupiah($total2) ?></td>              
          </tr>
          <!-- <tr>
            <td>Jumlah Tools</td>
            <td><?= $tools ?></td>
          </tr> -->
        </tbody>
      </table>
      <span class="input-group-btn">
        <a href="dashboard.php?tengah=penggajian_data">
          <button class="btn btn-default" aria-hidden="true" type="submit" >
            Kembali
          </button>
        </a>
      </span>
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