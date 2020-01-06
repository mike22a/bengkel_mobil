<?php

autentikasi();
aksesadmin();
// aksesowner();

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

function rounding($val)
{
  return round($val,3);
}

$mulai = isset($_REQUEST['mulai']) ? $_REQUEST['mulai'] : ''; 
$selesai = isset($_REQUEST['selesai']) ? $_REQUEST['selesai'] : '';
$cari = isset($_REQUEST['cari']) ? $_REQUEST['cari'] : '';
$merah = empty($_REQUEST['jml_tgl_merah']) ? 0 : $_REQUEST['jml_tgl_merah'];
// print_r($_REQUEST);
// echo $merah;

$date1=date_create("$mulai");
$date2=date_create("$selesai");
$diff = hitunghari($date1,$date2);

$offset = ($noPage - 1) * $dataPerPage;

$query = mysqli_query($koneksi, "SELECT * FROM $loc_penggajian where nama='$cari'");

$query2 = mysqli_query($koneksi, "SELECT * FROM $loc_penggajian");

// if ($mulai != '' AND $selesai != '') {
//   $query4 = mysqli_query($koneksi, "SELECT penggajian.*,user.* FROM penggajian left join user on penggajian.id_user=user.id_user where user.id_user='$id_user->id_user' AND (tanggal_mulai between '$mulai' AND '$selesai' OR tanggal_selesai between '$mulai' AND '$selesai')");
// }elseif ($mulai == '' AND $selesai != '') {
//   $query4 = mysqli_query($koneksi, "SELECT penggajian.*,user.* FROM penggajian left join user on penggajian.id_user=user.id_user where user.id_user='$id_user->id_user' AND (tanggal_mulai between '0000-00-00' AND '$selesai' OR tanggal_selesai between '0000-00-00' AND '$selesai')");
// }elseif ($mulai != '' AND $selesai == '') {
//   $query4 = mysqli_query($koneksi, "SELECT penggajian.*,user.* FROM penggajian left join user on penggajian.id_user=user.id_user where user.id_user='$id_user->id_user' AND (tanggal_mulai between '$mulai' AND '2050-01-01' OR tanggal_selesai between '$mulai' AND '2050-01-01')");
// }else{
//   $query4 = mysqli_query($koneksi, "SELECT penggajian.*,user.* FROM penggajian left join user on penggajian.id_user=user.id_user where user.id_user='$id_user->id_user'");  
// }

// mengumpulkan data untuk view

// cari id berdasarkan nama
$tmp = mysqli_query($koneksi, "SELECT id_user from user where nama='$cari'");
$nama_id = mysqli_fetch_object($tmp)->id_user;

// cari jumlah hari masuk dan jam lembur
$tmp2 = mysqli_query($koneksi, "SELECT count(presensi_harian.masuk) as masuk, SUM(presensi_lembur.jam) as jam FROM presensi_harian LEFT JOIN presensi_lembur ON presensi_harian.id_harian=presensi_lembur.id_harian WHERE tanggal BETWEEN '$mulai' AND '$selesai' AND id_user='$nama_id' and masuk='ya'");

// $jml_masuk_lembur = mysqli_query($koneksi, "SELECT user.nama,  COUNT(presensi_harian.masuk) as masuk, SUM(presensi_lembur.jam) as jam FROM `user` left JOIN presensi_harian on user.id_user=presensi_harian.id_user left join presensi_lembur on presensi_harian.id_harian=presensi_lembur.id_harian where user.id_user='$nama_id'");
$jml_masuk_lembur = mysqli_fetch_object($tmp2);

// cari jumlah tools total
$tmp3 = mysqli_query($koneksi, "SELECT user.nama, SUM(cek_tools.id_tools) as tools FROM `user` left JOIN presensi_harian on user.id_user=presensi_harian.id_user LEFT JOIN cek_tools ON presensi_harian.id_harian=cek_tools.id_harian where user.id_user='$nama_id'");
$jml_tools = mysqli_fetch_object($tmp3)->tools; 

// echo "$nama_id $mulai $selesai";
// print_r($jml_masuk_lembur);
// exit;

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

include 'smart.php';

