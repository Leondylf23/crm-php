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
                                    <i class="fas fa-plus me-1"></i>
                                    Komplain
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
                                            <th>Solusi</th>
                                            <th>Tgl Solusi Diselesaikan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $ambilsemuadatakomplain = mysqli_query($conn, 'SELECT k.idkomplain, k.nama, k.komplain, DATE_FORMAT(k.tanggal, "%d-%m-%Y") AS tanggal, kk.nama_kategori, k.idkategori, k.solusi, DATE_FORMAT(k.tgl_solusi, "%Y-%m-%d") AS tgl_solusi, DATE_FORMAT(k.tgl_solusi, "%d-%m-%Y") AS tanggal_sls, k.is_active FROM komplain k INNER JOIN kategori_komplain kk ON k.idkategori = kk.id ORDER BY is_active DESC, k.tanggal DESC');
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatakomplain)){
                                            $idkomplain = $data['idkomplain'];
                                            $namapelanggan = $data['nama'];
                                            $tanggalkomplain = $data['tanggal'];
                                            $komplain = $data['komplain'];
                                            $kategori = $data['nama_kategori'];
                                            $idkategori = $data['idkategori'];
                                            $solusi = $data['solusi'];
                                            $status = $data['is_active'];
                                            $tglsolusi = $data['tanggal_sls'];
                                            $tglsolusidata = $data['tgl_solusi'];

                                            if($status == 1) {
                                                $status = "Aktif";
                                            } else {
                                                $status = "Tidak Aktif";
                                            }
                                        
                                        ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <!-- <td><?=$idkomplain;?></td> -->
                                            <td><?=$namapelanggan;?></td>
                                            <td><?=$tanggalkomplain;?></td>
                                            <td><?=$kategori;?></td>
                                            <td><?=$komplain;?></td>
                                            <td><?=$solusi;?></td>
                                            <td><?=$tglsolusi;?></td>
                                            <td><?=$status;?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?=$idkomplain;?>">
                                                    Detail
                                                </button>
                                                <!-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idkomplain;?>">
                                                    Delete
                                                </button> -->
                                            </td>
                                        </tr>

                                        <!-- Edit The Modal -->
                                        <div class="modal fade" id="edit<?=$idkomplain;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Detail Komplain</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <div class="form-floating mb-3">                                                                                
                                                                <input type="text" name="namapelanggan" value="<?=$namapelanggan;?>" class="form-control" id="plgn" required>
                                                                <label for="plgn">Nama Pelanggan</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                                                                                
                                                                <input type="text" name="komplain" value="<?=$komplain;?>" class="form-control" id="kmpln" required>
                                                                <label for="kmpln">Isi Komplain/Kritik/Saran</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                                                                                
                                                                <input type="text" name="solusi" value="<?=$solusi;?>" class="form-control" id="sls" required>
                                                                <label for="sls">Solusi</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                                                                                
                                                                <input type="date" name="tglsolusi" class="form-control" value="<?=$tglsolusidata;?>" id="tglsls" required>
                                                                <label for="tglsls">Tanggal Selesai Solusi</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                    
                                                                <select name="kategori" class="form-control mb-2" id="ktg">
                                                                     <?php 
                                                                        $data = mysqli_query($conn, "select * from kategori_komplain where is_active = 1");
                                                                        while($fetcharray = mysqli_fetch_array($data)){
                                                                            $valuee = $fetcharray['nama_kategori'];
                                                                            $idkke = $fetcharray['id'];
                                                                    ?>
    
                                                                    <option value="<?=$idkke;?>" <?php if($idkke == $idkategori){echo("selected"); } ?>><?=$valuee;?></option>
    
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </select>                                                            
                                                                <label for="ktg">Kategori Komplain</label>
                                                            </div>
                                                            <input type="hidden" name="idkomplain" value="<?=$idkomplain;?>">
                                                            <?php 
                                                                if($status == "Aktif") {
                                                                    echo("
                                                                    <button type='submit' class='btn btn-warning' name='updatekomplain'>Edit</button>
                                                                    
                                                                    <button type='button' class='btn btn-danger ms-3' data-bs-toggle='modal' data-bs-target='#delete$idkomplain'>
                                                                        Non-aktifkan
                                                                    </button>
                                                                    ");
                                                                }  else {
                                                                    echo("
                                                                    
                                                                        <button type='submit' class='btn btn-warning' name='pulihkomplain'>
                                                                            Aktifkan
                                                                        </button>
                                                                    
                                                                    ");
                                                                }
                                                            
                                                            ?>
                                                            <!-- <button type="submit" class="btn btn-primary" name="updatekomplain">Submit</button> -->
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
                                                        <h4 class="modal-title">Nonaktifkan Komplain?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menonaktifkan komplain <?=$namapelanggan;?>?
                                                            <input type="hidden" name="idkomplain" value="<?=$idkomplain;?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapuskomplain">Non-aktifkan</button>
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
                    <!-- <div <?php if($_SESSION['role'] != 1) {echo('style="display: none;"');} ?>>
                        <a href="komplain_recovery.php" style="padding-left: 25px;">Pemulihan data</a>
                    </div> -->
                    <div <?php if($_SESSION['role'] > 1) {echo('style="display: none;"');} ?>>
                        <a href="penambahan_kategori_komplain.php" class="ms-4 link-secondary">Tambah Kategori Aktivitas</a>
                        <!-- <a href="penjadwalan_recovery.php" style="padding-left: 25px;">Pemulihan data</a> -->
                    </div>
                </main>
                <?php require "footer.php"; ?>
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
                    <div class="form-floating mb-3">                                                                                
                        <input type="text" name="namapelanggan" placeholder="Nama Pelanggan" class="form-control" id="plgnn" required>
                        <label for="plgnn">Nama Pelanggan</label>
                    </div>
                    <div class="form-floating mb-3">                                                                                
                        <input type="text" name="komplain" class="form-control" placeholder="Komplain/Kritik/Saran" id="kmplnn" required>
                        <label for="kmplnn">Isi Komplain/Kritik/Saran</label>
                    </div>
                    <div class="form-floating mb-3">                                                                                
                        <input type="text" name="solusi" class="form-control" placeholder="Solusi" id="slsn" required>
                        <label for="slsn">Solusi</label>
                    </div>
                    <div class="form-floating mb-3">                                                                                
                        <input type="date" name="tglsolusi" class="form-control" placeholder="Tanggal Selesai Solusi" id="tglslsn" required>
                        <label for="tglslsn">Tanggal Selesai Solusi</label>
                    </div>
                    <div class="form-floating mb-3">                                                                                
                        <select name="kategori" class="form-control mb-2" id="ktgn">
                            <?php 
                            $data = mysqli_query($conn, "select * from kategori_komplain where is_active = 1");
                            while($fetcharray = mysqli_fetch_array($data)){
                                $valuen = $fetcharray['nama_kategori'];
                                $idkkn = $fetcharray['id'];
                            ?>
    
                            <option value="<?=$idkkn;?>"><?=$valuen;?></option>
    
                            <?php
                            }
                            ?>
                        </select>
                        <label for="ktgn">Kategori Komplain</label>
                    </div>
                    <button type="submit" class="btn btn-primary" name="addnewcomplain">Submit</button>
                </div>
            </form>

            </div>
        </div>
    </div>
</html>
