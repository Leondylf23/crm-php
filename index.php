<?php

require 'function.php';
// require 'cek.php';

if (isset($_SESSION['msg'])) {
    echo '<script> alert("'.$_SESSION['msg'].'"); </script>';
    unset($_SESSION['msg']);
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
        <title>SFA PT. XYZ</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Welcome To PT. Maju Jaya Furniture, <?= $_SESSION['userName'] ?>.</h1>
                        
                        <h4 class="mt-2 mb-3">Kegiatan Anda yang Sedang Berlangsung</h4>
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kegiatan</th>
                                            <th>Deskripsi</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $userid = $_SESSION['userid'];
                                        $logindata = mysqli_query($conn, "SELECT aktifitas, deskripsi, tgl_pelaksanaan, tgl_selesai FROM jadwal where is_active = 1 and adminid = $userid and (tgl_pelaksanaan < CURRENT_TIMESTAMP and tgl_selesai > CURRENT_TIMESTAMP)");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($logindata)){
                                            $aktifitas = $data['aktifitas'];
                                            $desc = $data['deskripsi'];
                                            $tglPlksnaan = $data['tgl_pelaksanaan'];
                                            $tglSlse = $data['tgl_selesai'];
                                        
                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$aktifitas;?></td>
                                            <td><?=$desc;?></td>
                                            <td><?=$tglPlksnaan;?></td>
                                            <td><?=$tglSlse;?></td>
                                        </tr>
                                    <?php 
                                    };
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
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
