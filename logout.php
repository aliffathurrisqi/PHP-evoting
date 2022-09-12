<?php
session_start();
$_SESSION['username'] = NULL;
echo '<script> location.replace("index.php"); </script>';
