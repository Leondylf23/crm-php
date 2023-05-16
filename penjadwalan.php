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
        <title>Aktifitas</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        
        <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Aktifitas</h1>


                        <div class="card mb-4">
                            <?php
                                if($_SESSION['role'] == 1) {
                                    echo('
                                    <div class="card-header">
                                        <!-- Button to Open the Modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                        Tambah Aktifitas
                                        </button>
                                    </div>
                                    ');
                                }
                            ?>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Aktifitas</th>
                                            <th>Pelanggan</th>
                                            <!-- <th>Tgl Mulai</th> -->
                                            <th>Tenggang Waktu</th>
                                            <!-- <th>Deskripsi</th> -->
                                            <th>Dibuat Tgl</th>
                                            <!-- <th>Kategori</th> -->
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php 
                                        $adminid = $_SESSION['userid'];
                                        if($_SESSION['role'] == 1) {
                                            $datapenjadwalan = mysqli_query($conn, "select j.id, l.iduser, l.nama, j.aktifitas, j.deskripsi, j.tgl_pelaksanaan, DATE_FORMAT(j.tgl_pelaksanaan, '%d-%m-%Y %H:%i') as tgl_plksn, j.tgl_selesai, DATE_FORMAT(j.tgl_selesai, '%d-%m-%Y %H:%i') as tgl_sls, j.added_date, DATE_FORMAT(j.added_date, '%d-%m-%Y %H:%i') as add_dt, j.status, k.id as idkategori, k.nama_kategori, j.idpelanggan as idplng, p.namapelanggan as plng, j.is_active, p.prioritas from jadwal j inner join login l on j.adminid = l.iduser inner join kategori_jadwal k on j.kategori = k.id inner join pelanggan p on j.idpelanggan = p.idpelanggan");
                                        } else {
                                            $datapenjadwalan = mysqli_query($conn, "select j.id, l.iduser, l.nama, j.aktifitas, j.deskripsi, j.tgl_pelaksanaan, DATE_FORMAT(j.tgl_pelaksanaan, '%d-%m-%Y %H:%i') as tgl_plksn, j.tgl_selesai, DATE_FORMAT(j.tgl_selesai, '%d-%m-%Y %H:%i') as tgl_sls, j.added_date, DATE_FORMAT(j.added_date, '%d-%m-%Y %H:%i') as add_dt, j.status, k.id as idkategori, k.nama_kategori, j.idpelanggan as idplng, p.namapelanggan as plng, j.is_active, p.prioritas from jadwal j inner join login l on j.adminid = l.iduser inner join kategori_jadwal k on j.kategori = k.id inner join pelanggan p on j.idpelanggan = p.idpelanggan where j.is_active = 1 and adminid = $adminid");
                                        }
                                        $i = 1;
                                        while($data=mysqli_fetch_array($datapenjadwalan)){
                                            $idjadwal = $data['id'];
                                            $iduser = $data['iduser'];
                                            $nama = $data['nama'];

                                            $aktifitas = $data['aktifitas'];

                                            $tglmulai = $data['tgl_pelaksanaan'];
                                            $tglmulaistr = $data['tgl_plksn'];
                                            
                                            $tglselesai = $data['tgl_selesai'];
                                            $tglselesaistr = $data['tgl_sls'];

                                            $deskripsi = $data['deskripsi'];
                                            $adddate = $data['added_date'];
                                            $adddatestr = $data['add_dt'];
                                            $kategori = $data['nama_kategori'];
                                            $idkategori = $data['idkategori'];
                                            $status = $data['status'];
                                            $plgn = $data['plng'];
                                            $idplgn = $data['idplng'];
                                            $statusAktif = $data['is_active'];

                                            $tier = $data['prioritas'];

                                            switch ($status) {
                                                case 1:
                                                    $status = "Belum Dilaksanankan";
                                                    break;
                                                case 2:
                                                    $status = "Menunggu Konfirmasi";
                                                    break;
                                                case 3:
                                                    $status = "Selesai";
                                                    break;
                                                default:
                                                    $status = "Unknown";
                                                    break;
                                            }

                                            if($statusAktif == 0) {
                                                $status = "Tidak Aktif";
                                            }
                                        ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$nama;?></td>
                                            <td><?=$kategori;?></td>
                                            <td><?=$plgn;?> - <?=$tier;?></td>
                                            <td><?=$tglselesaistr;?></td>
                                            <td><?=$adddatestr;?></td>
                                            <td><?=$status;?></td>
                                            
                                            <!-- lama
                                            <td><?=$i++;?></td>
                                            <td><?=$nama;?></td>
                                            <td><?=$aktifitas;?></td>
                                            <td><?=$tglmulaistr;?></td>
                                            <td><?=$tglselesaistr;?></td>
                                            <td><?=$deskripsi;?></td>
                                            <td><?=$adddatestr;?></td>
                                            <td><?=$kategori;?></td>
                                            <td><?=$status;?></td> -->

                                            <?php 
                                            
                                            if($_SESSION['role'] == 1) {
                                                echo("
                                            <td>
                                                <div style='align-items: center; justify-content: center !important;'>
                                                <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#edit$idjadwal'>
                                                    Detil
                                                </button>
                                                <!-- <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#delete$idjadwal'>
                                                    Delete
                                                </button> -->");

                                                if($status == "Menunggu Konfirmasi") {
                                                    echo ("
                                                    
                                                    <form method='post'>
                                                        <input type='hidden' name='idjadwal' value='$idjadwal'>
                                                        <button type='submit' class='btn btn-warning' name='konfirmasijadwal'>
                                                            Konfirmasi
                                                        </button>
                                                    </form>
                                                    
                                                    ");
                                                }

                                                echo ("
                                                </div>
                                                </td>
                                                
                                                ");
                                                } else {
                                                    if ($status == "Belum Dilaksanankan" && $_SESSION['role'] != 1) {
                                                        echo ("
                                                        <td>
                                                            <form method='post'>
                                                            <input type='hidden' name='idjadwal' value='$idjadwal'>
                                                            <button type='submit' class='btn btn-warning' name='selesaijadwal'>
                                                                Selesai
                                                            </button>
                                                            </form>
                                                        </td>
                                                        ");
                                                    } else {
                                                        echo ("
                                                        <td>
                                                            <b>-</b>
                                                        </td>
                                                        ");
                                                    }
                                                }
                                                ?>
                                            
                                        </tr>
                                            <!-- Edit The Modal -->
                                            <div class="modal fade" id="edit<?=$idjadwal;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Jadwal</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <select name="admin" class="form-control">
                                                                 <?php 
                                                                    $data = mysqli_query($conn, "select * from login");
                                                                    while($fetcharray = mysqli_fetch_array($data)){
                                                                        $valueue = $fetcharray['nama'];
                                                                        $idue = $fetcharray['iduser'];
                                                                ?>

                                                                <option value="<?=$idue;?>" <?php if($idue == $iduser){echo("selected"); } ?>><?=$valueue;?></option>

                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                            <br>
                                                            <select name="pelanggan" class="form-control">
                                                                 <?php 
                                                                    $data = mysqli_query($conn, "select * from pelanggan");
                                                                    while($fetcharray = mysqli_fetch_array($data)){
                                                                        $valuep = $fetcharray['namapelanggan'];
                                                                        $tiere = $fetcharray['prioritas'];
                                                                        $idp = $fetcharray['idpelanggan'];
                                                                ?>

                                                                <option value="<?=$idp;?>" <?php if($idp == $idplgn){echo("selected"); } ?>><?=$valuep;?> - <?=$tiere;?></option>

                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                            <br>
                                                            <!-- <input type="text" name="aktifitas" value="<?=$aktifitas;?>" class="form-control" required> -->
                                                            <!-- <br> -->
                                                            <!-- <input type="text" name="deskripsi" value="<?=$deskripsi;?>" class="form-control" required> -->
                                                            <!-- <br> -->
                                                            <select name="kategori" class="form-control">
                                                                 <?php 
                                                                    $data = mysqli_query($conn, "select * from kategori_jadwal");
                                                                    while($fetcharray = mysqli_fetch_array($data)){
                                                                        $valueke = $fetcharray['nama_kategori'];
                                                                        $idke = $fetcharray['id'];
                                                                ?>

                                                                <option value="<?=$idke;?>" <?php if($idke == $idkategori){echo("selected"); } ?>><?=$valueke;?></option>

                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                            <br>
                                                            <!-- <input type="datetime-local" name="tglmulai" class="form-control" value="<?=$tglmulai;?>" required>
                                                            <br> -->
                                                            <input type="datetime-local" name="tglselesai" class="form-control" value="<?=$tglselesai;?>" required>
                                                            <br>
                                                            <input type="hidden" name="idjadwal" value="<?=$idjadwal;?>">

                                                            <?php 
                                                                if($statusAktif == 1) {
                                                                    echo("
                                                                    <button type='submit' class='btn btn-primary' name='updatejadwal'>Submit</button>
                                                                    
                                                                    <button type='button' class='btn btn-danger ms-3' data-bs-toggle='modal' data-bs-target='#delete$idjadwal'>
                                                                        Non-aktifkan
                                                                    </button>
                                                                    ");
                                                                }  else {
                                                                    echo("
                                                                    
                                                                        <button type='submit' class='btn btn-warning' name='pulihjadwal'>
                                                                            Aktifkan
                                                                        </button>
                                                                    
                                                                    ");
                                                                }
                                                            
                                                            ?>          

                                                            <!-- <button type="submit" class="btn btn-primary" name="updatejadwal">Submit</button> -->
                                                        </div>
                                                    </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete The Modal -->
                                            <div class="modal fade" id="delete<?=$idjadwal;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Jadwal?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus jadwal <?=$aktifitas;?>?
                                                            <input type="hidden" name="idjadwal" value="<?=$idjadwal;?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapusjadwal">Hapus</button>
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
                        <a href="penjadwalan_recovery.php" style="padding-left: 25px;">Pemulihan data</a>
                    </div> -->
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
                <h4 class="modal-title">Tambah Penjadwalan Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <select name="admin" class="form-control">
                        <option value="0">Pilih Admin</option>
                        <?php 
                           $data = mysqli_query($conn, "select * from login");
                           while($fetcharray = mysqli_fetch_array($data)){
                               $valueun = $fetcharray['nama'];
                               $idun = $fetcharray['iduser'];
                       ?>
    
                       <option value="<?=$idun;?>"><?=$valueun;?></option>
    
                       <?php
                           }
                       ?>
                    </select>
                    <br>
                    <select name="pelanggan" class="form-control">
                        <option value="0">Pilih Pelanggan</option>
                        <?php 
                           $data = mysqli_query($conn, "select * from pelanggan");
                           while($fetcharray = mysqli_fetch_array($data)){
                               $valuepl = $fetcharray['namapelanggan'];
                               $tiera = $fetcharray['prioritas'];
                               $idpl = $fetcharray['idpelanggan'];
                       ?>
    
                       <option value="<?=$idpl;?>"><?=$valuepl;?> - <?=$tiera;?></option>
    
                       <?php
                           }
                       ?>
                    </select>
                    <br>
                    <!-- <input type="text" name="aktifitas" placeholder="Nama Aktifitas" class="form-control" required> -->
                    <!-- <br> -->
                    <!-- <input type="text" name="deskripsi" placeholder="Deskripsi" class="form-control" required> -->
                    <!-- <br> -->
                    <select name="kategori" class="form-control">
                        <option value="0">Pilih Aktifitas</option>
                        <?php 
                           $data = mysqli_query($conn, "select * from kategori_jadwal");
                           while($fetcharray = mysqli_fetch_array($data)){
                               $valuekn = $fetcharray['nama_kategori'];
                               $idkn = $fetcharray['id'];
                       ?>
    
                       <option value="<?=$idkn;?>"><?=$valuekn;?></option>
    
                       <?php
                           }
                       ?>
                    </select>
                    <br>
                    <!-- <input type="datetime-local" name="tglmulai" class="form-control" placeholder="Tanggal Mulai" required> -->
                    <!-- <br> -->
                    <input type="datetime-local" name="tglselesai" class="form-control" placeholder="Tanggal Selesai" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="tambahjadwal">Submit</button>
                </div>
            </form>

            </div>
        </div>
    </div>
</html>
