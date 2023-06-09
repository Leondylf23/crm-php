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
        <title>Pemulihan Data Pelanggan</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        
        <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pemulihan Data Pelanggan</h1>


                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Alamat</th>
                                            <th>Telp</th>
                                            <th>Prioritas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php 
                                        $ambilsemuadatapelanggan = mysqli_query($conn, "select * from pelanggan where is_active = 0");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatapelanggan)){
                                            $idpelanggan = $data['idpelanggan'];
                                            $namapelanggan = $data['namapelanggan'];
                                            $alamat = $data['alamat'];
                                            $telp = $data['telp'];
                                            $prioritas = $data['prioritas'];
                                            // $idp = $data['idpelanggan'];
                                        
                                        ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <!-- <td><?=$idpelanggan;?></td> -->
                                            <td><?=$namapelanggan;?></td>
                                            <td><?=$alamat;?></td>
                                            <td>(+62) <?=$telp;?></td>
                                            <td><?=$prioritas;?></td>
                                            <td>
                                                <form method="post">
                                                    <input type="hidden" name="idpelanggan" value="<?=$idpelanggan;?>">
                                                    <button type="submit" name="pulihpelanggan" class="btn btn-warning">
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
</html>
