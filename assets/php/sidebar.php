        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="./assets/img/admin-avatar.png" width="40px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong"><?php echo $username; ?></div><small><?php echo $dataInfo['nama_lengkap'] ?></small>
                    </div>
                </div>
                <ul class="side-menu metismenu">
                    <li>
                        <a class="active" href="voting.php"><i class="sidebar-item-icon bi bi-star-fill"></i>
                            <span class="nav-label">Voting</span>
                        </a>
                    </li>
                    <li>
                        <a class="active" href="datavoting.php"><i class="sidebar-item-icon bi bi-pie-chart-fill"></i>
                            <span class="nav-label">Data Voting</span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->