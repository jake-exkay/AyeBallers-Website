 <?php

    echo '
    	<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="../../../index.php">AyeBallers</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Administration</div>
                            <a class="nav-link" href="../../../admin/dashboard.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fa fa-briefcase"></i>
                                </div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="../../../../enderpearl/dashboard.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fa fa-circle"></i>
                                </div>
                                Enderpearl (Coming Soon)
                            </a>
                            <a class="nav-link" href="../../../admin/playerstats.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fa fa-user"></i>
                                </div>
                                Player Statistics
                            </a>

                            <a class="nav-link" href="../../../admin/stafflist.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                Staff List
                            </a>

                            <a class="nav-link" href="../../../admin/manualimport.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fa fa-star"></i>
                                </div>
                                Manual Import
                            </a>
                            
                        </div>
                    </div>
                </nav>
            </div>

    ';

?>