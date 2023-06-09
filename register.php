<?php

require 'function.php';

$is_enable_supadmin = false;

$sql_check = "SELECT * FROM login WHERE role < 2 AND is_active = 1";
$result = $conn->query($sql_check);
$num_sup_admin = $result->num_rows;


$json = file_get_contents('limitsupadmin.json');
$data = json_decode($json, true);
$limit = $data['limit'];

// limit superadmin yg bisa dimasukkan
if ($num_sup_admin < $limit) {
    $is_enable_supadmin = true;
}

// cek login terdaftar apa kagak
if(isset($_POST['register'])){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    //cek apakah email sudah digunakan
    $sql_check = "SELECT * FROM login WHERE email='$email'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {    
    echo "<script>alert('email sudah digunakan!')</script>";
    } else {
    //insert data ke database
    $sql_insert = "INSERT INTO login (email, password, role, nama, is_active) VALUES ('$email', '$password', '$role', '$nama', 0)";
    
    if(($role == 1) && $num_sup_admin == 0) {
        $sql_insert = "INSERT INTO login (email, password, role, nama, is_active, is_new) VALUES ('$email', '$password', 0, '$nama', 1, 0)";
    }

    if ($conn->query($sql_insert) === TRUE) {
        header('location:login.php');
        // echo "<script>alert('Registrasi berhasil!')</script>";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
    }

    $conn->close();
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
        <title>Daftar</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Buat Akun Baru</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputLastName" name="nama" type="text" placeholder="Nama" />
                                                <label for="inputLastName">Nama</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" />
                                                <label for="inputEmail">Alamat Email</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Buatlah password" />
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPasswordConfirm" type="password" name="checkpassword" placeholder="konfirmasi password" required/>
                                                        <label for="inputPasswordConfirm">Konfirmasi Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select name="role" class="form-control" id="role">
                                                    <?php 
                                                        if($is_enable_supadmin) {
                                                            ?>
                                                            <option value="1">Super Admin</option>
                                                            <?php
                                                        }
                                                    ?>                                                
                                                    <option value="2">Admin</option>
                                                </select>
                                                <label for="role">Pilih Role</label>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block" name="register">Buat Akun</button>
                                                </div>
                                                <div class="mt-2">
                                                    <a>*Setelah melakukan pendaftaran akun, harap melakukan verifikasi kepada super admin.</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">Punya akun? Login.</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
            <?php require "footer.php"; ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
