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
                                        Pelanggan
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart2" width="100%" height="25vh" aria-label="TESTTT" role="img"></canvas></div>
                                    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Admin</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $logindata = mysqli_query($conn, "SELECT nama, role FROM login");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($logindata)){
                                                $nama = $data['nama'];
                                                $role = $data['role'];
                                                
                                                if ($role == 1) {
                                                    $role = "Super Admin";
                                                } else {
                                                    $role = "Admin";
                                                }
                                            ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$nama;?></td>
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
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('myPieChart');
            const ctx1 = document.getElementById('myPieChart1');
            const ctx2 = document.getElementById('myPieChart2');

            // const chart = new Chart(ctx, {
            //     type: 'pie'
            //     data: {
            //         labels: [
            //             'Red',
            //             'Blue',
            //             'Yellow'
            //         ],
            //         datasets: [{
            //             label: 'My First Dataset',
            //             data: [300, 50, 100],
            //             backgroundColor: [
            //                 'rgb(255, 99, 132)',
            //                 'rgb(54, 162, 235)',
            //                 'rgb(255, 205, 86)'
            //             ],
            //             hoverOffset: 4
            //         }]
            //     };
            //     options: {};
            //     plugins: [];
            // });

            let produk = [];
            let komplain = [];
            let pelanggan = [];

            <?php
                $produk = mysqli_query($conn, "SELECT p.nama_item, COUNT(p.nama_item) as jumlah FROM transaksi t INNER JOIN transaksi_detail td ON t.idtransaksi = td.idtransaksi INNER JOIN produk p ON td.idproduk = p.idproduk WHERE t.is_active = 1 GROUP BY p.nama_item");
                while($fetcharray = mysqli_fetch_array($produk)){
                    $namaItem = $fetcharray['nama_item'];
                    $jumlahPrdk = $fetcharray['jumlah'];
                    echo("produk.push({label: '$namaItem', jumlah: '$jumlahPrdk'});");
                }
                
                $komplain = mysqli_query($conn, "SELECT kk.nama_kategori, COUNT(kk.nama_kategori) AS jumlah FROM komplain k INNER JOIN kategori_komplain kk ON k.idkategori = kk.id WHERE k.is_active = 1 GROUP BY kk.nama_kategori");
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
            ?>

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: produk.map(obj => obj.label),
                    datasets: [{
                        label: 'Kuantitas Produk',
                        data: produk.map(obj => obj.jumlah),
                        borderWidth: 1
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
                        borderWidth: 1
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
                        borderWidth: 5
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
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/demo/chart-pie-demo.js"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
