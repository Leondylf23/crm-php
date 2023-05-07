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
        <?php require "navigation_bar.php" ?>
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
                                            <th>Nama Pelanggan</th>
                                            
                                            <th>Total Transaksi</th>
                                            <th>Metode Pembayaran</th>

                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $ambilsemuadatatransaksi = mysqli_query($conn, "SELECT t.idtransaksi, t.tanggal_transaksi, p.namapelanggan, t.totaltransaksi, mp.nama_metode FROM transaksi t INNER JOIN pelanggan p ON p.idpelanggan = t.idpelanggan LEFT JOIN metode_pembayaran mp ON mp.id = t.idmetode");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatatransaksi)){
                                            $idtransaksi = $data['idtransaksi'];
                                            $tanggaltransaksi = $data['tanggal_transaksi'];
                                            
                                            $namapelanggan = $data['namapelanggan'];
                                            
                                            $totaltransaksi = $data['totaltransaksi'];
                                            $nama_metode = $data['nama_metode'];
                                            
                                        
                                        ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$tanggaltransaksi;?></td>
                                            <td><?=$namapelanggan;?></td>
                                            <td><?=$totaltransaksi;?></td>
                                            <td><?=$nama_metode;?></td>
                                            
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
                    <div <?php if($_SESSION['role'] != 1) {echo('style="display: none;"');} ?>>
                        <a href="tansaksi_recovery.php" style="padding-left: 25px;">Pemulihan data</a>
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
                <?php 
                    $dataprodukbaru = array();
                ?>
                <div class="modal-body">
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
                    <select name="metodepembayaran" class="form-control">
                        <?php 
                        $data = mysqli_query($conn, "select * from metode_pembayaran");
                        while($fetcharray = mysqli_fetch_array($data)){
                            $metode = $fetcharray['nama_metode'];
                            $idmp = $fetcharray['id'];
                        ?>

                        <option value="<?=$idmp;?>"><?=$metode;?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <form method="post">
                        
                        <button type="submit" class="btn btn-primary mb-2" name="tambahproduk">Tambah Produk</button>
                    </from>
                    
                    <div class="mb-2">
                        <?php 
                            if(isset($_POST['tambahproduk'])) {
                                array_push($dataprodukbaru, array("namaproduk"=>"aa", "qty"=>1, "prc_satuan"=>123, "prc_total"=>321));
                            }

                            foreach($dataprodukbaru as $produk) {
                                ?>
                                <div>
                                    <a><?= $produk['namaproduk'] ?></a>
                                    <a><?= $produk['qty'] ?></a>
                                    <a><?= $produk['prc_satuan'] ?></a>
                                    <a><?= $produk['prc_total'] ?></a>
                                </div>
                        <?php   
                        }
                        ?>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" name="addnewtransaction">Submit</button>
                </div>
            </form>

            </div>
        </div>
    </div>
    <script type="javascript">
        alert("aaa");
    </script>
</html>
