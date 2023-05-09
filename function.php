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
    $pelangganid = $_POST['pelanggannya'];
    $pembayaranid = $_POST['metodepembayaran'];
    $totalprice = $_POST['totalprice'];

    $totalPrdk = $_POST['totaldata'];
    echo "<script> alert($totalPrdk); </script>";
    $produk = array();

    for ($i=0; $i < $totalPrdk; $i++) { 
        $prdk = "prdk-$i";
        $qty = "qty-$i";
        $prctotal = "prctotal-$i";
        $deleted = "deleted-$i";

        if(!$deleted) {
            array_push($produk, array("produk"=>$_POST[$prdk], "qty"=>$_POST[$qty], "prc-total"=>$_POST[$prctotal]));
        }
    }
    // $tes = $produk[0]['produk'];

    $addtotransaksi = mysqli_query($conn, "insert into transaksi (idpelanggan, idmetode, totaltransaksi) values('$pelangganid','$pembayaranid','$totalprice')");
    if($addtotransaksi){

        foreach ($produk as $a) {
            $idtransaksi = mysqli_insert_id($conn);
            $prdkid = $a['produk'];
            $qtyData = $a['qty'];
            $prcTotal = $a['prc-total'];

            $addtotransaksidetail = mysqli_query($conn, "insert into transaksi_detail (idtransaksi, idproduk, qty, totalharga) values('$idtransksi','$produk','$prcTotal')");
    
            if($addtotransaksidetail) {
                header('location:transaksi.php');    
            } else {
                echo '<script> alert("Gagal"); </script>';
                header('location:transaksi.php');
            }
        }
    } else{
        echo '<script> alert("Gagal"); </script>';
        header('location:transaksi.php');
    }
}

//Menambah Komplain Baru
if(isset($_POST['addnewcomplain'])){
    $namapelanggan = $_POST['namapelanggan'];
    $komplain = $_POST['komplain'];
    $katg_komplain = $_POST['kategori'];

    $addtotable = mysqli_query($conn, "insert into komplain (nama, komplain, idkategori) values('$namapelanggan', '$komplain', '$katg_komplain')");
    if($addtotable){
        header('location:komplain.php');
    } else{
        echo 'Gagal';
        header('location:komplain.php');
    }
}

//Edit Komplain
if(isset($_POST['updatekomplain'])){
    $namapelanggan = $_POST['namapelanggan'];
    $komplain = $_POST['komplain'];
    $katg_komplain = $_POST['kategori'];
    $idkomplainedit = $_POST['idkomplain'];

    $addtotable = mysqli_query($conn, "update komplain set namapelanggan='$namapelanggan', komplain='$komplain', idkategori='$katg_komplain' where idkomplain = '$idkomplainedit'");
    if($addtotable){
        header('location:komplain.php');
    } else{
        echo 'Gagal';
        header('location:komplain.php');
    }
}

//Delete Komplain
if(isset($_POST['hapuskomplain'])){
    $idkomplaindelete = $_POST['idkomplain'];

    $addtotable = mysqli_query($conn, "update komplain set is_active=0 where idkomplain = '$idkomplaindelete'");
    if($addtotable){
        header('location:komplain.php');
    } else{
        echo 'Gagal';
        header('location:komplain.php');
    }
}

//Pulihkan Komplain
if(isset($_POST['pulihkomplain'])){
    $idkomplainpulih = $_POST['idkomplain'];

    $addtotable = mysqli_query($conn, "update komplain set is_active=1 where idkomplain = '$idkomplainpulih'");
    if($addtotable){
        header('location:komplain_recovery.php');
    } else{
        echo 'Gagal';
        header('location:komplain_recovery.php');
    }
}

