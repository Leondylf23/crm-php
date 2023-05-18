<?php 
session_start();
// Koneksi DB
if(!isset($_SESSION['userid'])) {
    $_SESSION['userid'] = 0;
    $_SESSION['userName'] = "Silahkan Login.";
} else {
    
}
$conn = mysqli_connect("localhost","root","","crm");

//Menambah pelanggan baru
if(isset($_POST['addnewcustomer'])){
    $namapelanggan = $_POST['namapelanggan'];
    $alamat = $_POST['alamat'];
    $telpn = $_POST['telpn'];

    $addtotable = mysqli_query($conn, "insert into pelanggan (namapelanggan, alamat, telp) values('$namapelanggan','$alamat', '$telpn')");
    if($addtotable){
        updateKpiAdmin($conn, "Pelanggan");
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
        updateKpiAdmin($conn, "Produk");
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
    $tgl = "";
    if(isset($_POST['tgl'])) {
        $tgl = $_POST['tgl'];
    }
    
    $totalPrdk = $_POST['totaldata'];
    $produk = array();
    
    for ($i=0; $i < $totalPrdk; $i++) { 
        $prdk = "prdk-$i";
        $qty = "qty-$i";
        $prctotal = "prctotal-$i";
        $deleted = "deleted-$i";

        $isDeleted = $_POST[$deleted];
        
        if(($isDeleted == 0) && ($_POST[$prctotal] > 0)) {
            array_push($produk, array("produk"=>$_POST[$prdk], "qty"=>$_POST[$qty], "prc-total"=>$_POST[$prctotal]));
        }
    }
    
    if(count($produk) > 0) {        
        $addtotransaksi = "";
        if($tgl == "") {
            $addtotransaksi = mysqli_query($conn, "insert into transaksi (idpelanggan, idmetode, totaltransaksi) values('$pelangganid','$pembayaranid','$totalprice')");
        } else {
            
            $addtotransaksi = mysqli_query($conn, "insert into transaksi (idpelanggan, idmetode, totaltransaksi, tanggal_transaksi) values('$pelangganid','$pembayaranid','$totalprice', '$tgl')");
        }
        if($addtotransaksi){
            
            $idtransaksi = mysqli_insert_id($conn);
            
            foreach ($produk as $a) {
                $prdkid = $a['produk'];
                $qtyData = $a['qty'];
                $prcTotal = $a['prc-total'];
    
                $addtotransaksidetail = mysqli_query($conn, "insert into transaksi_detail (idtransaksi, idproduk, qty, totalharga) values('$idtransaksi','$prdkid', '$qtyData','$prcTotal')");
                // echo "<script>alert('$qtyData')</script>";
        
                if($addtotransaksidetail) {
                    // header('location:transaksi.php'); 
                    
                } else {
                    echo '<script> alert("Gagal"); </script>';
                    // header('location:transaksi.php');
                }
            }

            // new Coroutine(checkPelangganTier($conn, $pelangganid)); // async funtion
            checkPelangganTier($conn, $pelangganid);
            updateKpiAdmin($conn, "Transaksi");
        } else{
            echo '<script> alert("Gagal"); </script>';
            // header('location:transaksi.php');
        }
    } else {
        echo '<script> alert("Data produk tidak boleh kosong!"); </script>';
        // header('location:transaksi.php');
    }

}

//Menambah Komplain Baru
if(isset($_POST['addnewcomplain'])){
    $namapelanggan = $_POST['namapelanggan'];
    $komplain = $_POST['komplain'];
    $solusi = $_POST['solusi'];
    $katg_komplain = $_POST['kategori'];

    $addtotable = mysqli_query($conn, "insert into komplain (nama, komplain, idkategori, solusi) values('$namapelanggan', '$komplain', '$katg_komplain', '$solusi')");
    if($addtotable){
        header('location:komplain.php');
        updateKpiAdmin($conn, "Komplain");
    } else{
        echo 'Gagal';
        header('location:komplain.php');
    }
}

//Edit Komplain
if(isset($_POST['updatekomplain'])){
    $namapelanggan = $_POST['namapelanggan'];
    $komplain = $_POST['komplain'];
    $solusi = $_POST['solusi'];
    $katg_komplain = $_POST['kategori'];
    $idkomplainedit = $_POST['idkomplain'];

    $addtotable = mysqli_query($conn, "update komplain set nama='$namapelanggan', komplain='$komplain', idkategori='$katg_komplain', solusi='$solusi' where idkomplain = '$idkomplainedit'");
    if($addtotable){
        updateKpiAdmin($conn, "Komplain");
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
        updateKpiAdmin($conn, "Komplain");
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
        updateKpiAdmin($conn, "Komplain");
        header('location:komplain.php');
    } else{
        echo 'Gagal';
        header('location:komplain.php');
    }
}

//Menambah Aktifitas Baru
if(isset($_POST['tambahjadwal'])){
    $admin = $_POST['admin'];
    // $aktifitas = $_POST['aktifitas'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    // $tglmulai = $_POST['tglmulai'];
    $tglselesai = $_POST['tglselesai'];
    $pelanggan = $_POST['pelanggan'];

    // $addtotable = mysqli_query($conn, "insert into jadwal (adminid, aktifitas, deskripsi, tgl_pelaksanaan, tgl_selesai, kategori) values ('$admin', '$aktifitas', '$deskripsi', '$tglmulai', '$tglselesai', '$kategori')");
    $addtotable = mysqli_query($conn, "insert into jadwal (adminid, tgl_selesai, kategori, idpelanggan, deskripsi) values ('$admin', '$tglselesai', '$kategori', '$pelanggan', '$deskripsi')");
    if($addtotable){
        updateKpiAdmin($conn, "Aktifitas");
        header('location:penjadwalan.php');
    } else{
        echo 'Gagal';
        header('location:penjadwalan.php');
    }
}

//update Aktifitas
if(isset($_POST['updatejadwal'])){
    $idjadwal = $_POST['idjadwal'];
    $admin = $_POST['admin'];
    // $aktifitas = $_POST['aktifitas'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    // $tglmulai = $_POST['tglmulai'];
    $tglselesai = $_POST['tglselesai'];
    $idplng = $_POST['pelanggan'];

    // $addtotable = mysqli_query($conn, "update jadwal set adminid = '$admin', aktifitas = '$aktifitas', deskripsi = '$deskripsi', tgl_pelaksanaan = '$tglmulai', tgl_selesai = '$tglselesai', kategori = '$kategori' where id = '$idjadwal'");
    $addtotable = mysqli_query($conn, "update jadwal set adminid = '$admin', tgl_selesai = '$tglselesai', kategori = '$kategori', idpelanggan = '$idplng', deskripsi = '$deskripsi' where id = '$idjadwal'");
    if($addtotable){
        updateKpiAdmin($conn, "Aktifitas");
        header('location:penjadwalan.php');
    } else{
        echo 'Gagal';
        header('location:penjadwalan.php');
    }
}

//hapus Aktifitas
if(isset($_POST['hapusjadwal'])){
    $idjadwal = $_POST['idjadwal'];
    
    $addtotable = mysqli_query($conn, "update jadwal set is_active = 0 where id = $idjadwal");
    if($addtotable){
        updateKpiAdmin($conn, "Aktifitas");
        header('location:penjadwalan.php');
    } else{
        echo 'Gagal';
        header('location:penjadwalan.php');
    }
}

//Pemulihan Aktifitas
if(isset($_POST['pulihjadwal'])){
    $idjadwal = $_POST['idjadwal'];
    
    $addtotable = mysqli_query($conn, "update jadwal set is_active = 1 where id = $idjadwal");
    if($addtotable){
        updateKpiAdmin($conn, "Aktifitas");
        header('location:penjadwalan.php');
    } else{
        echo 'Gagal';
        header('location:penjadwalan.php');
    }
}

if(isset($_POST['selesaijadwal'])){
    $idjadwal = $_POST['idjadwal'];
    
    $addtotable = mysqli_query($conn, "update jadwal set status = 2 where id = $idjadwal");
    if($addtotable){
        updateKpiAdmin($conn, "Aktifitas");
        echo '<script>alert("Tes");</script>';
        header('location:penjadwalan.php');
    } else{
        echo '<script>alert("Gagal");</script>';
        header('location:penjadwalan.php');
    }
}

if(isset($_POST['konfirmasijadwal'])){
    $idjadwal = $_POST['idjadwal'];
    
    $addtotable = mysqli_query($conn, "update jadwal set status = 3 where id = $idjadwal");
    if($addtotable){
        updateKpiAdmin($conn, "Aktifitas");
        header('location:penjadwalan.php');
    } else{
        echo 'Gagal';
        header('location:penjadwalan.php');
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
        updateKpiAdmin($conn, "Pelanggan");
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
        updateKpiAdmin($conn, "Pelanggan");
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
        updateKpiAdmin($conn, "Pelanggan");
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
        updateKpiAdmin($conn, "Produk");
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
        updateKpiAdmin($conn, "Produk");
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
        updateKpiAdmin($conn, "Produk");
        header('location:produk.php');
    } else{
        echo 'Gagal';
        header('location:produk.php');
    }
}

//Update Info Transaksi
// if(isset($_POST['updatetransaksi'])){
//     $idtransaksi = $_POST['idtransaksi'];
//     $tanggaltransaksi = $_POST['tanggal_transaksi'];
//     $namapelanggan = $_POST['nama_pelanggan'];
//     $idproduk = $_POST['idproduk'];
//     $hargajual = $_POST['harga_jual'];
//     $modal = $_POST['harga_modal'];
//     $untung = $_POST['untung'];

//     $updatetransaksi = mysqli_query($conn, "update transaksi set tanggal_transaksi='$tanggaltransaksi', nama_pelanggan='$namapelanggan', idproduk='$idproduk', harga_jual='$hargajual', harga_modal='$modal', untung='$untung' where idtransaksi = '$idtransaksi'");
//     if($updatetransaksi){
//         header('location:transaksi.php');
//     } else{
//         echo 'Gagal';
//         header('location:transaksi.php');
//     }
// }

//Hapus transaksi dari database "Transaksi"
if(isset($_POST['hapustransaksi'])){
    $idtransaksi = $_POST['idtransaksi'];
    $pelangganid = $_POST['idpelanggan'];

    // $hapustransaksi = mysqli_query($conn, "delete from transaksi where idtransaksi = '$idtransaksi'");
    $hapustransaksi = mysqli_query($conn, "update transaksi set is_active = 0 where idtransaksi = '$idtransaksi'");

    if($hapustransaksi){
        updateKpiAdmin($conn, "Transaksi");
        // new Coroutine(checkPelangganTier($conn, $pelangganid)); // async funtion
        checkPelangganTier($conn, $pelangganid);
        header('location:transaksi.php');
    } else{
        echo 'Gagal';
        header('location:transaksi.php');
    }
}

//pulihkan transaksi dari database "Transaksi"
if(isset($_POST['pulihtransaksi'])){
    $idtransaksi = $_POST['idtransaksi'];
    $pelangganid = $_POST['idpelanggan'];

    // $hapustransaksi = mysqli_query($conn, "delete from transaksi where idtransaksi = '$idtransaksi'");
    $pulihtransaksi = mysqli_query($conn, "update transaksi set is_active = 1 where idtransaksi = '$idtransaksi'");

    if($pulihtransaksi){
        updateKpiAdmin($conn, "Transaksi");
        // new Coroutine(checkPelangganTier($conn, $pelangganid)); // async funtion
        checkPelangganTier($conn, $pelangganid);
        header('location:transaksi_recovery.php');
    } else{
        echo '<script> alert("gagal;"); </script>';
        header('location:transaksi_recovery.php');
    }
}

if(isset($_POST['pulihktgaktifitas'])){
    $id = $_POST['id'];

    $pulihtransaksi = mysqli_query($conn, "update kategori_jadwal set is_active = 1 where id = '$id'");

    if($pulihtransaksi){
        updateKpiAdmin($conn, "Aktifitas");
        header('location:penambahan_aktifitas.php');
    } else{
        echo '<script> alert("gagal;"); </script>';
        header('location:penambahan_aktifitas.php');
    }
}

if(isset($_POST['hapusktgaktifitas'])){
    $id = $_POST['id'];

    $pulihtransaksi = mysqli_query($conn, "update kategori_jadwal set is_active = 0 where id = '$id'");

    if($pulihtransaksi){
        updateKpiAdmin($conn, "Aktifitas");
        header('location:penambahan_aktifitas.php');
    } else{
        echo '<script> alert("gagal;"); </script>';
        header('location:penambahan_aktifitas.php');
    }
}

if(isset($_POST['updatektgaktifitas'])){
    $id = $_POST['id'];
    $kategori = $_POST['kategori'];

    $pulihtransaksi = mysqli_query($conn, "update kategori_jadwal set nama_kategori = '$kategori' where id = '$id'");

    if($pulihtransaksi){
        updateKpiAdmin($conn, "Aktifitas");
        header('location:penambahan_aktifitas.php');
    } else{
        echo '<script> alert("gagal;"); </script>';
        header('location:penambahan_aktifitas.php');
    }
}

if(isset($_POST['tambahktgaktifitas'])){
    $kategori = $_POST['aktifitas'];
    
    $addtotable = mysqli_query($conn, "insert into kategori_jadwal (nama_kategori) values ('$kategori')");
    if($addtotable){
        updateKpiAdmin($conn, "Aktifitas");
        header('location:penambahan_aktifitas.php');
    } else{
        echo '<script> alert("gagal;"); </script>';
        header('location:penambahan_aktifitas.php');
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

function checkPelangganTier($conn, $idPelanggan) {
    // yield; //untuk async funtion

    // $addtotable = mysqli_query($conn, "insert into notifikasi (isi_notif, userid) values('test async', 9)");
    // if($addtotable){
        
    // } else{
        
    // }

    $sum = 0;
    $tier =  'Basic';

    $produk = mysqli_query($conn, "SELECT SUM(totaltransaksi) AS totalsum FROM transaksi WHERE is_active = 1 and idpelanggan = $idPelanggan");
    while($fetcharray = mysqli_fetch_array($produk)){
        $sum += $fetcharray['totalsum'];
    }

    if($sum >= 2000000 && $sum < 6000000) {
        $tier =  'Silver';
    }
    if($sum >= 6000000 && $sum < 10000000) {
        $tier =  'Gold';
    }
    if($sum >= 10000000) {
        $tier =  'Platinum';
    }

    mysqli_query($conn, "update pelanggan set prioritas = '$tier' where idpelanggan = $idPelanggan");
        
}

function updateKpiAdmin($conn, $type) {
    $userid = $_SESSION['userid'];

    mysqli_query($conn, "insert into kpi_records (adminid, kategori) values('$userid', '$type')");
}

function numberToText($number) {
    $ones = array(
        0 => '', 1 => 'SATU', 2 => 'DUA', 3 => 'TIGA', 4 => 'EMPAT', 5 => 'LIMA', 6 => 'ENAM', 7 => 'TUJUH', 8 => 'DELAPAN', 9 => 'SEMBILAN',
        10 => 'SEPULUH', 11 => 'SEBELAS', 12 => 'DUA BELAS', 13 => 'TIGA BELAS', 14 => 'EMPAT BELAS', 15 => 'LIMA BELAS', 16 => 'ENAM BELAS', 17 => 'TUJUH BELAS', 18 => 'DELAPAN BELAS', 19 => 'SEMBILAN BELAS'
    );
    $tens = array(
        2 => 'DUA PULUH', 3 => 'TIGA PULUH', 4 => 'EMPAT PULUH', 5 => 'LIMA PULUH', 6 => 'ENAM PULUH', 7 => 'TUJUH PULUH', 8 => 'DELAPAN PULUH', 9 => 'SEBILAN PULUH'
    );
    $hundreds = array(
        1 => 'SERATUS', 2 => 'DUA RATUS', 3 => 'TIGA RATUS', 4 => 'EMPAT RATUS', 5 => 'LIMA RATUS', 6 => 'ENAM RATUS', 7 => 'TUJUH RATUS', 8 => 'DELAPAN RATUS', 9 => 'SEMBILAN RATUS'
    );
    $thousands = array(
        1 => 'SERIBU', 2 => 'DUA RIBU', 3 => 'TIGA RIBU', 4 => 'EMPAT RIBU', 5 => 'LIMA RIBU', 6 => 'ENAM RIBU', 7 => 'TUJUH RIBU', 8 => 'DELAPAN RIBU', 9 => 'SEMBILAN RIBU'
    );

    if ($number < 20) {
        return $ones[$number];
    } elseif ($number < 100) {
        $tens_digit = floor($number / 10);
        $ones_digit = $number % 10;
        if ($ones_digit == 0) {
            return $tens[$tens_digit];
        } else {
            return $tens[$tens_digit] . ' ' . $ones[$ones_digit];
        }
    } elseif ($number < 1000) {
        $hundreds_digit = floor($number / 100);
        $tens_digit = floor(($number % 100) / 10);
        $ones_digit = $number % 10;
        if ($tens_digit == 0 && $ones_digit == 0) {
            return $hundreds[$hundreds_digit];
        } elseif ($tens_digit == 0) {
            return $hundreds[$hundreds_digit] . ' ' . $ones[$ones_digit];
        } else {
            return $hundreds[$hundreds_digit] . ' ' . numberToText($number % 100);
        }
    } elseif ($number < 10000) {
        $thousands_digit = floor($number / 1000);
        $hundreds_digit = floor(($number % 1000) / 100);
        $tens_digit = floor(($number % 100) / 10);
        $ones_digit = $number % 10;
        if ($hundreds_digit == 0 && $tens_digit == 0 && $ones_digit == 0) {
            return $thousands[$thousands_digit];
        } elseif ($hundreds_digit == 0 && $tens_digit == 0) {
            return $thousands[$thousands_digit] . ' ' . $ones[$ones_digit];
        } elseif ($hundreds_digit == 0) {
            return $thousands[$thousands_digit] . ' ' . numberToText($number % 100);
        } else {
            return $thousands[$thousands_digit] . ' ' . numberToText($number % 1000);
        }
    } else {
        return 'ANGKA MELEBIHI BATAS';

    }
}

?>