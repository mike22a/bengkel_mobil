<?php

autentikasi();
aksesall();
koneksi_db();

$dataPerPage = 5;
$bonus = 1000000;

if (isset($_GET['page'])) {
  $noPage = $_GET['page'];
}else{
  $noPage = 1;
}

$id_gaji = isset($_REQUEST['id_gaji']) ? $_REQUEST['id_gaji'] : "";

// echo "$id_gaji";
// exit;

$offset = ($noPage - 1) * $dataPerPage;

// cari id berdasarkan nama
$tmp = mysqli_query($koneksi, "SELECT id_user from user where nama='$cari'");
$nama_id = mysqli_fetch_object($tmp)->id_user;

// cari jumlah hari masuk dan jam lembur
$tmp2 = mysqli_query($koneksi, "SELECT count(presensi_harian.masuk) as masuk, SUM(presensi_lembur.jam) as jam FROM presensi_harian LEFT JOIN presensi_lembur ON presensi_harian.id_harian=presensi_lembur.id_harian WHERE tanggal BETWEEN '$mulai' AND '$selesai' AND id_user='$nama_id' and masuk='ya'");

// $jml_masuk_lembur = mysqli_query($koneksi, "SELECT user.nama,  COUNT(presensi_harian.masuk) as masuk, SUM(presensi_lembur.jam) as jam FROM `user` left JOIN presensi_harian on user.id_user=presensi_harian.id_user left join presensi_lembur on presensi_harian.id_harian=presensi_lembur.id_harian where user.id_user='$nama_id'");
$jml_masuk_lembur = mysqli_fetch_object($tmp2);

// cari jumlah tools total
$tmp3 = mysqli_query($koneksi, "SELECT user.nama, SUM(cek_tools.id_tools) as tools FROM `user` left JOIN presensi_harian on user.id_user=presensi_harian.id_user LEFT JOIN cek_tools ON presensi_harian.id_harian=cek_tools.id_harian where user.id_user='$nama_id'");
$tools = mysqli_fetch_object($tmp3)->tools; 

// upah upah
$tmp4 = mysqli_query($koneksi, "SELECT upah_harian,upah_lembur, upah_makan FROM `user` WHERE id_user='$nama_id'");
$upah = mysqli_fetch_object($tmp4);


$masuk = $jml_masuk_lembur->masuk;
$lembur = $jml_masuk_lembur->jam;
$upah_harian = $upah->upah_harian;
$upah_makan = $upah->upah_makan;
$upah_lembur = $upah->upah_lembur;
$rekap_upah_harian = $upah_harian*$masuk;
$rekap_upah_makan = $upah_makan*$masuk;
$rekap_upah_lembur = $upah_lembur*$lembur;
$total1 = $rekap_upah_harian + $rekap_upah_makan + $rekap_upah_lembur;
$total2 = $total1 + $bonus;


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
            <td><?= $rekap_upah_harian ?></td>
          </tr>
          <tr>
            <td> Upah Makan </td>
            <td><?= $masuk ?></td>
            <td><?= rupiah($upah_makan)  ?></td>
            <td><?= $rekap_upah_makan ?></td>
          </tr>
          <tr>
            <td> Upah Lembur </td>
            <td><?= $lembur ?></td>              
            <td><?= rupiah($upah_lembur) ?></td>
            <td><?= $rekap_upah_lembur ?></td>
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