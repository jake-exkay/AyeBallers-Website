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
			include "../../includes/connect.php";

			if (isset($_POST['submit'])) {
				logoutUser($connection);
                header("Refresh:0.01; url=report_login.php");
            }

			if (!isLoggedIn($connection)) {
				header("Refresh:0.02; url=report_login.php");
			} else {
				$directory = "../reports";
				$images = glob($directory . "/*.png");
			}

		?>

	</head>

	<body>

		<br>

		<center>
			<h2>AyeBallers Tournament Report Viewer</h2>
		</center>

		<br>

		<center>
			<form class="form-signin" name="logoutForm" action="reports.php" method="POST" enctype="multipart/form-data">
                   <button name="submit" type="submit" class="btn btn-lg btn-primary">Logout</button>
            </form>
        </center>

        <br>

		<?php 				
			foreach ($images as $image) {
				echo '<img width="800" height="auto" src="../reports/' . $image . '"/>';
			} 
		?>

	</body>
</html>