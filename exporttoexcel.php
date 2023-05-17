<?php 
require 'function.php';

if(isset($_GET['id'])) {
    header("Content-Type: application/vnd.ms-excel");    
    
    $idtransaksi = $_GET['id'];

    $tglTransaksi = "";
    $pelanggan = "";
    $totalTransaksi = "";
    $metode = "";

    $sql = mysqli_query($conn, "
    select 
        DATE_FORMAT(t.tanggal_transaksi, '%d-%m-%Y %H:%i') as tanggal_transaksi, 
        CONCAT('Rp. ', FORMAT(t.totaltransaksi, 2, 'id_ID')) as totaltransaksi,
        m.nama_metode,
        pl.namapelanggan,
        DATE_FORMAT(t.tanggal_transaksi, '%d%m%Y%H%i') as tgl_str
    from 
        transaksi t     
    inner join 
        metode_pembayaran m on t.idmetode = m.id
    inner join 
        pelanggan pl on t.idpelanggan = pl.idpelanggan  
    where t.idtransaksi = $idtransaksi 
    limit 1
    ");

    while($fetcharray = mysqli_fetch_array($sql)){        
        $tglTransaksi = $fetcharray['tanggal_transaksi'];
        $pelanggan = $fetcharray['namapelanggan'];
        $totalTransaksi = $fetcharray['totaltransaksi'];
        $metode = $fetcharray['nama_metode'];
        $tglStr = $fetcharray['tgl_str'];
    }

    echo "Transaksi tanggal: " . "\t" . "$tglTransaksi" . "\n";
    echo "Nama Pelanggan: " . "\t" . "$pelanggan" . "\n";
    echo "Metode Pembayaran: " . "\t" . "$metode" . "\n";
    echo "\n";
    
    echo 'Nama Barang' . "\t" . 'Kuantitas' . "\t" . 'Harga Satuan' . "\t" . 'Harga Total' . "\n";
    $sqlData = mysqli_query($conn, "
    select 
        p.nama_item, 
        td.qty,
        p.satuan, 
        CONCAT('Rp. ', FORMAT(p.harga_jual, 2, 'id_ID')) as harga_jual,        
        CONCAT('Rp. ', FORMAT(td.totalharga, 2, 'id_ID')) as totalharga 
    from 
        transaksi t 
    inner join 
        transaksi_detail td on t.idtransaksi = td.idtransaksi 
    inner join 
        produk p on td.idproduk = p.idproduk   
    where t.idtransaksi = $idtransaksi ");
    while($fetcharray = mysqli_fetch_array($sqlData)){        
        echo $fetcharray['nama_item'] . "\t" . $fetcharray['qty'] . " " . $fetcharray['satuan'] . "\t" . $fetcharray['harga_jual'] . "\t" . $fetcharray['totalharga'] . "\n";
    }

    echo "\n";
    echo "\n";
    echo "Total Transaksi: " . "\t" . "$totalTransaksi" . "\n";

    $filename = $pelanggan . $tglStr;
    header("Content-disposition: attachment; filename=$filename.xls");

} else {
    // echo $_GET['id'];
    header('location:index.php');
}

?>