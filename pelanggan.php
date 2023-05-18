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
        <title>Data Pelanggan</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            input[type=number] {
            -moz-appearance: textfield;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        
        <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Pelanggan</h1>


                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                    <i class="fas fa-plus me-1"></i>
                                    Pelanggan
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Alamat</th>
                                            <th>Nomor HP</th>
                                            <th>Prioritas</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php 
                                        $ambilsemuadatapelanggan = mysqli_query($conn, "select * from pelanggan order by is_active desc");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatapelanggan)){
                                            $idpelanggan = $data['idpelanggan'];
                                            $namapelanggan = $data['namapelanggan'];
                                            $alamat = $data['alamat'];
                                            $telp = $data['telp'];
                                            $prioritas = $data['prioritas'];
                                            $status = $data['is_active'];

                                            if($status == 1) {
                                                $status = "Aktif";
                                            } else {
                                                $status = "Tidak Aktif";
                                            }
                                        
                                        ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <!-- <td><?=$idpelanggan;?></td> -->
                                            <td><?=$namapelanggan;?></td>
                                            <td><?=$alamat;?></td>
                                            <td>(+62) <?=$telp;?></td>
                                            <td><?=$prioritas;?></td>
                                            <td><?=$status;?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?=$idpelanggan;?>">
                                                    Detil
                                                </button>
                                                <!-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idpelanggan;?>">
                                                    Delete
                                                </button> -->
                                            </td>
                                        </tr>
                                            <!-- Edit The Modal -->
                                            <div class="modal fade" id="edit<?=$idpelanggan;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Detil Pelanggan</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" name="namapelanggan" value="<?=$namapelanggan;?>" class="form-control" id="namapelanggan" required>
                                                                <label for="namapelanggan">Nama Pelanggan</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="text" name="alamat" value="<?=$alamat;?>" class="form-control" id="alamat" required>
                                                                <label for="alamat">Alamat</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" name="telp" class="form-control" value="<?=$telp;?>" id="telp" required>
                                                                <label for="telp">Nomor HP (+62)</label>

                                                            </div>
                                                            <input type="hidden" name="idpelanggan" value="<?=$idpelanggan;?>">
                                                            <?php 
                                                                if($status == "Aktif") {
                                                                    echo("
                                                                    <button type='submit' class='btn btn-warning' name='updatepelanggan'>Edit</button>
                                                                    
                                                                    <button type='button' class='btn btn-danger ms-3' data-bs-toggle='modal' data-bs-target='#delete$idpelanggan'>
                                                                        Non-aktifkan
                                                                    </button>
                                                                    ");
                                                                }  else {
                                                                    echo("
                                                                    
                                                                        <button type='submit' class='btn btn-warning' name='pulihpelanggan'>
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
                                            <div class="modal fade" id="delete<?=$idpelanggan;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Nonaktifkan Pelanggan?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menonaktifkan <?=$namapelanggan;?>?
                                                            <input type="hidden" name="idpelanggan" value="<?=$idpelanggan;?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapuspelanggan">Non-aktifkan</button>
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
                        <a href="pelanggan_recovery.php" style="padding-left: 25px;">Pemulihan data</a>
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
                <h4 class="modal-title">Tambah Pelanggan Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                <div class="form-floating mb-3">
                    <input type="text" name="namapelanggan" class="form-control" id="nama" placeholder="Nama Pelanggan" required>
                    <label for="nama">Nama Pelanggan</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="alamat" class="form-control" id="alamatn" placeholder="Alamat" required>
                    <label for="alamatn">Alamat</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" name="telpn" class="form-control" id="telpn" placeholder="Nomor HP" required>
                    <label for="telpn">Nomor HP (+62)</label>
                </div>
                <button type="submit" class="btn btn-primary" name="addnewcustomer">Submit</button>
                </div>
            </form>

            </div>
        </div>
    </div>
</html>
