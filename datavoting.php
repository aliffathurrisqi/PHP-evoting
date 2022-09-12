<?php
include "config.php";
session_start();
$username = $_SESSION['username'];
$periode = $_SESSION['periode'];
$loginInfo = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
$dataInfo = mysqli_fetch_array($loginInfo);

if ($_SESSION['username'] == NULL) {
    echo '<script>location.replace("index.php");</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include "assets/php/head.php" ?>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <?php
        include "assets/php/navbar.php";
        include "assets/php/sidebar.php" ?>
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-md-12 p-5">
                        <div class="ibox">

                            <?php
                            $dataVoting = mysqli_query($conn, "SELECT kandidat.id,kandidat.nama_kandidat,vote.id_periode FROM vote 
INNER JOIN kandidat ON vote.id_kandidat = kandidat.id 
INNER JOIN periode ON kandidat.id_periode = periode.id WHERE vote.id_periode = '$periode' GROUP BY vote.id_kandidat");



                            $dataPoints = array();
                            if (mysqli_num_rows($dataVoting)) {
                                while ($data = mysqli_fetch_assoc($dataVoting)) {
                                    $IDkadidat = $data['id'];
                                    $kadidat = $data['nama_kandidat'];
                                    $persen = mysqli_query($conn, "SELECT ROUND((
            (SELECT COUNT(id_kandidat) FROM vote WHERE id_kandidat = '$IDkadidat')/(SELECT COUNT(id) FROM vote WHERE id_periode = $periode) * 100)
            ,2) AS presentase;");

                                    $dataPersen = mysqli_fetch_array($persen);
                                    $presentase = $dataPersen['presentase'];

                                    $dataPoints[] = array("label" => "$kadidat", "symbol" => "$kadidat", "y" => "$presentase");
                                }
                            }

                            // $data = json_encode(array($dataPoints));
                            // echo $data;

                            $persenSuara = mysqli_query($conn, "SELECT ROUND((
    (SELECT COUNT(id) FROM vote WHERE id_periode = '$periode')
    /(SELECT COUNT(username) FROM user WHERE akses != 'admin') * 100)
    ,2) AS presentase");

                            $dataPersenSuara = mysqli_fetch_array($persenSuara);
                            $presentaseSuara = $dataPersenSuara['presentase'];

                            $dataSuara = array(
                                array("label" => "Suara Masuk", "symbol" => "Suara Masuk", "y" => "$presentaseSuara"),
                                array("label" => "Kosong", "symbol" => "Kosong", "y" => (100 - "$presentaseSuara"))
                            );

                            ?>

                            <script>
                                window.onload = function() {

                                    var chart = new CanvasJS.Chart("chartContainer", {
                                        theme: "light2",
                                        animationEnabled: true,

                                        data: [{
                                            type: "doughnut",
                                            indexLabel: "{symbol} - {y}",
                                            yValueFormatString: "##0.00\" %\"",
                                            showInLegend: true,
                                            legendText: " {label} : {y}",
                                            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                                        }]
                                    });
                                    chart.render();

                                    var chartSuara = new CanvasJS.Chart("chartSuara", {
                                        theme: "light",
                                        animationEnabled: true,

                                        data: [{
                                            type: "doughnut",
                                            indexLabel: "{symbol} - {y}",
                                            yValueFormatString: "##0.00\" %\"",
                                            showInLegend: true,
                                            legendText: " {label} : {y}",
                                            dataPoints: <?php echo json_encode($dataSuara, JSON_NUMERIC_CHECK); ?>
                                        }]
                                    });
                                    chartSuara.render();

                                }
                            </script>

                            <div class="ibox-head">
                                <div class="ibox-title">Perolehan Suara</div>
                            </div>
                            <div class="ibox-body">

                                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                            </div>
                        </div>
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Jumlah Suara Masuk</div>
                            </div>
                            <div class="ibox-body">
                                <div id="chartSuara" style="height: 200px; width: 100%;"></div>
                                <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                            </div>
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