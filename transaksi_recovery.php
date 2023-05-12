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
                        <h1 class="mt-4">Pemulihan Data Transaksi</h1>
                        <div class="card mb-4">
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
                                        $ambilsemuadatatransaksi = mysqli_query($conn, "SELECT t.idtransaksi, t.tanggal_transaksi, DATE_FORMAT(t.tanggal_transaksi, '%d-%m-%Y %H:%i') as tgl_formated, p.namapelanggan, t.totaltransaksi, mp.nama_metode, p.idpelanggan FROM transaksi t INNER JOIN pelanggan p ON p.idpelanggan = t.idpelanggan LEFT JOIN metode_pembayaran mp ON mp.id = t.idmetode where t.is_active = 0");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatatransaksi)){
                                            $idtransaksi = $data['idtransaksi'];
                                            $tanggaltransaksi = $data['tanggal_transaksi'];
                                            $tanggaltransaksif = $data['tgl_formated'];
                                            
                                            $namapelanggan = $data['namapelanggan'];
                                            $idpelanggan = $data['idpelanggan'];
                                            
                                            $totaltransaksi = $data['totaltransaksi'];
                                            $nama_metode = $data['nama_metode'];
                                            
                                        
                                        ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$tanggaltransaksif;?></td>
                                            <td><?=$namapelanggan;?></td>
                                            <td><?=$totaltransaksi;?></td>
                                            <td><?=$nama_metode;?></td>
                                            
                                            <td>
                                                <form method=post>
                                                    <input type="hidden" name="idtransaksi" value="<?=$idtransaksi;?>">
                                                    <input type="hidden" name="idpelanggan" value="<?=$idpelanggan;?>">
                                                    <button type="submit" class="btn btn-warning" name="pulihtransaksi">
                                                        Pulihkan
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
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
</html>
