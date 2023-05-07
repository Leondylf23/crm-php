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
        <title>Pemulihan Data Penjadwalan</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        
        <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pemulihan Data Penjadwalan</h1>
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Aktifitas</th>
                                            <th>Tgl Mulai</th>
                                            <th>Tgl Selesai</th>
                                            <th>Deskripsi</th>
                                            <th>Dibuat Tgl</th>
                                            <th>Kategori</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php 
                                        $ambilsemuadatapelanggan = mysqli_query($conn, "select j.id, l.iduser, l.nama, j.aktifitas, j.deskripsi, j.tgl_pelaksanaan, j.tgl_selesai, j.added_date, j.status, k.id as idkategori, k.nama_kategori from jadwal j inner join login l on j.adminid = l.iduser inner join kategori_jadwal k on j.kategori = k.id where j.is_active = 0");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatapelanggan)){
                                            $idjadwal = $data['id'];
                                            $iduser = $data['iduser'];
                                            $nama = $data['nama'];
                                            $aktifitas = $data['aktifitas'];
                                            $tglmulai = $data['tgl_pelaksanaan'];
                                            $tglselesai = $data['tgl_selesai'];
                                            $deskripsi = $data['deskripsi'];
                                            $adddate = $data['added_date'];
                                            $kategori = $data['nama_kategori'];
                                            $idkategori = $data['idkategori'];
                                            $status = $data['status'];
                                        ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$nama;?></td>
                                            <td><?=$aktifitas;?></td>
                                            <td><?=$tglmulai;?></td>
                                            <td><?=$tglselesai;?></td>
                                            <td><?=$deskripsi;?></td>
                                            <td><?=$adddate;?></td>
                                            <td><?=$kategori;?></td>
                                            <td><?=$status;?></td>
                                            
                                            <td>
                                                <form method="post">
                                                    <input type="hidden" name="idjadwal" value="<?=$idjadwal;?>">
                                                    <button type="submit" name="pulihjadwal" class="btn btn-warning">
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
