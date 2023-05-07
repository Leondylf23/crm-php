<?php

require 'function.php';
require 'cek.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Komplain</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Komplain/Kritik/Saran</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Komplain
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Tanggal Komplain</th>
                                            <th>Kategori</th>
                                            <th>Komplain</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $ambilsemuadatakomplain = mysqli_query($conn, 'SELECT k.idkomplain, k.nama, k.komplain, DATE_FORMAT(k.tanggal, "%d-%m-%Y") AS tanggal, kk.nama_kategori, k.idkategori FROM komplain k INNER JOIN kategori_komplain kk ON k.idkategori = kk.id WHERE k.is_active = 1;');
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatakomplain)){
                                            $idkomplain = $data['idkomplain'];
                                            $namapelanggan = $data['nama'];
                                            $tanggalkomplain = $data['tanggal'];
                                            $komplain = $data['komplain'];
                                            $kategori = $data['nama_kategori'];
                                            $idkategori = $data['idkategori'];
                                        
                                        ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <!-- <td><?=$idkomplain;?></td> -->
                                            <td><?=$namapelanggan;?></td>
                                            <td><?=$tanggalkomplain;?></td>
                                            <td><?=$kategori;?></td>
                                            <td><?=$komplain;?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idkomplain;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idkomplain;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit The Modal -->
                                        <div class="modal fade" id="edit<?=$idkomplain;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Komplain</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="text" name="namapelanggan" value="<?=$namapelanggan;?>" class="form-control" required>
                                                            <br>
                                                            <input type="text" name="komplain" value="<?=$komplain;?>" class="form-control" required>
                                                            <br>
                                                            <select name="kategori" class="form-control mb-2">
                                                                 <?php 
                                                                    $data = mysqli_query($conn, "select * from kategori_komplain");
                                                                    while($fetcharray = mysqli_fetch_array($data)){
                                                                        $valuee = $fetcharray['nama_kategori'];
                                                                        $idkke = $fetcharray['id'];
                                                                ?>

                                                                <option value="<?=$idkke;?>" <?php if($idkke == $idkategori){echo("selected"); } ?>><?=$valuee;?></option>

                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                            <input type="hidden" name="idkomplain" value="<?=$idkomplain;?>">
                                                            <button type="submit" class="btn btn-primary" name="updatekomplain">Submit</button>
                                                        </div>
                                                    </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete The Modal -->
                                            <div class="modal fade" id="delete<?=$idkomplain;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Pelanggan?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus komplain <?=$namapelanggan;?>?
                                                            <input type="hidden" name="idkomplain" value="<?=$idkomplain;?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapuskomplain">Hapus</button>
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
                        <a href="komplain_recovery.php" style="padding-left: 25px;">Pemulihan data</a>
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
                <h4 class="modal-title">Tambah Komplain Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="namapelanggan" placeholder="Nama Pelanggan" class="form-control" required>
                    <br>
                    <input type="text" name="komplain" class="form-control" placeholder="Komplain/Kritik/Saran" required>
                    <br>
                    <select name="kategori" class="form-control mb-2">
                        <?php 
                        $data = mysqli_query($conn, "select * from kategori_komplain");
                        while($fetcharray = mysqli_fetch_array($data)){
                            $valuen = $fetcharray['nama_kategori'];
                            $idkkn = $fetcharray['id'];
                        ?>

                        <option value="<?=$idkkn;?>"><?=$valuen;?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary" name="addnewcomplain">Submit</button>
                </div>
            </form>

            </div>
        </div>
    </div>
</html>
