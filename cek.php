<?php 
//jika belum login

if(isset($_SESSION['log'])){

} else {
    $_SESSION['msg'] = "Login terlebih dahulu!";
    header('location:index.php');
}


//jika sudah login

?>