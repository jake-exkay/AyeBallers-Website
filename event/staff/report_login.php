<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../../css/styles.css" rel="stylesheet" />
        <link href="../../css/custom_styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="../../js/countdown.js"></script>

        <title>Report Management - Login</title>

        <?php
            include "staff_functions.php";
            include "../../includes/constants.php";

            if (isLoggedIn($connection)) {
                header("Refresh:0.05; url=reports.php");
            }

            if (isset($_POST['submit'])) {
                $pw = $_POST["pw"];
                if ($pw == $STAFF_PW) {
                    loginUser($connection);
                    header("Refresh:0.01; url=reports.php");
                } else {
                    header("Refresh:2; url=report_login.php");
                    echo "Error: Incorrect Password";
                }
            }

        ?>

    </head>

    <body>

        <div class="card">
            <div class="card-body">

                <form style="padding: 300px;" class="form-signin" name="loginForm" action="report_login.php" method="POST" enctype="multipart/form-data">

                    <div class="form-label-group">
                        <center>
                            <label>Password</label>
                        </center>
                        <input type="password" class="form-control" name="pw" placeholder="Password" required>
                    </div> 

                    <br>

                    <center>
                        <button name="submit" type="submit" class="btn btn-lg btn-primary">Login</button>
                    </center>

                </form>

            </div>
        </div>

    </body>
</html>