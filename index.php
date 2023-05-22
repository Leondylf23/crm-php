<?php

require 'function.php';
// require 'cek.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SFA PT. XYZ</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <?php
                        $name = $_SESSION['userName'];
                        if(isset($_SESSION['log'])) {
                            echo "                            
                            <h1 class='mt-4'>Welcome To PT. Maju Jaya Furniture, $name.</h1>                            
                            ";
                        } else {
                            echo "                            
                            <h3 class='mt-4'>Silahkan login terlebih dahulu.</h3>                            
                            ";
                        }
                        
                        ?>
                        <?php 
                        $element = '<h4 class="mt-2 mb-3">Aktifitas Anda yang Sedang Berlangsung</h4>';
                        
                        if(isset($_SESSION['role'])) {
                            if($_SESSION['role'] == 1) {
                                $element = '<h4 class="mt-2 mb-3">Aktifitas Yang Perlu Dikonfirmasi</h4>';
                            }
                        }

                        echo $element;
                        ?>                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <a href="penjadwalan.php">Aktifitas Lengkap</a>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <?php if(isset($_SESSION['role'])) {if($_SESSION['role'] == 1) {?><th>Admin</th><?php }} ?>
                                            <th>Aktifitas</th>
                                            <th>Pelanggan</th>
                                            <th>Tenggang Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $userid = $_SESSION['userid'];                                        
                                        $logindata = mysqli_query($conn, "SELECT j.aktifitas, j.deskripsi, DATE_FORMAT(j.tgl_pelaksanaan, '%d-%m-%Y %H:%i') as tgl_pelaksanaan, DATE_FORMAT(j.tgl_selesai, '%d-%m-%Y %H:%i') as tgl_selesai, kj.nama_kategori, p.namapelanggan, p.prioritas FROM jadwal j inner join kategori_jadwal kj on kj.id = j.kategori inner join pelanggan p on j.idpelanggan = p.idpelanggan where j.is_active = 1 and j.adminid = $userid and j.status = 1 order by tgl_selesai asc");
                                        if(isset($_SESSION['role'])) {
                                            if($_SESSION['role'] == 1) {
                                                $logindata = mysqli_query($conn, "SELECT j.aktifitas, j.deskripsi, DATE_FORMAT(j.tgl_pelaksanaan, '%d-%m-%Y %H:%i') as tgl_pelaksanaan, DATE_FORMAT(j.tgl_selesai, '%d-%m-%Y %H:%i') as tgl_selesai, kj.nama_kategori, p.namapelanggan, p.prioritas, l.nama FROM jadwal j inner join kategori_jadwal kj on kj.id = j.kategori inner join pelanggan p on j.idpelanggan = p.idpelanggan inner join login l on l.iduser = j.adminid where j.is_active = 1 and j.status = 2 order by tgl_selesai asc");
                                            }
                                        }
                                        $i = 1;
                                        while($data=mysqli_fetch_array($logindata)){
                                            $aktifitas = $data['aktifitas'];
                                            $desc = $data['deskripsi'];
                                            $tglPlksnaan = $data['tgl_pelaksanaan'];
                                            $tglSlse = $data['tgl_selesai'];
                                            $kategori = $data['nama_kategori'];
                                            $pelanggan = $data['namapelanggan'];
                                            $prioritas = $data['prioritas'];
                                            if(isset($_SESSION['role'])) {if($_SESSION['role'] == 1) {$namaAdmin = $data['nama'];}}
                                        
                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <?php if(isset($_SESSION['role'])) {if($_SESSION['role'] == 1) {?><td><?php echo $namaAdmin;?></td><?php }} ?>
                                            <td><?=$kategori;?></td>
                                            <!-- <td><?=$aktifitas;?></td> -->
                                            <!-- <td><?=$desc;?></td> -->
                                            <!-- <td><?=$tglPlksnaan;?></td> -->
                                            <td><?=$pelanggan;?> - <?=$prioritas;?></td>
                                            <td><?=$tglSlse;?></td>
                                        </tr>
                                    <?php 
                                    };
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-ranking-star me-1"></i>
                                        Pekerjaan Anda
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart" width="100%" height="40vh"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Pekerjaan Anda Tahun Ini
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="47vh"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            <?php require "footer.php"; ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('myPieChart');
            const ctx1 = document.getElementById('myBarChart');
            let kpiDataTemp = [];
            let kpiDataLabels = ['Aktifitas', 'Komplain', 'Transaksi', 'Pelanggan', 'Produk'];
            let kpiData = [];
            let kpiYear = [];

            <?php
                $userid = $_SESSION["userid"];
                                    
                $kpiKategori = mysqli_query($conn, "SELECT kategori, COUNT(id) as jumlah FROM `kpi_records` WHERE adminid = $userid AND YEAR(CURRENT_DATE) = YEAR(added_date) GROUP BY kategori");
                while($fetcharray = mysqli_fetch_array($kpiKategori)){
                    $kategori = $fetcharray['kategori'];
                    $jumlah = $fetcharray['jumlah'];
                    echo("kpiDataTemp.push({label: '$kategori', jumlah: '$jumlah'});");
                }

                echo("
                kpiDataLabels.forEach(e => {
                    var data = 0;
                    kpiDataTemp.forEach(d => {
                        if(d.label == e) {
                            data = d.jumlah;
                        }
                    });
                    kpiData.push(data);                            
                });
                ");
                
                $kpiTahunan = mysqli_query($conn, "SELECT MONTH(added_date) as bulan, COUNT(id) as jumlah FROM `kpi_records` WHERE adminid = $userid and YEAR(CURRENT_DATE) = YEAR(added_date) GROUP BY MONTHNAME(added_date)");
                $dataKPIYear = array();                
                while($fetcharray = mysqli_fetch_array($kpiTahunan)){
                    $kategoriTh = $fetcharray['bulan'];
                    $jumlahTh = $fetcharray['jumlah'];

                    array_push($dataKPIYear, array("bln" => $kategoriTh, "jmlh" => $jumlahTh));
                }
                for ($i=1; $i <= 12; $i++) { 
                    $jmlh = 0;

                    foreach ($dataKPIYear as $d) {
                        if($d['bln'] == $i) {
                            $jmlh = $d['jmlh'];
                        }
                    }
                    echo("kpiYear.push($jmlh);");
                }
            ?>

            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: kpiDataLabels,
                    datasets: [{
                        label: 'Banyaknya Pekerjaan',
                        data: kpiData,
                        borderWidth: 4,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgb(255, 99, 132)',
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    datasets: [{
                        label: 'Banyaknya Pekerjaan',
                        data: kpiYear,
                        borderWidth: 1,
                        backgroundColor: 'rgba(255, 200, 20, 0.2)',
                        borderColor: 'rgb(255, 200, 20)',
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
