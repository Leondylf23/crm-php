<?php 
require 'function.php';

if(isset($_GET['id'])) {

    $idtransaksi = $_GET['id'];

    $sql = mysqli_query($conn, "
    select 
        DATE_FORMAT(t.tanggal_transaksi, '%d-%m-%Y %H:%i') as tanggal_transaksi, 
        FORMAT(t.totaltransaksi, 2, 'id_ID') as totaltransaksi,
        m.nama_metode,
        upper(pl.namapelanggan) as namapelanggan,
        upper(pl.alamat) as alamat,
        upper(pl.telp) as telp,
        DATE_FORMAT(t.tanggal_transaksi, '%d%m%Y/%H%i') as tgl_str,
        t.totaltransaksi as ttransaksi_num
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
        $alamat = $fetcharray['alamat'];
        $telp = $fetcharray['telp'];
        $ttransaksinum = $fetcharray['ttransaksi_num'];
    }

    $numToStr = "";


    if($ttransaksinum >= 1000000000) {
        $numToStr .= numberToText($ttransaksinum / 1000000000) . " MILIYAR";
        $ttransaksinum = $ttransaksinum % 1000000000;
        if($ttransaksinum > 1000000 || $ttransaksinum > 1000 || $ttransaksinum > 1) {
            $numToStr .= " ";
        }
    }
    if ($ttransaksinum >= 1000000) {
        $numToStr .= numberToText($ttransaksinum / 1000000) . " JUTA";
        $ttransaksinum = $ttransaksinum % 1000000;
        if ($ttransaksinum > 1000 || $ttransaksinum > 1) {
            $numToStr .= " ";
        }
    }
    if ($ttransaksinum >= 2000) {
        $numToStr .= numberToText($ttransaksinum / 1000) . " RIBU";
        $ttransaksinum = $ttransaksinum % 1000;
        if ($ttransaksinum > 1) {
            $numToStr .= " ";
        }
    }
    $numToStr .= numberToText($ttransaksinum);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Invoice-<?=$tglStr?><?=$pelanggan?></title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }
                .printable-area, .printable-area * {
                    visibility: visible;
                }
                .printable-area {
                    margin-top: -2vh;
                    /* position: absolute;
                    left: 0;
                    top: 0; */
                }
                @page {
                    size: auto;   /* auto is the initial value */
                    margin: 0 20px 0 20px;  /* this affects the margin in the printer settings */
                }

                /* Remove header and footer */
                @page :first {
                    margin-top: 0;
                }
                @page :last {
                    margin-bottom: 0;
                }
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <main>
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-lg-12 d-sm-flex justify-content-end bg-secondary py-sm-2">
                        <button type="button" onclick="window.print();" class="btn btn-primary">Print</button>
                    </div>
                </div>
                <div class="row pe-4 ps-4 printable-area">
                    <div class="col-lg-12 mb-2">
                        <h3>MAJUJAYA FURNITURE</h3>
                    </div>                    
                    <div class="col-7">
                        <div>
                            <a>Jl. Pahlawan Revolusi No. 45 Klender, JAKARTA TIMUR, DKI JAKARTA, 13440</a>
                        </div>
                        <div>
                            <a>Telp: 0218615839</a>
                        </div>
                        <div>
                            <a>Email: e1010y@yahoo.com</a>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-4">
                                <b>FAKTUR #</b>
                            </div>
                            <div class="col-1">
                                <a>:</a>
                            </div>
                            <div class="col-7">
                                <a>INV/<?=$tglStr?>/<?=$pelanggan?></a>
                            </div>
                            <div class="col-4">
                                <b>TANGGAL</b>
                            </div>
                            <div class="col-1">
                                <a>:</a>
                            </div>
                            <div class="col-7">
                                <a><?=$tglTransaksi?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-4 mb-4">
                        <div class="row d-sm-flex align-items-center">
                            <div class="col-6 border border-1 border-dark"></div>                            
                            <div class="col-2 d-sm-flex justify-content-center">
                                <h4 class="px-2">FAKTUR</h4>
                            </div>
                            <div class="col-4 border border-1 border-dark"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-1">
                        <a>PELANGGAN</a>
                    </div>
                    <div class="col-7">
                        <div class="pe-4">
                            <div class="row border border-2 border-dark">
                                <div class="col-3">
                                    <a>NAMA</a>
                                </div>
                                <div class="col-9">
                                    <a><?=$pelanggan?></a>
                                </div>
                                <div class="col-3">
                                    <a>ALAMAT</a>
                                </div>
                                <div class="col-9">
                                    <a><?=$alamat?></a>
                                </div>
                                <div class="col-3">
                                    <a>TELP</a>
                                </div>
                                <div class="col-9">
                                    <a>(+62) <?=$telp?></a>
                                </div>
                                <div class="col-3">
                                    <a>FAX</a>
                                </div>
                                <div class="col-9">
                                    <a>-</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row border border-2 border-dark">
                            <div class="col-12">
                                <a style="color: #fff">ㅤ</a>
                            </div>
                            <div class="col-6">
                                <a>JATUH TEMPO</a>
                            </div>
                            <div class="col-6">
                                <a>-</a>
                            </div>
                            <div class="col-12">
                                <a style="color: #fff">ㅤ</a>
                            </div>
                            <div class="col-12">
                                <a style="color: #fff">ㅤ</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-4 mb-1" style="padding-left: 0 !important; padding-right: 0 !important;">
                        <table class="border-bottom-0 border-2 border-dark" style="width: 100%">
                            <thead>
                                <tr class="border border-2 border-dark">
                                    <th class="border border-2 border-dark p-1" style="width: 6%">NO.</th>
                                    <th class="border border-2 border-dark p-1" style="width: 50%">KETERANGAN</th>
                                    <th class="border border-2 border-dark p-1" style="width: 10%; text-align: right;">QTY</th>
                                    <th class="border border-2 border-dark p-1" style="width: 16%; text-align: right;">HARGA SATUAN (Rp.)</th>
                                    <th class="border border-2 border-dark p-1" style="text-align: right;">JUMLAH (Rp.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sqlData = mysqli_query($conn, "
                                select 
                                    upper(p.nama_item) as nama_item,
                                    upper(p.kode_produk) as kode_produk, 
                                    td.qty,
                                    p.satuan, 
                                    FORMAT(p.harga_jual, 2, 'id_ID') as harga_jual,        
                                    FORMAT(td.totalharga, 2, 'id_ID') as totalharga 
                                from 
                                    transaksi t 
                                inner join 
                                    transaksi_detail td on t.idtransaksi = td.idtransaksi 
                                inner join 
                                    produk p on td.idproduk = p.idproduk   
                                where t.idtransaksi = $idtransaksi ");
                                $i = 1;
                                while($fetcharray = mysqli_fetch_array($sqlData)){
                                    $nmprdk = $fetcharray['nama_item'];
                                    $kdprdk = $fetcharray['kode_produk'];
                                    $qty = $fetcharray['qty'];
                                    $satuan = $fetcharray['satuan'];
                                    $hrgsatuan = $fetcharray['harga_jual'];
                                    $jmlh = $fetcharray['totalharga'];                                    
                                ?>

                                <tr>
                                    <td class="border-top-0 border-bottom-0 border-2 border-dark p-1"><?=$i++?></td>
                                    <td class="border-top-0 border-bottom-0 border-2 border-dark p-1"><?=$nmprdk?> - <?=$kdprdk?></td>
                                    <td class="border-top-0 border-bottom-0 border-2 border-dark p-1" style="text-align: right;"><?=$qty?> <?=$satuan?></td>
                                    <td class="border-top-0 border-bottom-0 border-2 border-dark p-1" style="text-align: right;"><?=$hrgsatuan?></td>
                                    <td class="border-top-0 border-bottom-0 border-2 border-dark p-1" style="text-align: right;"><?=$jmlh?></td>
                                <tr>
                                
                                <?php
                                }
                                ?>
                                <tr>
                                    <td class="border-top-0 border-2 border-dark p-1"></td>
                                    <td class="border-top-0 border-2 border-dark p-1"></td>
                                    <td class="border-top-0 border-2 border-dark p-1" style="text-align: right;"></td>
                                    <td class="border-top-0 border-2 border-dark p-1" style="text-align: right;"></td>
                                    <td class="border-top-0 border-2 border-dark p-1" style="text-align: right;"></td>
                                <tr>
                                    
                                
                                <tr>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class="border border-2 border-dark p-1">Subtotal</td>
                                    <td class="broder border-2 border-dark p-1" style="text-align: right;"><?=$totalTransaksi?></td>
                                <tr>
                                <tr>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class="border border-2 border-dark p-1"><b>TOTAL</a></td>
                                    <td class="border border-2 border-dark p-1" style="text-align: right; background-color: #EDEDED;"><?=$totalTransaksi?></td>
                                <tr>
                                <tr>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class="p-1">Sisa Tagihan</td>
                                    <td class=" border-2 border-dark p-1" style="text-align: right;"><?=$totalTransaksi?></td>
                                <tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-7 mt-1 border border-2 border-dark">
                        <div class="mb-1">
                            <b>PESAN</b>
                        </div>
                        <div style="height: 40px;"></div>
                    </div>
                    <div class="col-7 border-top-0 border border-2 border-dark">
                        <div class="mb-1">
                            <a>TERBILANG</a>
                        </div>
                        <div class="mb-1">
                            <a><?=$numToStr?> RUPIAH</a>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-5">                        
                    </div>
                    <div class="col-lg-12 d-sm-flex justify-content-end mt-5">
                        <div class="w-25 border border-1 border-dark"></div>
                    </div>
                </div>
            </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>        
    </body>
</html>






<?php
} else {
    echo '<h1>Unknown id!</h1>';
}

?>