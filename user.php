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
        <title>Profil</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        
        <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 mb-4">Profil</h1>

                        <?php
                            $nama = "";
                            $email = "";
                            $id = $_SESSION['userid'];

                            $sqldata = mysqli_query($conn, "select email, nama from login where iduser = $id limit 1");
                            while($fetcharray = mysqli_fetch_array($sqldata)){
                                $nama = $fetcharray['nama'];
                                $email = $fetcharray['email'];
                            }
                        ?>
                        <div class="mb-4">
                            <h4 class="mb-3">General</h4>
                            <form method="post">
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="nama" id="inputNama" type="text" placeholder="Nama Lengkap" value="<?= $nama ?>" />
                                    <label for="inputNama">Nama</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="email" id="inputEmail" type="email" placeholder="name@example.com" value="<?= $email ?>" disabled/>
                                    <label for="inputEmail">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <button class="btn btn-primary" name="ubahprofil">Ubah</button>
                                </div>
                            </form>
                        </div>

                        <div>
                            <h4 class="mb-3">Password</h4>
                            <form method="post">
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="oldpass" id="inputOldPass" type="password" />
                                    <label for="inputOldPass">Password Lama</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="newpass" id="inputNewPass" type="password"/>
                                    <label for="inputNewPass">Password Baru</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="confirmpass" id="inputCounfirmPass" type="password"/>
                                    <label for="inputConfirmPass">Konfirmasi Password Baru</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <button class="btn btn-primary" name="ubahpassword">Ubah</button>
                                </div>
                            </form>
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
