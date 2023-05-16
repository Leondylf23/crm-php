<?php

require 'function.php';
require 'cek.php';

if($_SESSION['role'] != 1){
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
        <title>Data Produk</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Penambahan Aktifitas</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Aktifitas
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Aktifitas</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $ambilsemuadataproduk = mysqli_query($conn, "select * from kategori_jadwal order by is_active desc");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadataproduk)){
                                            $idkategori = $data['id'];
                                            $kategori = $data['nama_kategori'];
                                            $status = $data['is_active'];
                                            if($status == 1) {
                                                $status = "Aktif";
                                            } else {
                                                $status = "Tidak Aktif";
                                            }
                                        
                                        ?>

                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$kategori;?></td>
                                            <td><?=$status;?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?=$idkategori;?>">
                                                    Detil
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit The Modal -->
                                        <div class="modal fade" id="edit<?=$idkategori;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Detil Aktifitas</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="text" name="kategori" value="<?=$kategori;?>" class="form-control" required>
                                                            <br>
                                                            <input type="hidden" name="id" value="<?=$idkategori;?>">
                                                            
                                                            <?php 
                                                                if($status == "Aktif") {
                                                                    echo("
                                                                    <button type='submit' class='btn btn-warning' name='updatektgaktifitas'>Edit</button>
                                                                    
                                                                    <button type='button' class='btn btn-danger ms-3' data-bs-toggle='modal' data-bs-target='#delete$idkategori'>
                                                                        Non-aktifkan
                                                                    </button>
                                                                    ");
                                                                }  else {
                                                                    echo("
                                                                    
                                                                        <button type='submit' class='btn btn-warning' name='pulihktgaktifitas'>
                                                                            Aktifkan
                                                                        </button>
                                                                    
                                                                    ");
                                                                }
                                                            
                                                            ?>                                                              
                                                        </div>
                                                    </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete The Modal -->
                                            <div class="modal fade" id="delete<?=$idkategori;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Nonaktifkan Aktifitas?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menonaktifkan aktifitas <?=$kategori;?>?
                                                            <input type="hidden" name="id" value="<?=$idkategori;?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapusktgaktifitas">Non-aktifkan</button>
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
                        <a href="produk_recovery.php" style="padding-left: 25px;">Pemulihan data</a>
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
                <h4 class="modal-title">Tambah Aktifitas Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="aktifitas" placeholder="Nama Aktifitas" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="tambahktgaktifitas">Submit</button>
                </div>
            </form>

            </div>
        </div>
    </div>
</html>