$total2 = $total1 + $bonus;

// CEK SUDAH PERNAH REKAP BELUM
$cek1 = mysqli_query($koneksi, "SELECT * FROM penggajian where 
  tanggal_mulai <= '$mulai' and tanggal_selesai >= '$mulai' AND id_user='$nama_id'");
$cek2 = mysqli_query($koneksi, "SELECT * FROM penggajian where 
  tanggal_mulai <= '$selesai' and tanggal_selesai >= '$selesai'  AND id_user='$nama_id' ");
// print_r(mysqli_fetch_object($cek1));
// print_r($cek1);
// print_r($cek2);
// exit;

if (mysqli_num_rows($cek1) || mysqli_num_rows($cek2)) {
  $tipe = 0;
  $note = 'Data sudah pernah direkap ';
}else{
// $query = mysqli_query($koneksi, "INSERT INTO penggajian values ('','$id', '$mulai','$selesai','$tanggal_gaji','$bonus','$bobot_total','$lembur','$tools','$masuk','$rekap_upah_lembur','$rekap_upah_harian','$rekap_upah_makan')");
  $tipe = 1;
  $note = ' ';
}
?>


<section class="wrapper">
 <h3><i class="fa fa-angle-right"></i> Data Gaji (<?= $note ?>)</h3>

 <div class="row mt">
  <div class="col-md-12">
    <div class="content-panel">

      <table class="table table-striped table-advance table-hover">
        <h4><i class="fa fa-angle-right"></i><?= $cari ?> (</i><?= $mulai ?> - </i><?= $selesai ?>)</h4>        
        
        <form method="post" action="dashboard.php?tengah=penggajian_filter">
          <span class="input-group-btn">
            <button class="btn btn-default" aria-hidden="true" type="submit"> Kembali</button>
          </span>
          <input name="cari" type="hidden" class="form-control" value="<?= $result->nama ?>">        
          <input name="mulai" type="hidden" class="form-control" value="<?= $result->tanggal_mulai ?>">        
          <input name="selesai" type="hidden" class="form-control" value="<?= $result->tanggal_selesai ?>">        
        </form>
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
            <td><?= rupiah($total1) ?></td>              
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
        </tbody>
      </table>

      <table class="table table-striped table-advance table-hover">
        <tbody>
          <form method="post" action="penggajian_proses.php">
            <div class="col-lg-4">
              <div class="input-group">
                <tr>
                  <input name="id" type="hidden" class="form-control" value="<?= $nama_id ?>">
                  <input name="nama" type="hidden" class="form-control" value="<?= $cari ?>">
                  <input name="mulai" type="hidden" class="form-control" value="<?= $mulai ?>">
                  <input name="selesai" type="hidden" class="form-control" value="<?= $selesai ?>">
                  <input name="tanggal" type="hidden" class="form-control" value="<?= $tanggal ?>">            
                  <input name="masuk" type="hidden" class="form-control" value="<?= $masuk ?>">            
                  <input name="lembur" type="hidden" class="form-control" value="<?= $lembur ?>">            
                  <input name="upah_harian" type="hidden" class="form-control" value="<?= $upah_harian ?>">            
                  <input name="upah_lembur" type="hidden" class="form-control" value="<?= $upah_lembur ?>">            
                  <input name="upah_makan" type="hidden" class="form-control" value="<?= $upah_makan ?>">            
                  <input name="rekap_upah_harian" type="hidden" class="form-control" value="<?= $rekap_upah_harian ?>">            
                  <input name="rekap_upah_lembur" type="hidden" class="form-control" value="<?= $rekap_upah_lembur ?>">            
                  <input name="rekap_upah_makan" type="hidden" class="form-control" value="<?= $rekap_upah_makan ?>">            
                  <input name="tools" type="hidden" class="form-control" value="<?= $jml_tools ?>">            
                  <input name="bonus" type="hidden" class="form-control" value="<?= $bonus ?>">            
                  <input name="total" type="hidden" class="form-control" value="<?= $total2 ?>">            
                  <?php if ($tipe == 1)
                  echo '
                  <td>Tanggal Rekap</td>
                  <td>
                  <div class="col-sm-6">
                  <input name="tanggal" type="date" class="form-control" placeholder="2019-12-2">
                  </div>
                  </td>
                  <td>
                  <button  aria-hidden="true" type="submit">Rekap Gaji</button>
                  ';
                  ?>
                </td>
                <td></td>
                <td></td>
              </tr>
            </div>
          </div>
        </form>
      </tbody>
    </table>

   <!--        <tr>
            <td>Jumlah Tools</td>
            <td><?= $tools ?></td>
          </tr> -->



          <! -- MODALS -->
          <div class="showback">
           <!-- <h4><i class="fa fa-angle-right"></i> Modal Example</h4> -->
           <!-- Button trigger modal -->
           <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">
            Detail Bonus
          </button>

          <!-- Modal -->
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Detail Perhitungan Bonus</h4>
                </div>
                <div class="modal-body">
                  <!-- <h4> 1. Bobot </h4>
                  <h4> 2. Nilai Perhitungan </h4>
                  <h4> 3. Hasil kali nilai dan bobot </h4> -->
                  <h4> Perhitungan </h4>

                  <table class="table table-striped table-advance table-hover">
                    <thead>
                      <tr>                      
                        <th></th>
                        <th> Bobot </th>
                        <th> Nilai </th>
                        <th> Total </th>
                      </tr>  
                    </thead>
                    <tbody>

                      <tr> 
                        <td> Tools </td>                      
                        <td> <?= $bobot_tools ?></td>
                        <td> <?= rounding($hasil_tools) ?></td>
                        <td> <?= rounding($bobot_tools*$hasil_tools) ?></td>
                      </tr>
                      <tr>
                        <td> Customer </td>
                        <td> <?= $bobot_customer ?> </td>
                        <td> <?= rounding($hasil_customer) ?> </td>
                        <td> <?= rounding($bobot_customer*$hasil_customer) ?> </td>
                      </tr>
                      <tr>
                        <td> Presensi </td>
                        <td> <?= $bobot_presensi ?> </td>
                        <td> <?= rounding($hasil_presensi) ?> </td>
                        <td> <?= rounding($bobot_presensi*$hasil_presensi) ?> </td>
                      </tr>
                      <tr>
                        <td> Pengetahuan </td>
                        <td> <?= $bobot_pengetahuan ?> </td>
                        <td> <?= rounding($hasil_pengetahuan) ?> </td>
                        <td> <?= rounding($bobot_pengetahuan*$hasil_pengetahuan) ?> </td>
                      </tr>                    
                      <tr>
                        <td> Durasi  </td>
                        <td> <?= $bobot_durasi ?> </td>
                        <td> <?= rounding($hasil_durasi) ?> </td>
                        <td> <?= rounding($bobot_durasi*$hasil_durasi) ?> </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td> Jumlah </td>
                        <td> <?= rounding($hasil_total) ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <h4> Nilai Bobot </h4>
                  <?php
                  $query6 = mysqli_query($koneksi, "SELECT * FROM bobot_gaji");
                      // $nilai_bobot = mysqli_fetch_object($query6);
                  ?>
                  <table class="table table-advance table-hover">
                      <!-- <th> Batas Bawah </th>
                        <th> Batas Atas </th> -->
                        <th> Range Nilai </th>
                        <th> Nominal </th>
                        <?php
                        while ($result = mysqli_fetch_object($query6)) {
                          if ($hasil_total >= $result->dari && $hasil_total <= $result->sampai) {
                           // <div class="alert alert-success">
                           echo '                        
                           <tr class="bg-success">
                           <td> <b><i> ' . $result->dari . ' - ' . $result->sampai . ' </i></b> </td>
                           <td> <b><i> ' . $result->besaran_gaji . '  </i></b> </td>
                           </tr>
                           ';
                           // </div>
                         }else{
                          echo '                        
                          <tr>
                          <td> ' . $result->dari . ' - ' . $result->sampai . ' </td>
                          <td> ' . $result->besaran_gaji . ' </td>
                          </tr>
                          ';
                        }
                      } 
                      ?>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                  </div>
                </div>
              </div>
            </div>              
          </div><!-- /showback -->
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