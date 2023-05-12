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
                                Tambah Transaksi
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
                                        $ambilsemuadatatransaksi = mysqli_query($conn, "SELECT t.idtransaksi, t.tanggal_transaksi, DATE_FORMAT(t.tanggal_transaksi, '%d-%m-%Y %H:%i') as tgl_formated, p.namapelanggan, t.totaltransaksi, mp.nama_metode, p.idpelanggan FROM transaksi t INNER JOIN pelanggan p ON p.idpelanggan = t.idpelanggan LEFT JOIN metode_pembayaran mp ON mp.id = t.idmetode where t.is_active = 1");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatatransaksi)){
                                            $idtransaksi = $data['idtransaksi'];
                                            $tanggaltransaksi = $data['tanggal_transaksi'];
                                            $tanggaltransaksif = $data['tgl_formated'];
                                            
                                            $namapelanggan = $data['namapelanggan'];
                                            $idpelanggan = $data['idpelanggan'];
                                            
                                            $totaltransaksi = $data['totaltransaksi'];
                                            $nama_metode = $data['nama_metode'];
                                            
                                        
                                        ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$tanggaltransaksif;?></td>
                                            <td><?=$namapelanggan;?></td>
                                            <td><?=$totaltransaksi;?></td>
                                            <td><?=$nama_metode;?></td>
                                            
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detil<?=$idtransaksi;?>">
                                                    Detil
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idtransaksi;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit The Modal -->
                                        <div class="modal fade" id="edit<?=$idtransaksi;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Transaksi</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="text" name="tanggal_transaksi" value="<?=$tanggaltransaksi;?>" class="form-control" required>
                                                            <br>
                                                            <input type="text" name="nama_pelanggan" value="<?=$namapelanggan;?>" class="form-control" required>
                                                            <br>
                                                            <input type="text" name="idproduk" value="<?=$idproduk;?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="harga_jual" value="<?=$hargajual;?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="harga_modal" value="<?=$modal;?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="untung" value="<?=$untung;?>" class="form-control" required>
                                                            <br>
                                                            <input type="hidden" name="idtransaksi" value="<?=$idtransaksi;?>">
                                                            <button type="submit" class="btn btn-primary" name="updatetransaksi">Submit</button>
                                                        </div>
                                                    </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Detil -->
                                            <div class="modal fade" id="detil<?=$idtransaksi;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Detil Transaksi</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <input type="text" disabled value="<?=$tanggaltransaksi;?>" class="form-control">
                                                        <input type="text" disabled value="<?=$namapelanggan;?>" class="form-control">
                                                        <input type="text" disabled value="<?=$totaltransaksi;?>" class="form-control">
                                                        <input type="text" disabled value="<?=$nama_metode;?>" class="form-control">
                                                        <br>
                                                        <h4>Detil - Detil Produk:</h4>
                                                        <div style="height: max(40vh); overflow-y: auto;">
                                                        <?php 
                                                            $a = 0;
                                                            $a++;
                                                            $dataDetail = mysqli_query($conn, "select * from transaksi_detail td inner join produk p on td.idproduk = p.idproduk where td.idtransaksi = $idtransaksi");
                                                            while($fetcharray = mysqli_fetch_array($dataDetail)){
                                                                $namaItem = $fetcharray['nama_item'];
                                                                $qtyTd = $fetcharray['qty'];
                                                                $prcPrdk = $fetcharray['harga_jual'];
                                                                $prcTotal = $fetcharray['totalharga'];
                                                                

                                                        ?>

                                                        <div>
                                                            <b><?= $namaItem ?></b>
                                                            <br>
                                                            <input type="text" disabled value="<?=$qtyTd;?>" class="form-control">
                                                            <br>
                                                            <input type="text" disabled value="<?=$prcPrdk;?>" class="form-control">
                                                            <br>
                                                            <input type="text" disabled value="<?=$prcTotal;?>" class="form-control">
                                                            <br>
                                                        </div>

                                                        <?php
                                                            } 
                                                        ?>
                                                        </div>
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
                    <div <?php if($_SESSION['role'] != 1) {echo('style="display: none;"');} ?>>
                        <a href="transaksi_recovery.php" style="padding-left: 25px;">Pemulihan data</a>
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
            <form method="post">
                <div class="modal-body">
                    <select name="pelanggannya" class="form-control">
                        <?php 
                        $ambilsemuadatapelanggannya = mysqli_query($conn, "select * from pelanggan where is_active = 1");
                        while($fetcharray = mysqli_fetch_array($ambilsemuadatapelanggannya)){
                            $namapelanggannya = $fetcharray['namapelanggan'];
                            $idpelanggannya = $fetcharray['idpelanggan'];
                        ?>

                        <option value="<?=$idpelanggannya;?>"><?=$namapelanggannya;?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <select name="metodepembayaran" class="form-control">
                        <?php 
                        $data = mysqli_query($conn, "select * from metode_pembayaran");
                        while($fetcharray = mysqli_fetch_array($data)){
                            $metode = $fetcharray['nama_metode'];
                            $idmp = $fetcharray['id'];
                        ?>

                        <option value="<?=$idmp;?>"><?=$metode;?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <input type="hidden" id="totalprice" name="totalprice" />
                    <b id="totalHarga">Total Harga: IDR 0.00</b>
                    <br>
                    <br>
                    <button type="button" class="btn btn-primary mb-2" onclick=addItem()>Tambah Produk</button>
                        
                    <div class="mb-2" id="table-data" style="height: max(40vh); overflow-y: auto;">
                        <input type="hidden" id="totaldata" name="totaldata" >
                        <!-- Buat isi data -->
                    </div>
                    
                    <button type="submit" class="btn btn-primary" name="addnewtransaction">Submit</button>
                </div>
            </form>

            </div>
        </div>
    </div>
    <script>
        var i = 0;
        var prdkOptions = [];
        var addedPrdk = [];

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
            
            var h4 = document.createElement("h4");
            h4.setAttribute("class", "modal-title mb-4");
            // h4.setAttribute("id", "h4-"+i);
            h4.innerHTML = "Item ";
            newElement.appendChild(h4);

            //data
            const prdkElmnt = document.createElement("select");
            prdkElmnt.setAttribute("id", "prdk-" + i);
            prdkElmnt.setAttribute("class", "form-control mb-3");
            prdkElmnt.setAttribute("placeholder", "Cari Produk");
            prdkElmnt.setAttribute("name", "prdk-" + i);
            prdkElmnt.setAttribute("onchange", "prdkOnChange("+ i +", this)");

            const prdkOption = document.createElement("option");
            prdkOption.setAttribute("value",0);
            prdkOption.innerHTML = "Pilih Produk";
            prdkElmnt.appendChild(prdkOption);

            prdkOptions.forEach(e => {
                const prdkOption = document.createElement("option");
                prdkOption.setAttribute("value",e.id);
                prdkOption.innerHTML = e.nama;
                prdkElmnt.appendChild(prdkOption);
            });
            newElement.appendChild(prdkElmnt);

            const qtyElmnt = document.createElement("input");
            qtyElmnt.setAttribute("id", "qty-" + i);
            qtyElmnt.setAttribute("class", "form-control mb-3");
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
            const br2 = document.createElement("br");
            newElement.appendChild(br2);

            const deleteBtn = document.createElement("button");
            deleteBtn.setAttribute("type", "button");
            deleteBtn.setAttribute("class", "btn btn-danger");
            deleteBtn.setAttribute("onclick", "removeItem("+i+")");
            deleteBtn.innerHTML = "Hapus";
            newElement.appendChild(deleteBtn);

            const delBtn = document

            i++;

            const identifierElmnt = document.getElementById("totaldata");
            identifierElmnt.value = i;

            tableData.appendChild(newElement);
        }

        function prdkOnChange(dataId, element) {
            const prcDataElmnt = document.getElementById("prcSatuan-"+dataId);
            const prcDataHdnElmnt = document.getElementById("prcSatuanHdn-"+dataId);
            const prcTotalElmnt = document.getElementById("prcTotal-"+dataId);
            const prcTotalHdnElmnt = document.getElementById("prcTotalHdn-"+dataId);
            const selectedId = element.value;
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
            
            qtyOnChage(dataId, qtyInputElmnt)
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
