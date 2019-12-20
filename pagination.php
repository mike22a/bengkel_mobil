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
  <a href='" . $_SERVER['PHP_SELF'] . "?cari" . $cari . "&tengah=penggajian_data&page=" . ($noPage + 1) . "'>Next &gt;&gt;</a></li>
  </ul>";
  ?>