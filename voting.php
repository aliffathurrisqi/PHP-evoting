<?php
include "config.php";
session_start();
$username = $_SESSION['username'];
$secretUser = md5($_SESSION['username']);

if ($_SESSION['username'] == NULL) {
    echo '<script>location.replace("index.php");</script>';
}

$periode = $_SESSION['periode'];
$loginInfo = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
$dataInfo = mysqli_fetch_array($loginInfo);

$voteInfo = mysqli_query($conn, "SELECT * FROM vote WHERE username = '$secretUser' AND id_periode = '$periode'");
$jmlVote = mysqli_num_rows($voteInfo);
if ($jmlVote > 0) {
    echo '<script> alert("Anda sudah memberikan suara"); </script>';
    echo '<script>
    location.replace("datavoting.php");
</script>';
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include "assets/php/head.php" ?>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <?php
        include "assets/php/navbar.php";
        include "assets/php/sidebar.php"
        ?>

        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-md-12 p-5">
                        <div class="card-deck">

                            <?php
                            $kandidat = mysqli_query($conn, "SELECT * FROM kandidat WHERE id_periode = '$periode'");

                            while ($data = mysqli_fetch_array($kandidat)) {
                            ?>
                                <div class="card">
                                    <img class="card-img-top" src="./assets/img/image.png" />
                                    <div class="card-body">
                                        <h5 class="card-title text-center"><?php echo $data['nama_kandidat']; ?></h5>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a class="btn btn-info text-light" href="vote.php?id=<?php echo $data['id']; ?>">
                                            <i class="bi bi-star-fill"></i> Pilih
                                        </a>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>


            </div>
            <!-- END PAGE CONTENT-->
            <!-- <footer class="page-footer">
                <div class="font-13">2018 © <b>AdminCAST</b> - All rights reserved.</div>
                <a class="px-4" href="http://themeforest.net/item/adminca-responsive-bootstrap-4-3-angular-4-admin-dashboard-template/20912589" target="_blank">BUY PREMIUM</a>
                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
            </footer> -->
        </div>
    </div>

    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="./assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script>
</body>

</html>