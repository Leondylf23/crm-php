<?php 
session_start();
// Koneksi DB
if(!isset($_SESSION['userid'])) {
    $_SESSION['userid'] = "";
    $_SESSION['userName'] = "Sales Forces Automation";
} else {
    // echo $_SESSION['userid'] . " - " . $_SESSION['userName'];
}
$conn = mysqli_connect("localhost","root","","crm");

// //Menambah User Baru
// if(isset($_POST['createaccount'])){
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     $addtotablelogin = mysqli_query($conn, "insert into login (email, password) values('$email','$password')");
//     if($addtotablelogin){
//         header('location:register.php');
//     } else{
//         echo 'Gagal';
//         header('location:register.php');
//     }
// }

//Menambah pelanggan baru
if(isset($_POST['addnewcustomer'])){
    $namapelanggan = $_POST['namapelanggan'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];

    $addtotable = mysqli_query($conn, "insert into pelanggan (namapelanggan, alamat, telp) values('$namapelanggan','$alamat', '$telp')");
    if($addtotable){
        header('location:pelanggan.php');
    } else{
        echo 'Gagal';
        header('location:pelanggan.php');
    }
}

//Menambah Produk Baru
if(isset($_POST['addnewproduct'])){
    $kodeproduk = $_POST['kodeproduk'];
    $namaproduk = $_POST['namaproduk'];
    $jenisproduk = $_POST['jenisproduk'];
    $merkproduk = $_POST['merkproduk'];
    $tipeitem = $_POST['tipeitem'];
    $satuan = $_POST['satuan'];
    $hargapokok = $_POST['hargapokok'];
    $hargajual = $_POST['hargajual'];
    $keterangan = $_POST['keterangan'];

    $addtotable = mysqli_query($conn, "insert into produk (kode_produk, nama_item, jenis, merek, tipe_item, satuan, harga_pokok, harga_jual, keterangan) values('$kodeproduk','$namaproduk', '$jenisproduk', '$merkproduk', '$tipeitem', '$satuan', '$hargapokok', '$hargajual', '$keterangan')");
    if($addtotable){
        header('location:produk.php');
    } else{
        echo 'Gagal';
        header('location:produk.php');
    }
}

//Menambah Data Transaksi
if(isset($_POST['addnewtransaction'])){
    $tanggaltransaksi = $_POST['tanggaltransaksi'];
    // $namapelanggan = $_POST['namapelanggan'];
    $pelanggannya = $_POST['pelanggannya'];
    $produknya = $_POST['produknya'];
    $hargajual = $_POST['hargajual'];
    $modal = $_POST['modal'];
    $untung = $_POST['untung'];

    $addtotransaksi = mysqli_query($conn, "insert into transaksi (tanggal_transaksi, idpelanggan, idproduk, harga_jual, harga_modal, untung) values('$tanggaltransaksi','$pelanggannya','$produknya', '$hargajual','$modal','$untung')");
    if($addtotransaksi){
        header('location:transaksi.php');
    } else{
        echo 'Gagal';
        header('location:transaksi.php');
    }
}

//Menambah Komplain Baru
if(isset($_POST['addnewcomplain'])){
    $namapelanggan = $_POST['namapelanggan'];
    $tanggalkomplain = $_POST['tanggalkomplain'];
    $komplain = $_POST['komplain'];

    $addtotable = mysqli_query($conn, "insert into komplain (nama, tanggal, komplain) values('$namapelanggan','$tanggalkomplain', '$komplain')");
    if($addtotable){
        header('location:komplain.php');
    } else{
        echo 'Gagal';
        header('location:komplain.php');
    }
}

//Update Info Pelanggan
if(isset($_POST['updatepelanggan'])){
    $idpelanggan = $_POST['idpelanggan'];
    $namapelanggan = $_POST['namapelanggan'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];

    $update = mysqli_query($conn, "update pelanggan set namapelanggan='$namapelanggan', alamat='$alamat', telp='$telp' where idpelanggan = '$idpelanggan'");
    if($update){
        header('location:pelanggan.php');
    } else{
        echo 'Gagal';
        header('location:pelanggan.php');
    }
}

//Hapus Pelanggan dari database "Pelanggan"
if(isset($_POST['hapuspelanggan'])){
    $idpelanggan = $_POST['idpelanggan'];

    $hapus = mysqli_query($conn, "delete from pelanggan where idpelanggan = '$idpelanggan'");
    if($hapus){
        header('location:pelanggan.php');
    } else{
        echo 'Gagal';
        header('location:pelanggan.php');
    }
}

//Update Info Produk
if(isset($_POST['updateproduk'])){
    $idproduk = $_POST['idproduk'];
    $kodeproduk = $_POST['kodeproduk'];
    $namaproduk = $_POST['namaproduk'];
    $jenisproduk = $_POST['jenisproduk'];
    $merkproduk = $_POST['merkproduk'];
    $tipeitem = $_POST['tipeitem'];
    $satuan = $_POST['satuan'];
    $hargapokok = $_POST['hargapokok'];
    $hargajual = $_POST['hargajual'];
    $keterangan = $_POST['keterangan'];

    $updateproduk = mysqli_query($conn, "update produk set kode_produk='$kodeproduk', nama_item='$namaproduk', jenis='$jenisproduk', merek='$merkproduk', tipe_item='$tipeitem', satuan='$satuan', harga_pokok='$hargapokok', harga_jual='$hargajual', keterangan='$keterangan' where idproduk = '$idproduk'");
    if($updateproduk){
        header('location:produk.php');
    } else{
        echo 'Gagal';
        header('location:produk.php');
    }
}

//Hapus Produk dari database "Produk"
if(isset($_POST['hapusproduk'])){
    $idproduk = $_POST['idproduk'];

    $hapusproduk = mysqli_query($conn, "delete from produk where idproduk = '$idproduk'");
    if($hapusproduk){
        header('location:produk.php');
    } else{
        echo 'Gagal';
        header('location:produk.php');
    }
}

//Update Info Transaksi
if(isset($_POST['updatetransaksi'])){
    $idtransaksi = $_POST['idtransaksi'];
    $tanggaltransaksi = $_POST['tanggal_transaksi'];
    $namapelanggan = $_POST['nama_pelanggan'];
    $idproduk = $_POST['idproduk'];
    $hargajual = $_POST['harga_jual'];
    $modal = $_POST['harga_modal'];
    $untung = $_POST['untung'];

    $updatetransaksi = mysqli_query($conn, "update transaksi set tanggal_transaksi='$tanggaltransaksi', nama_pelanggan='$namapelanggan', idproduk='$idproduk', harga_jual='$hargajual', harga_modal='$modal', untung='$untung' where idtransaksi = '$idtransaksi'");
    if($updatetransaksi){
        header('location:transaksi.php');
    } else{
        echo 'Gagal';
        header('location:transaksi.php');
    }
}

//Hapus transaksi dari database "Transaksi"
if(isset($_POST['hapustransaksi'])){
    $idtransaksi = $_POST['idtransaksi'];

    $hapustransaksi = mysqli_query($conn, "delete from transaksi where idtransaksi = '$idtransaksi'");
    if($hapustransaksi){
        header('location:transaksi.php');
    } else{
        echo 'Gagal';
        header('location:transaksi.php');
    }
}
?>