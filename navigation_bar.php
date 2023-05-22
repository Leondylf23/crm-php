<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 ms-2" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.php">SFA</a>
    <!-- Navbar Search-->
    <div class="d-md-inline-block ms-auto me-0 me-md-3 my-2 my-md-0">
        <a class="navbar-brand ps-3"><?php echo $_SESSION['userName']; ?></a>
    </div>
    
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="user.php"><i class="fas fa-user me-2"></i>Profil</a></li>
                <!-- <li><a class="dropdown-item" href="notifikasi.php">Notifikasi</a></li> -->
                <li><hr class="dropdown-divider" /></li>
                <?php 
                    if (isset($_SESSION['log'])) {
                        echo '
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-right-from-bracket me-2"></i>Logout</a></li>
                        ';
                    } else {
                        echo '
                        <li><a class="dropdown-item" href="login.php"><i class="fas fa-right-to-bracket me-2"></i>Login</a></li>
                        ';
                    }
                ?>                    
            </ul>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Menu</div>    
                    <?php 
                        if(isset($_SESSION['role'])) {
                            if($_SESSION['role'] == 1) {
                                echo(
                                    '
                                    <a class="nav-link" href="dashboard.php">
                                        <div class="sb-nav-link-icon" style="width: 25px;"><i class="fas fa-chart-area"></i></div>
                                        Dashboard
                                    </a>
                                    '
                                );
                            }
                        } 
                    ?>
                    <a class="nav-link" href="pelanggan.php">
                        <div class="sb-nav-link-icon" style="width: 25px;"><i class="fas fa-users"></i></div>
                        Pelanggan
                    </a>
                    <a class="nav-link" href="produk.php">
                        <div class="sb-nav-link-icon" style="width: 25px;"><i class="fas fa-box"></i></div>
                        Produk
                    </a>
                    <a class="nav-link" href="transaksi.php">
                        <div class="sb-nav-link-icon" style="width: 25px;"><i class="fas fa-money-bill-wave"></i></div>                                Transaksi Penjualan
                    </a>
                    <a class="nav-link" href="penjadwalan.php">
                        <div class="sb-nav-link-icon" style="width: 25px;"><i class="fas fa-table"></i></div>
                        Aktifitas Sales
                    </a>                            
                    <a class="nav-link" href="komplain.php">
                        <div class="sb-nav-link-icon" style="width: 25px;"><i class="fas fa-bullhorn"></i></div>
                        Komplain
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Copyright © 2023 PT. Maju Jaya Kreasindo. All rights reserved.</div>
            </div>  
        </nav>
    </div>
    <!-- <div id="layoutSidenav_content"> -->
<!-- di sini jgn ditutup pke </div> lgi, ini buat div yg diatas lanjutin di page2
yg pke div atas -->
            
            