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
        <title>Data Transaksi</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Transaksi</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                    <i class="fas fa-plus me-1"></i>
                                    Transaksi
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Nama Pelanggan</th>
                                            
                                            <th>Total Transaksi</th>
                                            <th>Metode Pembayaran</th>

                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $ambilsemuadatatransaksi = mysqli_query($conn, "SELECT t.idtransaksi, t.tanggal_transaksi, DATE_FORMAT(t.tanggal_transaksi, '%d-%m-%Y %H:%i') as tgl_formated, p.namapelanggan, t.totaltransaksi, CONCAT('Rp. ', FORMAT(t.totaltransaksi, 2, 'id_ID')) as totaltransaksi_str, mp.nama_metode, p.idpelanggan, t.pesan FROM transaksi t INNER JOIN pelanggan p ON p.idpelanggan = t.idpelanggan LEFT JOIN metode_pembayaran mp ON mp.id = t.idmetode where t.is_active = 1 order by t.tanggal_transaksi desc");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatatransaksi)){
                                            $idtransaksi = $data['idtransaksi'];
                                            $tanggaltransaksi = $data['tanggal_transaksi'];
                                            $tanggaltransaksif = $data['tgl_formated'];
                                            
                                            $namapelanggan = $data['namapelanggan'];
                                            $idpelanggan = $data['idpelanggan'];
                                            
                                            $totaltransaksi = $data['totaltransaksi'];
                                            $totaltransaksistr = $data['totaltransaksi_str'];
                                            $nama_metode = $data['nama_metode'];
                                            $pesan = $data['pesan'];
                                            
                                        
                                        ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$tanggaltransaksif;?></td>
                                            <td><?=$namapelanggan;?></td>
                                            <td><?=$totaltransaksistr;?></td>
                                            <td><?=$nama_metode;?></td>
                                            
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detil<?=$idtransaksi;?>">
                                                    Detail
                                                </button>
                                                <button type="button" class="btn btn-success" onclick="location.href='exporttoexcel.php?id=<?=$idtransaksi;?>';">
                                                    Export Excel
                                                </button>
                                                <button type="button" class="btn btn-warning" onclick="
                                                    var tab = window.open();
                                                    tab.opener = null;
                                                    tab.location = 'invoice.php?id=<?=$idtransaksi;?>';
                                                ">
                                                    Print
                                                </button>
                                                <!-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idtransaksi;?>">
                                                    Delete
                                                </button> -->
                                            </td>
                                        </tr>

                                            <!-- Detil -->
                                            <div class="modal fade" id="detil<?=$idtransaksi;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Detail Transaksi</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-5">
                                                                <b>Tanggal Transaksi</b>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <b>: </b>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a><?=$tanggaltransaksif;?></a>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <b>Pelanggan</b>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <b>: </b>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a><?=$namapelanggan;?></a>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <b>Total Transaksi</b>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <b>: </b>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a><?=$totaltransaksistr;?></a>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <b>Metode Pembayaran</b>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <b>: </b>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a><?=$nama_metode;?></a>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <b>Pesan</b>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <b>: </b>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a><?=$pesan;?></a>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <h4 class="mb-2">Detail - Detail Produk:</h4>
                                                        <div style="height: max(40vh); overflow-y: auto; overflow-x: hidden;">
                                                        <?php 
                                                            $a = 0;
                                                            $dataDetail = mysqli_query($conn, "select p.nama_item, td.qty, p.satuan, CONCAT('Rp. ', FORMAT(p.harga_jual, 2, 'id_ID')) as harga_jual, CONCAT('Rp. ', FORMAT(td.totalharga, 2, 'id_ID')) as totalharga from transaksi_detail td inner join produk p on td.idproduk = p.idproduk where td.idtransaksi = $idtransaksi");
                                                            while($fetcharray = mysqli_fetch_array($dataDetail)){
                                                                $a++;
                                                                $namaItem = $fetcharray['nama_item'];
                                                                $qtyTd = $fetcharray['qty'];
                                                                $satuan = $fetcharray['satuan'];
                                                                $prcPrdk = $fetcharray['harga_jual'];
                                                                $prcTotal = $fetcharray['totalharga'];
                                                                

                                                        ?>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <h5><?= $a ?>. <?= $namaItem ?></h5>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <b>Kuantitas</b>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <b>: </b>
                                                            </div>
                                                            <div class="col-lg-7">
                                                                <a><?=$qtyTd;?> <?=$satuan;?></a>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <b>Harga Satuan</b>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <b>: </b>
                                                            </div>
                                                            <div class="col-lg-7">
                                                                <a><?=$prcPrdk;?></a>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <b>Total Harga</b>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <b>: </b>
                                                            </div>
                                                            <div class="col-lg-7">
                                                                <a><?=$prcTotal;?></a>
                                                            </div>
                                                        </div>
                                                        <div class="mt-1 mb-1" style="background-color: #000; width: 100%; height: 2px;"></div>

                                                        <?php
                                                            } 
                                                        ?>
                                                        </div>
                                                        <!-- <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#delete<?=$idtransaksi;?>">
                                                            Hapus
                                                        </button> -->
                                                    </div>
                                                    

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete The Modal -->
                                            <div class="modal fade" id="delete<?=$idtransaksi;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Transaksi?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus transaksi <?=$namapelanggan;?>?
                                                            <input type="hidden" name="idtransaksi" value="<?=$idtransaksi;?>">
                                                            <input type="hidden" name="idpelanggan" value="<?=$idpelanggan;?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapustransaksi">Hapus</button>
                                                        </div>
                                                    </form>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php 
                                        };
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <div <?php if($_SESSION['role'] != 1) {echo('style="display: none;"');} ?>>
                        <a href="transaksi_recovery.php" style="padding-left: 25px;">Pemulihan data</a>
                    </div> -->
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
            <!-- The Modal -->
            <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Transaksi Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post" onsubmit="tgglConfirm()">
                <div class="modal-body">
                    <div>
                        <div class="form-floating mb-3 position-relative">                    
                            <input type="hidden" name="pelanggannya" value="" id="idplgn" required />
                            <input class="form-control" type="text" id="plgn" placeholder="Pelanggan" required />
                            <div id="plgndatas" style="z-index: 100; max-height: 300px; overflow-y: auto;">

                            </div>
                            <label for="plgn">Pelanggan</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="metodepembayaran" class="form-control" id="mtp">
                                <?php 
                                $data = mysqli_query($conn, "select * from metode_pembayaran where is_active = 1");
                                while($fetcharray = mysqli_fetch_array($data)){
                                    $metode = $fetcharray['nama_metode'];
                                    $idmp = $fetcharray['id'];
                                ?>
        
                                <option value="<?=$idmp;?>"><?=$metode;?></option>
        
                                <?php
                                }
                                ?>
                            </select>                    
                            <label for="mtp">Metode Pembayaran</label>
                        </div>
                        <div class="mb-3">
                            <div id="tglField">
                                
                            </div>
                            <button type="button" class="btn btn-primary mb-2 me-2" onclick=addTgl() id="tbhTgl">Atur Tanggal</button>
                            <button type="button" class="btn btn-danger mb-2" onclick=addTgl() id="hpsTgl" style="display: none;" >Hapus</button>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="pesan" placeholder="Pesan" id="psn" class="form-control">
                            <label for="psn">Pesan</label>
                        </div>
                        <div class="row" style="display: flex; align-items: center;">
                            <input type="hidden" id="totalprice" name="totalprice" />
                            <div class="col-lg-3">
                                <button type="button" class="btn btn-primary mb-2" id="additem" onclick=addItem()><i class="fas fa-plus me-2"></i>Item</button>
                            </div>
                            <div class="col-lg-9">
                                <h5 id="totalHarga" style="margin-left: -20px;">Total Harga: IDR 0.00</h5>
                            </div>
                        </div>                        
                        <div class="mb-2 pe-1 ps-1" id="table-data" style="height: max(40vh); overflow-y: auto;">
                            <input type="hidden" id="totaldata" name="totaldata" >
                            <!-- Buat isi data -->
                        </div>
                    </div>                    
                    
                    <div id="submit">
                        <button type="button" class="btn btn-primary" onclick="tgglConfirm()" id="sbmt" disabled >Submit</button>
                    </div>
                    <div id="confirm" class="d-none">
                        <div class="mb-2"><b>Apakah data yang anda masukkan sudah benar?</b></div>
                        <div>
                            <button type="submit" class="btn btn-danger" name="addnewtransaction">Ya</button>
                            <button type="button" class="btn btn-primary ms-3" onclick="tgglConfirm()">Masukkan Kembali</button>
                        </div>
                    </div>
                </div>
            </form>

            </div>
        </div>
    </div>
    <script>
        var plgnDatas = [];
        const sbmt = document.getElementById("sbmt");
        <?php             
            $ambilsemuadatapelanggannya = mysqli_query($conn, "select * from pelanggan where is_active = 1");
            while($fetcharray = mysqli_fetch_array($ambilsemuadatapelanggannya)){
                $namapelanggannya = $fetcharray['namapelanggan'];
                $idpelanggannya = $fetcharray['idpelanggan'];
                echo("plgnDatas.push({id: $idpelanggannya, name: '$namapelanggannya'});");
            }
        ?>
        const showData = document.getElementById("plgndatas");
        function ShowDataSelector() {
            const searchPlgn = document.getElementById("plgn");
            const plgnId = document.getElementById("idplgn");
            showData.innerHTML = "";            
            showData.setAttribute("class", "position-absolute bg-white mt-1 py-2 border rounded-3 w-100");
            sbmt.setAttribute("disabled", "");
            plgnId.value = "";

            for (let index = 0; index < plgnDatas.length; index++) {
                const element = plgnDatas[index];
                
                if(element.name.toLowerCase().indexOf(searchPlgn.value.toLowerCase()) != -1) {                    
                    const data = document.createElement("div");
                    data.setAttribute("class", "w-100 data-atb px-2 py-1");
                    data.addEventListener("click", () => {                        
                        // const inputRef = document.getElementById("plgn");
                        searchPlgn.value = element.name;
                        plgnId.value = element.id;
                        sbmt.removeAttribute("disabled");
                    })
                    data.innerHTML = element.name
                    showData.appendChild(data);
                    // showData.appendChild(document.createElement("br"));
                }
            }
        }

        document.getElementById("plgn").addEventListener("keyup", ShowDataSelector);
        document.getElementById("plgn").addEventListener("focus", ShowDataSelector);
        // showData.addEventListener("blur", () => {
        //     showData.innerHTML = "";          
        //     showData.removeAttribute("class");
        // });

        const input = document.getElementById('plgn');
        document.addEventListener('click', function(event) {
            if (!input.contains(event.target)) {  
                showData.innerHTML = "";          
                showData.removeAttribute("class");
            }
        });
    </script>
    <script>
        var isShowAddTgl = false;
        var isShowConfirm = false;

        function addTgl() {
            isShowAddTgl = !isShowAddTgl;

            const field = document.getElementById("tglField");
            const addBtn = document.getElementById("tbhTgl");
            const delBtn = document.getElementById("hpsTgl");
    
            if(isShowAddTgl) {
                addBtn.setAttribute("style", "display: none;");
                delBtn.removeAttribute("style");
                
                const tglElmnt = document.createElement("input");
                tglElmnt.setAttribute("class", "form-control mb-2");
                tglElmnt.setAttribute("type", "date");
                tglElmnt.setAttribute("id", "tgl");
                tglElmnt.setAttribute("name", "tgl");
                field.appendChild(tglElmnt);

            } else {
                const tglField = document.getElementById("tgl");

                delBtn.setAttribute("style", "display: none;");
                addBtn.removeAttribute("style");
                tglField.remove();
            }
        }

        function tgglConfirm() {
            const submit = document.getElementById("submit");
            const confirm = document.getElementById("confirm");
            const addBtn = document.getElementById("tbhTgl");
            const delBtn = document.getElementById("hpsTgl");
            const addItmBtn = document.getElementById("additem");
            const hapusBtn = document.querySelectorAll("#hapusBtn");
            const totalData = document.getElementById("totaldata").value;
            const plgn = document.getElementById("plgn");
            const mtp = document.getElementById("mtp");
            const psn = document.getElementById("psn");

            isShowConfirm = !isShowConfirm;

            if(isShowConfirm) {
                addBtn.setAttribute("disabled","");
                delBtn.setAttribute("disabled","");
                addItmBtn.setAttribute("disabled","");
                hapusBtn.forEach(e => {
                    e.setAttribute("disabled","");                    
                });
                for (let index = 0; index < totalData; index++) {
                    const select = document.getElementById("prdkName-"+index);
                    const qty = document.getElementById("qty-"+index);

                    select.setAttribute("disabled","");
                    qty.setAttribute("disabled","");
                }
                plgn.setAttribute("disabled","");
                mtp.setAttribute("disabled","");
                psn.setAttribute("disabled","");
                submit.setAttribute("class", "d-none");
                confirm.removeAttribute("class");

                if(isShowAddTgl) {
                    const tgl = document.getElementById("tgl");
                    psn.setAttribute("disabled","");
                }
            } else {
                addBtn.removeAttribute("disabled");
                delBtn.removeAttribute("disabled");
                addItmBtn.removeAttribute("disabled");
                hapusBtn.forEach(e => {
                    e.removeAttribute("disabled");                    
                });
                for (let index = 0; index < totalData; index++) {
                    const select = document.getElementById("prdk-"+index);
                    const qty = document.getElementById("qty-"+index);

                    select.removeAttribute("disabled");
                    qty.removeAttribute("disabled");
                }
                plgn.removeAttribute("disabled");
                mtp.removeAttribute("disabled");
                psn.removeAttribute("disabled");
                confirm.setAttribute("class", "d-none");
                submit.removeAttribute("class");

                if(isShowAddTgl) {
                    const tgl = document.getElementById("tgl");
                    psn.removeAttribute("disabled");
                }
            }
        }
    </script>
    <script>
        var i = 0;
        var prdkOptions = [];
        var addedPrdk = [];
        var excludedPrdk = [];
        
        <?php 
            $dataa = mysqli_query($conn, "select * from produk where is_active = 1");
            while($fetcharray = mysqli_fetch_array($dataa)){
                $namaItem = $fetcharray['nama_item'];
                $idPrdk = $fetcharray['idproduk'];
                $prc = $fetcharray['harga_jual'];
                echo("prdkOptions.push({id: '$idPrdk', nama: '$namaItem', prc: '$prc'});");
            } 
        ?>
        
        function addItem() {
            const tableData = document.getElementById("table-data");

            var newElement = document.createElement("div");
            newElement.setAttribute("id", "data-" + i);
            newElement.setAttribute("class", "position-relative");
            
            var h4 = document.createElement("h4");
            h4.setAttribute("class", "modal-title mb-2");            
            h4.innerHTML = "Item ";
            newElement.appendChild(h4);

            //data
            // dropdown search
            const inputPrdkId = document.createElement("input");
            inputPrdkId.setAttribute("id", "prdk-" + i);            
            inputPrdkId.setAttribute("type", "hidden");
            inputPrdkId.setAttribute("name", "prdk-" + i);
            inputPrdkId.setAttribute("value", 0); 
            // inputPrdkId.setAttribute("onchange", "prdkOnChange("+ i +", this)");            
            newElement.appendChild(inputPrdkId);

            const inputPrdk = document.createElement("input");
            inputPrdk.setAttribute("id", "prdkName-" + i);
            inputPrdk.setAttribute("class", "form-control mb-2");
            inputPrdk.setAttribute("type", "text");            
            inputPrdk.setAttribute("placeholder", "Produk");
            newElement.appendChild(inputPrdk);

            const prdkSelector = document.createElement("div");            
            prdkSelector.setAttribute("style", "z-index: 100; max-height: 300px; overflow-y: auto;");
            // prdkSelector.setAttribute("id", `slc-prdk-${i}`);
            newElement.appendChild(prdkSelector);

            function eventKeyUp(event){
                var val = event.target.value;
                const idNow = newElement.id.substring(5);
                inputPrdkId.setAttribute("value", 0);
                prdkOnChange(newElement.id.substring(5) , 0);
                prdkSelector.innerHTML = "";
                prdkSelector.setAttribute("class", "position-absolute bg-white py-2 border rounded-3 w-100");

                for (let index = 0; index < prdkOptions.length; index++) {
                    const element = prdkOptions[index];
                    let isExistInCart = false;

                    for (let j = 0; j < excludedPrdk.length; j++) {
                        const el = excludedPrdk[j];                        
                        if(el.id != idNow && el.prdk_id == element.id) {
                            isExistInCart = true
                        } else if (el.id == idNow) {
                            excludedPrdk.splice(j,1);
                        }
                    }

                    if(element.nama.toLowerCase().indexOf(val.toLowerCase()) != -1 && !isExistInCart) {
                        const data = document.createElement("div");
                        data.setAttribute("class", "w-100 data-atb px-2 py-1");
                        data.addEventListener("click", () => {                                                         
                            event.target.value = element.nama;                            
                            inputPrdkId.setAttribute("value", element.id);
                            excludedPrdk.push({id: idNow, prdk_id: element.id});
                            prdkOnChange(idNow , element.id);                                                                                   
                        })
                        data.innerHTML = element.nama
                        prdkSelector.appendChild(data);
                    }
                }
            }

            inputPrdk.addEventListener("keyup", eventKeyUp);
            inputPrdk.addEventListener("focus", eventKeyUp);
            
            document.addEventListener('click', function(event) {
            if (!inputPrdk.contains(event.target)) {  
                prdkSelector.innerHTML = "";          
                prdkSelector.removeAttribute("class");
            }});

            const qtyElmnt = document.createElement("input");
            qtyElmnt.setAttribute("id", "qty-" + i);
            qtyElmnt.setAttribute("class", "form-control mb-2");
            qtyElmnt.setAttribute("type", "number");
            qtyElmnt.setAttribute("name", "qty-" + i);
            qtyElmnt.setAttribute("placeholder", "Kuantitas");
            qtyElmnt.setAttribute("onchange", "qtyOnChage("+ i +", this)");
            qtyElmnt.setAttribute("onkeyup", "qtyOnChage("+ i +", this)");
            newElement.appendChild(qtyElmnt);

            const prcSatuanElmnt = document.createElement("b");
            prcSatuanElmnt.setAttribute("id", "prcSatuan-" + i);
            prcSatuanElmnt.setAttribute("class", "");
            prcSatuanElmnt.innerHTML = "Harga Satuan: IDR 0.00";
            newElement.appendChild(prcSatuanElmnt);

            const prcSatuanHiddenElmnt = document.createElement("input");
            prcSatuanHiddenElmnt.setAttribute("id", "prcSatuanHdn-" + i);
            prcSatuanHiddenElmnt.setAttribute("type", "hidden");
            prcSatuanHiddenElmnt.setAttribute("name", "prcsatuan-" + i);
            prcSatuanHiddenElmnt.setAttribute("value", 0);
            newElement.appendChild(prcSatuanHiddenElmnt);

            const br = document.createElement("br");
            newElement.appendChild(br);

            const prcTotalElmnt = document.createElement("b");
            prcTotalElmnt.setAttribute("id", "prcTotal-" + i);
            prcTotalElmnt.setAttribute("class", "");
            prcTotalElmnt.innerHTML = "Harga Total: IDR 0.00";
            newElement.appendChild(prcTotalElmnt);

            const prcTotalHiddenElmnt = document.createElement("input");
            prcTotalHiddenElmnt.setAttribute("id", "prcTotalHdn-" + i);
            prcTotalHiddenElmnt.setAttribute("type", "hidden");
            prcTotalHiddenElmnt.setAttribute("name", "prctotal-" + i);
            prcTotalHiddenElmnt.setAttribute("value", 0);
            newElement.appendChild(prcTotalHiddenElmnt);

            const deleted = document.createElement("input");
            deleted.setAttribute("id", "deleted-" + i);
            deleted.setAttribute("type", "hidden");
            deleted.setAttribute("name", "deleted-" + i);
            deleted.setAttribute("value", 0);
            newElement.appendChild(deleted);

            const br1 = document.createElement("br");
            newElement.appendChild(br1);

            const deleteBtn = document.createElement("button");
            deleteBtn.setAttribute("type", "button");
            deleteBtn.setAttribute("id", "hapusBtn");
            deleteBtn.setAttribute("class", "btn btn-danger mt-2");
            deleteBtn.setAttribute("onclick", "removeItem("+i+")");
            deleteBtn.innerHTML = "Hapus";

            newElement.appendChild(deleteBtn);

            const bar = document.createElement("div");
            bar.setAttribute("class", "mt-3 mb-1");
            bar.setAttribute("style", "background-color: #000; width: 100%; height: 2px;");
            newElement.appendChild(bar);

            i++;

            const identifierElmnt = document.getElementById("totaldata");
            identifierElmnt.value = i;

            tableData.appendChild(newElement);
        }

        function prdkOnChange(dataId, prdkIdIn) {
            const prcDataElmnt = document.getElementById("prcSatuan-"+dataId);
            const prcDataHdnElmnt = document.getElementById("prcSatuanHdn-"+dataId);
            const selectedId = prdkIdIn;
            const qtyInputElmnt = document.getElementById("qty-"+dataId);
            var prcData = 0;
            
            if(selectedId != 0) {
                prdkOptions.forEach(a => {
                    if(a.id == selectedId) {
                        prcData = a.prc;
                    }
                });
                var value = parseInt(prcData);
                const formattedPrcTemp = value.toLocaleString('en-US', { style: 'currency', currency: 'IDR' });
                prcDataElmnt.innerHTML = "Harga Satuan: "+formattedPrcTemp;
                prcDataHdnElmnt.value = prcData;
            } else {
                var zero = 0;
                const formattedPrcTemp = zero.toLocaleString('en-US', { style: 'currency', currency: 'IDR'});
                prcDataElmnt.innerHTML = "Harga Satuan: "+formattedPrcTemp;
                prcDataHdnElmnt.value = 0;
                
            }
            
            qtyOnChage(dataId, qtyInputElmnt);
        }

        function qtyOnChage(dataId, element) {
            const prcTotalElmnt = document.getElementById("prcTotal-"+dataId);
            const prcSatuanValue = document.getElementById("prcSatuanHdn-"+dataId).value;
            const prcTotalHdnElmnt = document.getElementById("prcTotalHdn-"+dataId);
            var qtyData = element.value;
            var totalPrc = 0;
            

            if(qtyData <= 0) {
                element.value = 1;

                var prcTemp = prcSatuanValue*1;
                const formattedPrcTemp = prcTemp.toLocaleString('en-US', { style: 'currency', currency: 'IDR' });

                prcTotalElmnt.innerHTML = "Harga Total: "+ formattedPrcTemp;
                
                prcTotalHdnElmnt.value = prcSatuanValue*1;
                totalPrc = prcSatuanValue*1;
            } else {
                var prcTemp = prcSatuanValue*qtyData;
                const formattedPrcTemp = prcTemp.toLocaleString('en-US', { style: 'currency', currency: 'IDR' });

                prcTotalElmnt.innerHTML = "Harga Total: "+formattedPrcTemp;
                
                prcTotalHdnElmnt.value = prcSatuanValue*qtyData;
                totalPrc = prcSatuanValue*qtyData;
            }

            calculateAll(dataId, totalPrc);

        }

        function removeItem(dataId) {
            const divElmnt = document.getElementById("data-"+dataId);
            const deletedElmnt = document.getElementById("deleted-"+dataId);
            
            deletedElmnt.value = 1;
            divElmnt.setAttribute("style","display: none;");
            for (let j = 0; j < excludedPrdk.length; j++) {
                const el = excludedPrdk[j];                        
                if(el.id == dataId) {
                    excludedPrdk.splice(j,1);
                }
            }
            calculateAll(dataId, 0);            
        }

        function calculateAll(dataId, totalPrc) {             
            if(addedPrdk.length > 0) {
                var found = false;
                addedPrdk.forEach(e => {
                    if(e.id == dataId) {
                        e.prc_total = totalPrc;
                        found = true;
                    }
                });

                if(!found) {                                        
                    addedPrdk.push({id: dataId, prc_total: totalPrc});                        
                }
            } else {                
                addedPrdk.push({id: dataId, prc_total: totalPrc});                 
            }

            const totalHargaHdn = document.getElementById("totalprice");
            const totalHarga = document.getElementById("totalHarga");
            var tempTotalHarga = 0;

            addedPrdk.forEach(e => {                
                tempTotalHarga += e.prc_total;                
            });

            const formattedAmount = tempTotalHarga.toLocaleString('en-US', { style: 'currency', currency: 'IDR' });
            totalHargaHdn.value = tempTotalHarga;
            totalHarga.innerHTML = "Total Harga: " + formattedAmount;
        }

            
    </script>
</html>
