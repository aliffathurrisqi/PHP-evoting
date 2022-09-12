<?php
include "config.php";

$periode = '1';

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
                yValueFormatString: "#,##0.0\" %\"",
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
                yValueFormatString: "#,##0.0\" %\"",
                showInLegend: true,
                legendText: " {label} : {y}",
                dataPoints: <?php echo json_encode($dataSuara, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chartSuara.render();

    }
</script>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>

<div id="chartSuara" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>