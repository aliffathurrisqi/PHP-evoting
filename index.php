<?php
include "config.php";
session_start();


$cekPemilu = mysqli_query($conn, "SELECT * FROM periode WHERE status = 'aktif'");
$dataPemilu = mysqli_fetch_array($cekPemilu);
$countPemilu = mysqli_num_rows($cekPemilu);

if ($countPemilu > 0) {
    $_SESSION['periode'] = $dataPemilu['id'];
}

?>
<!DOCTYPE html>
<html>

<?php include "assets/php/head.php" ?>

<body class="bg-silver-300 p-5">
    <div class="mb-5 p-5">
    </div>
    <div class="content mt-5">
        <div>
            <h1 class="login-title">Alfari E-Voting</h1>
        </div>
        <form id="login-form" method="post">
            <h2 class="login-title">Masuk</h2>
            <?php

            if (isset($_POST["btnLogin"])) {
                $login_username = $_POST['username'];
                $login_password = $_POST['password'];

                $login = mysqli_query($conn, "SELECT * FROM user WHERE username = '$login_username'");
                $count = mysqli_num_rows($login);
                if ($count == 1) {
                    while ($row = mysqli_fetch_array($login)) {
                        if ($login_username == $row['username'] && $login_password == $row['password']) {

                            if ($row['akses'] == "user") {
                                $_SESSION['username'] = $login_username;
                                if ($countPemilu > 0) {
                                    echo '<script> location.replace("voting.php"); </script>';
                                } else {
                                    echo '<script> location.replace("dashboard.php"); </script>';
                                }
                            }
                            if ($row['akses'] == "admin") {
                                $_SESSION['username'] = $login_username;
                                echo '<script> location.replace("admin/"); </script>';
                            }
                        } else {
            ?>
                            <div class="alert alert-danger align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Username dan Password tidak cocok
                            </div>
                    <?php
                        }
                    }
                } else {
                    ?>
                    <div class="alert alert-danger align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Username tidak ditemukan
                    </div>
            <?php
                }
            }
            ?>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="bi bi-person-fill"></i></div>
                    <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="bi bi-key-fill"></i></i></div>
                    <input class="form-control" type="password" name="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-block" type="submit" name="btnLogin">Login</button>
            </div>
            <div class="text-center">Created by
                <a href="#">Alfari Studio</a>
            </div>
        </form>
    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->
    <script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        $(function() {
            $('#login-form').validate({
                errorClass: "help-block",
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
            });
        });
    </script>
</body>

</html>