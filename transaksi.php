<?php

require 'function.php';
require 'cek.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Transaksi</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">PT. Maju Jaya Furniture</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Data Pelanggan
                            </a>
                            <a class="nav-link" href="produk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Data Produk
                            </a>
                            <a class="nav-link" href="transaksi.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Data Transaksi Penjualan
                            </a>
                            <a class="nav-link" href="komplain.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Komplain
                            </a>
                            <a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Laporan
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Copyright © 2023 Thendy Rhenaldy. All rights reserved.</div>

                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Transaksi</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Transaksi
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Id Pelanggan</th>
                                            <!-- <th>Nama Pelanggan</th> -->
                                            <th>Nama Produk</th>
                                            <th>Harga Jual</th>
                                            <th>Modal</th>
                                            <th>Untung</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $ambilsemuadatatransaksi = mysqli_query($conn, "select * from transaksi");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatatransaksi)){
                                            $idtransaksi = $data['idtransaksi'];
                                            $tanggaltransaksi = $data['tanggal_transaksi'];
                                            $idpelanggan = $data['idpelanggan'];
                                            // $namapelanggan = $data['nama_pelanggan'];
                                            $idproduk = $data['idproduk'];
                                            $hargajual = $data['harga_jual'];
                                            $modal = $data['harga_modal'];
                                            $untung = $data['untung'];
                                        
                                        ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <!-- <td><?=$idtransaksi;?></td> -->
                                            <td><?=$tanggaltransaksi;?></td>
                                            <td><?=$idpelanggan;?></td>
                                            <!-- <td><?=$namapelanggan;?></td> -->
                                            <td><?=$idproduk;?></td>
                                            <td><?=$hargajual;?></td>
                                            <td><?=$modal;?></td>
                                            <td><?=$untung;?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idtransaksi;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idtransaksi;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit The Modal -->
                                        <div class="modal fade" id="edit<?=$idtransaksi;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Transaksi</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="text" name="tanggal_transaksi" value="<?=$tanggaltransaksi;?>" class="form-control" required>
                                                            <br>
                                                            <input type="text" name="nama_pelanggan" value="<?=$namapelanggan;?>" class="form-control" required>
                                                            <br>
                                                            <input type="text" name="idproduk" value="<?=$idproduk;?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="harga_jual" value="<?=$hargajual;?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="harga_modal" value="<?=$modal;?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="untung" value="<?=$untung;?>" class="form-control" required>
                                                            <br>
                                                            <input type="hidden" name="idtransaksi" value="<?=$idtransaksi;?>">
                                                            <button type="submit" class="btn btn-primary" name="updatetransaksi">Submit</button>
                                                        </div>
                                                    </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete The Modal -->
                                            <div class="modal fade" id="delete<?=$idtransaksi;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Transaksi?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus <?=$namapelanggan;?>?
                                                            <input type="hidden" name="idtransaksi" value="<?=$idtransaksi;?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapustransaksi">Hapus</button>
                                                        </div>
                                                    </form>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php 
                                        };
                                        ?>
                                    </tbody>
                                </table>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
            <!-- The Modal -->
            <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Transaksi Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="date" name="tanggaltransaksi" placeholder="Tanggal Transaksi" class="form-control" required>
                    <br>
                    <!-- <input type="text" name="namapelanggan" placeholder="Nama Pelanggan" class="form-control" required>
                    <br> -->
                    <select name="pelanggannya" class="form-control">
                        <?php 
                        $ambilsemuadatapelanggannya = mysqli_query($conn, "select * from pelanggan");
                        while($fetcharray = mysqli_fetch_array($ambilsemuadatapelanggannya)){
                            $namapelanggannya = $fetcharray['namapelanggan'];
                            $idpelanggannya = $fetcharray['idpelanggan'];
                        ?>

                        <option value="<?=$idpelanggannya;?>"><?=$namapelanggannya;?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <select name="produknya" class="form-control">
                        <?php 
                        $ambilsemuadatanya = mysqli_query($conn, "select * from produk");
                        while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
                            $namaproduknya = $fetcharray['nama_item'];
                            $idproduknya = $fetcharray['idproduk'];
                        ?>

                        <option value="<?=$idproduknya;?>"><?=$namaproduknya;?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <!-- <input type="text" name="namaproduk" placeholder="Nama Produk" class="form-control" required>
                    <br> -->
                    <input type="number" name="hargajual" class="form-control" placeholder="Harga Jual" required>
                    <br>
                    <input type="number" name="modal" class="form-control" placeholder="Modal" required>
                    <br>
                    <input type="number" name="untung" class="form-control" placeholder="Untung" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="addnewtransaction">Submit</button>
                </div>
            </form>

            </div>
        </div>
    </div>
</html>