//Menambah Jadwal Baru
if(isset($_POST['tambahjadwal'])){
    $admin = $_POST['admin'];
    $aktifitas = $_POST['aktifitas'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $tglmulai = $_POST['tglmulai'];
    $tglselesai = $_POST['tglselesai'];

    $addtotable = mysqli_query($conn, "insert into jadwal (adminid, aktifitas, deskripsi, tgl_pelaksanaan, tgl_selesai, kategori) values ('$admin', '$aktifitas', '$deskripsi', '$tglmulai', '$tglselesai', '$kategori')");
    if($addtotable){
        header('location:penjadwalan.php');
    } else{
        echo 'Gagal';
        header('location:penjadwalan.php');
    }
}

//update Jadwal
if(isset($_POST['updatejadwal'])){
    $idjadwal = $_POST['idjadwal'];
    $admin = $_POST['admin'];
    $aktifitas = $_POST['aktifitas'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $tglmulai = $_POST['tglmulai'];
    $tglselesai = $_POST['tglselesai'];

    $addtotable = mysqli_query($conn, "update jadwal set adminid = '$admin', aktifitas = '$aktifitas', deskripsi = '$deskripsi', tgl_pelaksanaan = '$tglmulai', tgl_selesai = '$tglselesai', kategori = '$kategori' where id = '$idjadwal')");
    if($addtotable){
        header('location:penjadwalan.php');
    } else{
        echo 'Gagal';
        header('location:penjadwalan.php');
    }
}

//hapus Jadwal
if(isset($_POST['hapusjadwal'])){
    $idjadwal = $_POST['idjadwal'];
    
    $addtotable = mysqli_query($conn, "update jadwal set is_active = 0 where id = $idjadwal");
    if($addtotable){
        header('location:penjadwalan.php');
    } else{
        echo 'Gagal';
        header('location:penjadwalan.php');
    }
}

//Pemulihan Jadwal
if(isset($_POST['pulihjadwal'])){
    $idjadwal = $_POST['idjadwal'];
    
    $addtotable = mysqli_query($conn, "update jadwal set is_active = 1 where id = $idjadwal");
    if($addtotable){
        header('location:penjadwalan_recovery.php');
    } else{
        echo 'Gagal';
        header('location:penjadwalan_recovery.php');
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

    // $hapus = mysqli_query($conn, "delete from pelanggan where idpelanggan = '$idpelanggan'");
    $hapus = mysqli_query($conn, "update pelanggan set is_active = 0 where idpelanggan = '$idpelanggan'");

    if($hapus){
        header('location:pelanggan.php');
    } else{
        echo 'Gagal';
        header('location:pelanggan.php');
    }
}

//Pulih Pelanggan dari database "Pelanggan"
if(isset($_POST['pulihpelanggan'])){
    $idpelanggan = $_POST['idpelanggan'];

    $hapus = mysqli_query($conn, "update pelanggan set is_active = 1 where idpelanggan = '$idpelanggan'");

    if($hapus){
        header('location:pelanggan_recovery.php');
    } else{
        echo 'Gagal';
        header('location:pelanggan_recovery.php');
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

    // $hapusproduk = mysqli_query($conn, "delete from produk where idproduk = '$idproduk'");
    $hapusproduk = mysqli_query($conn, "update produk set is_active = 0 where idproduk = '$idproduk'");
    if($hapusproduk){
        header('location:produk.php');
    } else{
        echo 'Gagal';
        header('location:produk.php');
    }
}

//pulihkan Produk dari database "Produk"
if(isset($_POST['pulihproduk'])){
    $idproduk = $_POST['idproduk'];

    // $hapusproduk = mysqli_query($conn, "delete from produk where idproduk = '$idproduk'");
    $hapusproduk = mysqli_query($conn, "update produk set is_active = 1 where idproduk = '$idproduk'");
    if($hapusproduk){
        header('location:produk_recovery.php');
    } else{
        echo 'Gagal';
        header('location:produk_recovery.php');
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

    // $hapustransaksi = mysqli_query($conn, "delete from transaksi where idtransaksi = '$idtransaksi'");
    $hapustransaksi = mysqli_query($conn, "update transaksi set is_active = 0 where idtransaksi = '$idtransaksi'");

    if($hapustransaksi){
        header('location:transaksi.php');
    } else{
        echo 'Gagal';
        header('location:transaksi.php');
    }
}

//pulihkan transaksi dari database "Transaksi"
if(isset($_POST['pulihtransaksi'])){
    $idtransaksi = $_POST['idtransaksi'];

    // $hapustransaksi = mysqli_query($conn, "delete from transaksi where idtransaksi = '$idtransaksi'");
    $pulihtransaksi = mysqli_query($conn, "update transaksi set is_active = 1 where idtransaksi = '$idtransaksi'");

    if($pulihtransaksi){
        header('location:transaksi_recovery.php');
    } else{
        echo '<script> alert("gagal;"); </script>';
        header('location:transaksi_recovery.php');
    }
}

//Ubah profil
if(isset($_POST['ubahprofil'])){
    $iduser = $_SESSION['userid'];
    $nama = $_POST['nama'];

    $updateuser = mysqli_query($conn, "update login set nama = '$nama' where iduser = $iduser");

    if($updateuser){
        if(strlen($nama) < 18) {
            $_SESSION['userName'] = $nama;
        } else {
            $_SESSION['userName'] = substr($nama, 0, 18). " ... ";
        }
        header('location:user.php');
    } else{
        echo '<script>alert("Gagal!")</script>';
        // header('location:user.php');
    }
}


//Ubah password
if(isset($_POST['ubahpassword'])){
    $iduser = $_SESSION['userid'];
    $oldpassword = $_POST['oldpass'];
    $newpassword = $_POST['newpass'];
    $confirmpassword = $_POST['confirmpass'];

    if($newpassword != $confirmpassword) {
        echo '<script>alert("Password baru dan konfirmasi password harus sama!")</script>';
    } else {
        $passdb = "";
        $sqldata = mysqli_query($conn, "select password from login where iduser = $iduser limit 1");
        while($fetcharray = mysqli_fetch_array($sqldata)){
            $passdb = $fetcharray['password'];
        }

        if($oldpassword != $passdb) {
            echo '<script>alert("Password lama salah!")</script>';
        } else {
            $updateuserpass = mysqli_query($conn, "update login set password = '$newpassword' where iduser = $iduser");
        
            if($updateuserpass){
                header('location:user.php');
            } else{
                echo '<script>alert("Gagal!")</script>';
                // header('location:user.php');
            }

        }
    } 
}

?>