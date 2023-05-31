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
        <title>Aktivitas</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        
        <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Aktivitas Sales</h1>


                        <div class="card mb-4">
                            <?php
                                if($_SESSION['role'] != 2) {
                                    echo('
                                    <div class="card-header">
                                        <!-- Button to Open the Modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                            <i class="fas fa-plus me-1"></i>
                                            Aktivitas
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
                                            <th>Aktivitas</th>
                                            <th>Pelanggan</th>
                                            <!-- <th>Tgl Mulai</th> -->
                                            <th>Tenggang Waktu</th>
                                            <th>Deskripsi</th>
                                            <th>Dibuat Tgl</th>
                                            <!-- <th>Kategori</th> -->
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php 
                                        $adminid = $_SESSION['userid'];
                                        if($_SESSION['role'] != 2) {
                                            $datapenjadwalan = mysqli_query($conn, "select j.id, l.iduser, l.nama, j.aktifitas, j.deskripsi, j.tgl_pelaksanaan, DATE_FORMAT(j.tgl_pelaksanaan, '%d-%m-%Y %H:%i') as tgl_plksn, j.tgl_selesai, DATE_FORMAT(j.tgl_selesai, '%d-%m-%Y %H:%i') as tgl_sls, j.added_date, DATE_FORMAT(j.added_date, '%d-%m-%Y %H:%i') as add_dt, j.status, k.id as idkategori, k.nama_kategori, j.idpelanggan as idplng, p.namapelanggan as plng, j.is_active, p.prioritas from jadwal j inner join login l on j.adminid = l.iduser inner join kategori_jadwal k on j.kategori = k.id inner join pelanggan p on j.idpelanggan = p.idpelanggan order by added_date asc");
                                        } else {
                                            $datapenjadwalan = mysqli_query($conn, "select j.id, l.iduser, l.nama, j.aktifitas, j.deskripsi, j.tgl_pelaksanaan, DATE_FORMAT(j.tgl_pelaksanaan, '%d-%m-%Y %H:%i') as tgl_plksn, j.tgl_selesai, DATE_FORMAT(j.tgl_selesai, '%d-%m-%Y %H:%i') as tgl_sls, j.added_date, DATE_FORMAT(j.added_date, '%d-%m-%Y %H:%i') as add_dt, j.status, k.id as idkategori, k.nama_kategori, j.idpelanggan as idplng, p.namapelanggan as plng, j.is_active, p.prioritas from jadwal j inner join login l on j.adminid = l.iduser inner join kategori_jadwal k on j.kategori = k.id inner join pelanggan p on j.idpelanggan = p.idpelanggan where j.is_active = 1 and adminid = $adminid order by tgl_selesai asc");
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
                                            <td><?=$deskripsi;?></td>
                                            <td><?=$adddatestr;?></td>
                                            <td><?=$status;?></td>
                                            
                                            <!-- lama
                                            
                                            <td><?=$nama;?></td>
                                            <td><?=$aktifitas;?></td>
                                            <td><?=$tglmulaistr;?></td>
                                            <td><?=$tglselesaistr;?></td>
                                            <td><?=$deskripsi;?></td>
                                            <td><?=$adddatestr;?></td>
                                            <td><?=$kategori;?></td>
                                            <td><?=$status;?></td> -->

                                            <?php 
                                            
                                            if($_SESSION['role'] != 2) {
                                                echo("
                                            <td>
                                                <div style='align-items: center; justify-content: center !important;'>
                                                <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#edit$idjadwal'>
                                                    Detail
                                                </button>
                                                <!-- <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#delete$idjadwal'>
                                                    Delete
                                                </button> -->");

                                                if($status == "Menunggu Konfirmasi") {
                                                    echo ("
                                                    
                                                    <button type='button' class='btn btn-warning ms-2' data-bs-toggle='modal' data-bs-target='#konfirmasi$idjadwal'>
                                                        Konfirmasi
                                                    </button>
                                                    
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
                                                            <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#selesai$idjadwal'>
                                                                Selesai
                                                            </button>
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
                                                        <h4 class="modal-title">Detail Aktivitas</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <?php 
                                                        $disableBtn = "";
                                                        if($status == "Selesai" || $status == "Menunggu Konfirmasi") {
                                                            $disableBtn = "disabled";
                                                        }                                                    
                                                    ?>
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <div class="form-floating mb-3">                    
                                                                <select name="admin" class="form-control" id="admin" <?= $disableBtn ?>>
                                                                 <?php 
                                                                    $data = mysqli_query($conn, "select * from login where role = 2");
                                                                    while($fetcharray = mysqli_fetch_array($data)){
                                                                        $valueue = $fetcharray['nama'];
                                                                        $idue = $fetcharray['iduser'];
                                                                ?>

                                                                    <option value="<?=$idue;?>" <?php if($idue == $iduser){echo("selected"); } ?>><?=$valueue;?></option>

                                                                <?php
                                                                    }
                                                                ?>
                                                                </select>                                                            
                                                                <label for="admin">Pilih Admin</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                    
                                                                <select name="pelanggan" class="form-control" id="plgn" <?= $disableBtn ?>>
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
                                                                <label for="plgn">Pilih Pelanggan</label>
                                                            </div>                                                            
                                                            <!-- <input type="text" name="aktifitas" value="<?=$aktifitas;?>" class="form-control" required> -->
                                                            <!-- <br> -->   
                                                            <div class="form-floating mb-3">                    
                                                                <select name="kategori" class="form-control" id="ktg" <?= $disableBtn ?>>
                                                                     <?php 
                                                                        $data = mysqli_query($conn, "select * from kategori_jadwal where is_active = 1");
                                                                        while($fetcharray = mysqli_fetch_array($data)){
                                                                            $valueke = $fetcharray['nama_kategori'];
                                                                            $idke = $fetcharray['id'];
                                                                    ?>
    
                                                                    <option value="<?=$idke;?>" <?php if($idke == $idkategori){echo("selected"); } ?>><?=$valueke;?></option>
    
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </select>                                                            
                                                                <label for="ktg">Aktivitas</label>
                                                            </div>                                                                                                                     
                                                            <!-- <input type="datetime-local" name="tglmulai" class="form-control" value="<?=$tglmulai;?>" required>
                                                            <br> -->
                                                            <div class="form-floating mb-3">                                                                                
                                                                <input type="text" name="deskripsi" value="<?=$deskripsi;?>" class="form-control" id="desc" required <?= $disableBtn ?>>
                                                                <label for="desc">Deskripsi</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                                                                                
                                                                <input type="datetime-local" name="tglselesai" class="form-control" value="<?=$tglselesai;?>" id="tgl" required <?= $disableBtn ?>>
                                                                <label for="tgl">Tenggang Waktu</label>
                                                            </div>                                                                                                                        
                                                            <input type="hidden" name="idjadwal" value="<?=$idjadwal;?>">

                                                            <?php                                                                 
                                                                if($statusAktif == 1) {
                                                                    echo("
                                                                    <button type='submit' class='btn btn-warning' name='updatejadwal' $disableBtn>Edit</button>
                                                                    
                                                                    <button type='button' class='btn btn-danger ms-3' data-bs-toggle='modal' data-bs-target='#delete$idjadwal' $disableBtn>
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
                                                        <h4 class="modal-title">Nonaktifkan Aktivitas?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menonaktifkan aktivitas <?=$kategori;?> untuk <?=$nama;?>?
                                                            <input type="hidden" name="idjadwal" value="<?=$idjadwal;?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapusjadwal">Non-aktifkan</button>
                                                        </div>
                                                    </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Selesaikan The Modal -->
                                            <div class="modal fade" id="selesai<?=$idjadwal;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Selesaikan Aktivitas?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin aktivitas <?=$kategori;?> untuk pelanggan <?=$plgn;?> sudah selesai?
                                                            <input type="hidden" name="idjadwal" value="<?=$idjadwal;?>">
                                                            <br>
                                                            <br>
                                                            <button type='submit' class='btn btn-warning' name='selesaijadwal'>
                                                                Selesai
                                                            </button>
                                                        </div>
                                                    </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Konfirmasi The Modal -->
                                            <div class="modal fade" id="konfirmasi<?=$idjadwal;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Konfirmasi Selesai Aktivitas?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin aktivitas <?=$kategori;?> dari admin <?=$nama;?> sudah selesai?
                                                            <input type="hidden" name="idjadwal" value="<?=$idjadwal;?>">
                                                            <br>
                                                            <br>
                                                            <button type='submit' class='btn btn-warning' name='konfirmasijadwal'>
                                                                Konfirmasi
                                                            </button>
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
                    <div <?php if($_SESSION['role'] > 1) {echo('style="display: none;"');} ?>>
                        <a href="penambahan_aktifitas.php" class="ms-4 link-secondary">Tambah Kategori Aktivitas</a>
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
                <h4 class="modal-title">Tambah Aktivitas Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <div class="form-floating mb-3">                                                                                
                        <select name="admin" class="form-control" id="adminn">
                            <option value="0">Pilih Admin</option>
                            <?php 
                               $data = mysqli_query($conn, "select * from login where role = 2");
                               while($fetcharray = mysqli_fetch_array($data)){
                                   $valueun = $fetcharray['nama'];
                                   $idun = $fetcharray['iduser'];
                            ?>
        
                           <option value="<?=$idun;?>"><?=$valueun;?></option>
        
                           <?php
                               }
                           ?>
                        </select>
                        <label for="adminn">Pilih Admin</label>
                    </div>
                    <div class="form-floating mb-3">                                                                                
                        <select name="pelanggan" class="form-control" id="plgnn">
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
                        <label for="plgnn">Pilih Pelanggan</label>
                    </div>                    
                    <!-- <input type="text" name="aktifitas" placeholder="Nama Aktifitas" class="form-control" required> -->
                    <!-- <br> -->
                    <div class="form-floating mb-3">                    
                        <select name="kategori" class="form-control" id="ktgn">
                            <option value="0">Pilih Aktivitas</option>
                            <?php 
                               $data = mysqli_query($conn, "select * from kategori_jadwal where is_active = 1");
                               while($fetcharray = mysqli_fetch_array($data)){
                                   $valuekn = $fetcharray['nama_kategori'];
                                   $idkn = $fetcharray['id'];
                           ?>
        
                           <option value="<?=$idkn;?>"><?=$valuekn;?></option>
        
                           <?php
                               }
                           ?>
                        </select>                                                            
                        <label for="ktgn">Aktivitas</label>
                    </div>
                    <div class="form-floating mb-3">                                                                                
                        <input type="text" name="deskripsi" placeholder="Deskripsi" class="form-control" id="descn" required>
                        <label for="descn">Deskripsi</label>
                    </div>
                    <!-- <input type="datetime-local" name="tglmulai" class="form-control" placeholder="Tanggal Mulai" required> -->
                    <!-- <br> -->
                    <div class="form-floating mb-3">                                                                                
                        <input type="datetime-local" name="tglselesai" class="form-control" placeholder="Tanggal Selesai" id="tgln" required>
                        <label for="tgln">Tenggang Waktu</label>
                    </div>
                    <button type="submit" class="btn btn-primary" name="tambahjadwal">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</html>
