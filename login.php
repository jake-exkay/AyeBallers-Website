<?php
/**
 * Login page - Allows users to login to admin panel.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/login.php
 */

require "includes/links.php";
require "functions/functions.php";
include "admin/functions/login_functions.php";

if (isLoggedIn($connection)) {
    header("Refresh:0.05; url=index.php");
}

if (isset($_POST['submit'])) {
    $password = $_POST["password"];
    $username = $_POST["username"];
    if (password_verify($password, getDBPassword($connection, $username))) {
        if (loginUser($connection, $username)) {
            header("Refresh:0.05; url=index.php");
        } else {
            echo '<div class="alert alert-danger" role="alert">Error: Incorrect Login Details.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: Incorrect Login Details.</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Login - AyeBallers</title>
    </head>

    <body style="background-image: url('assets/img/background.jpg'); background-repeat: no-repeat; background-attachment: fixed; background-size: cover;" class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

        <div id="layoutSidenav_content">

            <main style="padding-right: 25%; padding-left: 25%; padding-top: 100px">

                <div style="background-color:#FFF;; opacity: 0.8; filter:(opacity=50);" class="card">
                    <div class="card-body">

                        <form class="form-signin" name="loginForm" action="login.php" method="POST" enctype="multipart/form-data">

                            <center>
                                <img alt="AyeBallers Logo" src="assets/img/ayeballers.png" height=auto width=100% />
                            </center>

                            <br>

                            <center>
                                <h3 class="ayeballers_font">User Login</h3>
                                <p>Please note: User accounts are limited and cannot be created.</p>
                            </center>

                            <br>

                            <input type="text" class="form-control" name="username" placeholder="Username" required>

                            <br>

                            <input type="password" class="form-control" name="password" placeholder="Password" required>

                            <center>
                                <button name="submit" type="submit" class="btn btn-lg btn-primary">Login</button>
                            </center>

                        </form>
                    </div>
                </div>

            </main>
            
            <?php require "includes/footer.php"; ?>

        </div>

    </body>
</html>
