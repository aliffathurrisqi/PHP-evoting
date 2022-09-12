<?php
include "config.php";
session_start();
$periode = $_SESSION['periode'];
$id = $_GET['id'];
$username = $_SESSION['username'];

mysqli_query($conn, "INSERT INTO vote VALUES(NULL,'$periode','$id',md5('$username'))");
echo '<script> alert("Anda sudah memberikan suara"); </script>';
echo '<script>
    location.replace("datavoting.php");
</script>';
