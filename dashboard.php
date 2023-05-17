<?php

require 'function.php';
require 'cek.php';

if(isset($_SESSION['role'])) {
    if($_SESSION['role'] == 2) {
        echo '<script> alert("Anda tidak memiliki akses halaman ini!");</script>';
        header('location:index.php');
    }
} else {
    echo '<script> alert("Anda tidak memiliki akses halaman ini!");</script>';
    header('location:index.php');

}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        
        <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 mb-5">Dashboard</h1>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-pie me-1"></i>
                                        Penjualan Produk
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart" width="100%" height="25vh" aria-label="TESTTT" role="img"></canvas></div>
                                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-pie me-1"></i>
                                        Komplain
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart1" width="100%" height="25vh" aria-label="TESTTT" role="img"></canvas></div>
                                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-pie me-1"></i>
                                        Prioritas Pelanggan
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart2" width="100%" height="25vh" aria-label="TESTTT" role="img"></canvas></div>
                                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-line me-1"></i>
                                        Perkembangan Keuntungan Penjualan Produk
                                    </div>
                                    <div class="card-body"><canvas id="myLineChart" width="100%" height="50px" aria-label="TESTTT" role="img"></canvas></div>
                                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-line me-1"></i>
                                        Perkembangan Kuantitas Penjualan Produk
                                    </div>
                                    <div class="card-body"><canvas id="myLineChart1" width="100%" height="50px" aria-label="TESTTT" role="img"></canvas></div>
                                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3 class="mt-4 mb-2">Data Admin</h3>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Admin</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $logindata = mysqli_query($conn, "SELECT nama, role, email FROM login");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($logindata)){
                                                $nama = $data['nama'];
                                                $role = $data['role'];
                                                $email = $data['email'];
                                                
                                                if ($role == 1) {
                                                    $role = "Super Admin";
                                                } else {
                                                    $role = "Admin";
                                                }
                                            ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$nama;?></td>
                                                <td><?=$email;?></td>
                                                <td><?=$role;?></td>
                                            </tr>
                                        <?php 
                                        };
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php require "footer.php"; ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx0 = document.getElementById('myPieChart');
            const ctx1 = document.getElementById('myPieChart1');
            const ctx2 = document.getElementById('myPieChart2');
            const ctx3 = document.getElementById('myLineChart');
            const ctx4 = document.getElementById('myLineChart1');

            let produk = [];
            let komplain = [];
            let pelanggan = [];

            let penjualanUntung = [];
            let penjualanQty = [];
            let penjualanTemp = [];
            let item = [];
            let distncItem = [];

            var monthNow = 0;

            <?php
                $year = "YEAR(CURRENT_DATE)";
                // $year = "2022";

                $produk = mysqli_query($conn, "SELECT p.nama_item, COUNT(p.nama_item) as jumlah FROM transaksi t INNER JOIN transaksi_detail td ON t.idtransaksi = td.idtransaksi INNER JOIN produk p ON td.idproduk = p.idproduk WHERE t.is_active = 1 AND YEAR(t.tanggal_transaksi) = $year GROUP BY p.nama_item");
                while($fetcharray = mysqli_fetch_array($produk)){
                    $namaItem = $fetcharray['nama_item'];
                    $jumlahPrdk = $fetcharray['jumlah'];
                    echo("produk.push({label: '$namaItem', jumlah: '$jumlahPrdk'});");
                }
                
                $komplain = mysqli_query($conn, "SELECT kk.nama_kategori, COUNT(kk.nama_kategori) AS jumlah FROM komplain k INNER JOIN kategori_komplain kk ON k.idkategori = kk.id WHERE k.is_active = 1 AND YEAR(k.tanggal) = $year GROUP BY kk.nama_kategori");
                while($fetcharray = mysqli_fetch_array($komplain)){
                    $namaKategori = $fetcharray['nama_kategori'];
                    $jumlahKmpln = $fetcharray['jumlah'];
                    echo("komplain.push({label: '$namaKategori', jumlah: '$jumlahKmpln'});");
                } 

                $pelanggan = mysqli_query($conn, "SELECT prioritas, COUNT(idpelanggan) as jumlah from pelanggan WHERE is_active = 1 GROUP BY prioritas");
                while($fetcharray = mysqli_fetch_array($pelanggan)){
                    $prioritas = $fetcharray['prioritas'];
                    $jumlahPlgn = $fetcharray['jumlah'];
                    echo("pelanggan.push({label: '$prioritas', jumlah: '$jumlahPlgn'});");
                } 
                
                $penjualan = mysqli_query($conn, "
                SELECT
	                SUM(transaksi_detail.qty) AS qty, 
	                SUM(transaksi_detail.totalharga) AS totalharga,
	                SUM(transaksi_detail.qty * produk.harga_pokok) AS modal, 
	                produk.nama_item, 
	                MONTH(transaksi.tanggal_transaksi) AS bulan
                FROM
	                transaksi_detail
	            INNER JOIN
	                produk
	            ON 
		            transaksi_detail.idproduk = produk.idproduk
	            INNER JOIN
	                transaksi
	            ON 
		            transaksi_detail.idtransaksi = transaksi.idtransaksi
                WHERE
                    transaksi.is_active = 1 AND
                    produk.is_active = 1 AND
                    YEAR(transaksi.tanggal_transaksi) = $year
                GROUP BY
	                MONTH(transaksi.tanggal_transaksi), 
	                produk.nama_item
                ORDER BY
	                transaksi.tanggal_transaksi
                ");                
                while($fetcharray = mysqli_fetch_array($penjualan)){
                    $item = $fetcharray['nama_item'];
                    $bulan = $fetcharray['bulan'];
                    $qty = $fetcharray['qty'];
                    $modal = $fetcharray['modal'];
                    $totalharga = $fetcharray['totalharga'];
                    
                    echo("item.push('$item');");
                    echo("penjualanTemp.push({label: '$item', bulan: '$bulan', qty: '$qty', modal: '$modal', jual: '$totalharga'});");
                } 
                $monthNow = date('n');
                echo("monthNow = $monthNow;");
                echo("
                distncItem = [...new Set(item)];                

                distncItem.forEach((e) => {
                    let temp = [];

                    for(var i = 1; i <= monthNow; i++) {
                        temp.push({qty: 0, modal: 0, jual: 0, bln: i})
                    }
                    penjualanTemp.forEach((a) => {
                        if(a.label == e) {

                            temp.forEach((b) => {
                                if(b.bln == a.bulan) {
                                    b.qty = a.qty;
                                    b.modal = a.modal;
                                    b.jual = a.jual;
                                }
                            });
                        }
                    });
                    penjualanUntung.push({label: e, data: temp.map(obj => (obj.jual - obj.modal)), fill: false, tension: 0.1});
                    penjualanQty.push({label: e, data: temp.map(obj => obj.qty), fill: false, tension: 0.1});
                });
                ");

            ?>

            new Chart(ctx0, {
                type: 'pie',
                data: {
                    labels: produk.map(obj => obj.label),
                    datasets: [{
                        label: 'Kuantitas Produk',
                        data: produk.map(obj => obj.jumlah),
                        borderWidth: 3
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
                type: 'pie',
                data: {
                    labels: komplain.map(obj => obj.label),
                    datasets: [{
                        label: 'Jumlah Komplain',
                        data: komplain.map(obj => obj.jumlah),
                        borderWidth: 3
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

            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: pelanggan.map(obj => obj.label),
                    datasets: [{
                        label: 'Kuantitas Pelanggan',
                        data: pelanggan.map(obj => obj.jumlah),
                        borderWidth: 3
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

            const label = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            new Chart(ctx3, {
                type: 'line',
                data: {
                    labels: label,
                    datasets: penjualanUntung
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const label1 = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            new Chart(ctx4, {
                type: 'line',
                data: {
                    labels: label1,
                    datasets: penjualanQty
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            // console.table(produk);

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/demo/chart-pie-demo.js"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
