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
        <title>Data Produk</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    <?php require "navigation_bar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Produk</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                    <i class="fas fa-plus me-1"></i>
                                    Produk
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <!-- <th>No.</th> -->
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Jenis</th>
                                            <th>Merek</th>
                                            <th>Tipe Item</th>
                                            <th>Satuan</th>
                                            <th>Harga Pokok</th>
                                            <th>Harga Jual</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $ambilsemuadataproduk = mysqli_query($conn, "select idproduk, kode_produk, nama_item, jenis, merek, tipe_item, satuan, CONCAT('Rp. ', FORMAT(harga_pokok, 2, 'id_ID')) as harga_pokok_str, harga_pokok, CONCAT('Rp. ', FORMAT(harga_jual, 2, 'id_ID')) as harga_jual_str, harga_jual, keterangan, is_active from produk order by is_active desc");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadataproduk)){
                                            $idproduk = $data['idproduk'];
                                            $kodeproduk = $data['kode_produk'];
                                            $namaproduk = $data['nama_item'];
                                            $jenisproduk = $data['jenis'];
                                            $merkproduk = $data['merek'];
                                            $tipeitem = $data['tipe_item'];
                                            $satuan = $data['satuan'];
                                            $hargapokokstr = $data['harga_pokok_str'];
                                            $hargapokok = $data['harga_pokok'];
                                            $hargajualstr = $data['harga_jual_str'];
                                            $hargajual = $data['harga_jual'];
                                            $keterangan = $data['keterangan'];
                                            $status = $data['is_active'];
                                            if($status == 1) {
                                                $status = "Aktif";
                                            } else {
                                                $status = "Tidak Aktif";
                                            }
                                        
                                        ?>

                                        <tr>
                                            <!-- <td><?=$i++;?></td> -->
                                            <!-- <td><?=$idproduk;?></td> -->
                                            <td><?=$kodeproduk;?></td>
                                            <td><?=$namaproduk;?></td>
                                            <td><?=$jenisproduk;?></td>
                                            <td><?=$merkproduk;?></td>
                                            <td><?=$tipeitem;?></td>
                                            <td><?=$satuan;?></td>
                                            <td><?=$hargapokokstr;?></td>
                                            <td><?=$hargajualstr;?></td>
                                            <td><?=$keterangan;?></td>
                                            <td><?=$status;?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?=$idproduk;?>">
                                                    Detil
                                                </button>
                                                <!-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idproduk;?>">
                                                    Hapus
                                                </button> -->
                                            </td>
                                        </tr>

                                        <!-- Edit The Modal -->
                                        <div class="modal fade" id="edit<?=$idproduk;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Detil Produk</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <div class="form-floating mb-3">                
                                                                <input type="text" name="kodeproduk" value="<?=$kodeproduk;?>" class="form-control" id="kdprdk" required>
                                                                <label for="kdprdk">Kode Produk</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                    
                                                                <input type="text" name="namaproduk" value="<?=$namaproduk;?>" class="form-control" id="nmprdk" required>
                                                                <label for="nmprdk">Nama Produk</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                    
                                                                <input type="text" name="jenisproduk" value="<?=$jenisproduk;?>" class="form-control" id="jenis" required>
                                                                <label for="jenis">Jenis</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                    
                                                                <input type="text" name="merkproduk" value="<?=$merkproduk;?>" class="form-control" id="mrk" required>
                                                                <label for="mrk">Merk Produk</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                    
                                                                <!-- <input type="text" name="tipeitem" value="<?=$tipeitem;?>" class="form-control" id="tpitem" required> -->
                                                                <select class="form-control" id="tpitem" name="tipeitem" required>
                                                                    <option value="INV" <?php if($tipeitem == "INV") {echo"selected";} ?>>INV</option>
                                                                    <option value="QUA" <?php if($tipeitem == "QUA") {echo"selected";} ?>>QUA</option>
                                                                    <option value="DMG" <?php if($tipeitem == "DMG") {echo"selected";} ?>>DMG</option>
                                                                </select>
                                                                <label for="tpitem">Tipe Item</label>
                                                            </div>
                                                            <div class="form-floating mb-3">  
                                                                <!-- <input type="text" name="satuan" value="<?=$satuan;?>" class="form-control" id="satuan" required> -->
                                                                <select class="form-control" id="satuan" name="satuan" required>
                                                                    <option value="PCS" <?php if($satuan == "PCS") {echo"selected";} ?>>PCS</option>
                                                                    <option value="BOX" <?php if($satuan == "BOX") {echo"selected";} ?>>BOX</option>
                                                                    <option value="GALON" <?php if($satuan == "GALON") {echo"selected";} ?>>GALON</option>
                                                                    <option value="BTL" <?php if($satuan == "BTL") {echo"selected";} ?>>BTL</option>
                                                                    <option value="RIM" <?php if($satuan == "RIM") {echo"selected";} ?>>RIM</option>
                                                                </select>                  
                                                                <label for="satuan">Satuan</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                    
                                                                <input type="number" name="hargapokok" value="<?=$hargapokok;?>" class="form-control" id="hgpokok" required>
                                                                <label for="hgpokok">Harga Pokok (Rp. )</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                    
                                                                <input type="number" name="hargajual" value="<?=$hargajual;?>" class="form-control" id="hgjual" required>
                                                                <label for="hgjual">Harga Jual (Rp. )</label>
                                                            </div>
                                                            <div class="form-floating mb-3">                    
                                                                <input type="text" name="keterangan" value="<?=$keterangan;?>" class="form-control" id="ket" required>
                                                                <label for="ket">Keterangan</label>
                                                            </div>                                                            
                                                            <input type="hidden" name="idproduk" value="<?=$idproduk;?>">
                                                            
                                                            <?php 
                                                                if($status == "Aktif") {
                                                                    echo("
                                                                    <button type='submit' class='btn btn-warning' name='updateproduk'>Edit</button>
                                                                    
                                                                    <button type='button' class='btn btn-danger ms-3' data-bs-toggle='modal' data-bs-target='#delete$idproduk'>
                                                                        Non-aktifkan
                                                                    </button>
                                                                    ");
                                                                }  else {
                                                                    echo("
                                                                    
                                                                        <button type='submit' class='btn btn-warning' name='pulihproduk'>
                                                                            Aktifkan
                                                                        </button>
                                                                    
                                                                    ");
                                                                }
                                                            
                                                            ?>                                                              
                                                        </div>
                                                    </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete The Modal -->
                                            <div class="modal fade" id="delete<?=$idproduk;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Nonaktifkan Produk?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menonaktifkan <?=$namaproduk;?>?
                                                            <input type="hidden" name="idproduk" value="<?=$idproduk;?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapusproduk">Non-aktifkan</button>
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
                        <a href="produk_recovery.php" style="padding-left: 25px;">Pemulihan data</a>
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
                <h4 class="modal-title">Tambah Produk Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" name="kodeproduk" placeholder="Kode Produk" class="form-control" id="kdprdkn" required>
                        <label for="kdprdkn">Kode Produk</label>                        
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="namaproduk" placeholder="Nama produk" class="form-control" id="nmprdkn" required>
                        <label for="nmprdkn">Nama Produk</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="jenisproduk" placeholder="Jenis" class="form-control" id="jenisn" required>
                        <label for="jenisn">Jenis</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="merkproduk" placeholder="Merk" class="form-control" id="merkn" required>
                        <label for="merkn">Merk Produk</label>
                    </div>
                    <div class="form-floating mb-3">                    
                        <!-- <input type="text" name="tipeitem" placeholder="Tipe Item" class="form-control" id="tpitemn" required> -->
                        <select class="form-control" id="tpitemn" name="tipeitem" required>
                            <option value="INV">INV</option>
                            <option value="QUA">QUA</option>
                            <option value="DMG">DMG</option>
                        </select>
                        <label for="tpitemn">Tipe Item</label>
                    </div>
                    <div class="form-floating mb-3">                    
                        <!-- <input type="text" name="satuan" placeholder="Satuan" class="form-control" id="satuann" required> -->
                        <select class="form-control" id="satuann" name="satuan" required>
                            <option value="PCS">PCS</option>
                            <option value="BOX">BOX</option>
                            <option value="GALON">GALON</option>
                            <option value="BTL">BTL</option>
                            <option value="RIM">RIM</option>
                        </select>
                        <label for="satuann">Satuan</label>
                    </div>
                    <div class="form-floating mb-3">                        
                        <input type="number" name="hargapokok" class="form-control" placeholder="Harga Pokok" id="hgpokokn" step=1000 required>
                        <label for="hgpokokn">Harga Pokok (Rp. )</label>
                    </div>
                    <div class="form-floating mb-3">                    
                        <input type="number" name="hargajual" class="form-control" placeholder="Harga Jual" id="hgjualn" step=1000 required>
                        <label for="hgjualn">Harga Jual (Rp. )</label>
                    </div>
                    <div class="form-floating mb-3">                    
                        <input type="text" name="keterangan" placeholder="Keterangan" class="form-control" id="ketn">
                        <label for="ketn">Keterangan</label>
                    </div>
                    <button type="submit" class="btn btn-primary" name="addnewproduct">Submit</button>
                </div>
            </form>

            </div>
        </div>
    </div>
</html>
