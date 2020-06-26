<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

        <title>Event Report</title>

    </head>

    <body class="sb-nav-fixed">

        <?php include "../includes/connect.php"; ?>

        <?php require "../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <center>
                            <b><h1 class="mt-4">Report NoxyD/Rezzus User</h1></b>
                            <p>Due to a high amount of requests, the <b>NoxyD</b> and <b>Rezzus</b> hats are banned for tournament participants. As there is no real way of enforcing these rules, players can report other players if they are seen using these hats. Please upload a screenshot below and it will be reviewed. Players using these hats may be removed from the tournament.</p>
                            <p>Please note: all reports are anonymous, please upload a full minecraft screenshot, cropped images will not be taken into account.</p>

                            <br><br>
                        
                            <p><a href="leaderboard.php">Back To Leaderboard</a></p>

                        </center>
                        
                        <br>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Report Player
                            </div>
                            <div class="card-body">
                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                    Select image to upload:
                                    <input type="file" name="uploadedFile" id="uploadedFile">
                                    <input type="submit" value="Upload Image" name="submit">
                                </form>
                            </div>
                        </div>

                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; AyeBallers / ExKay 2020</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../../../assets/demo/chart-area-demo.js"></script>
        <script src="../../../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../../../assets/demo/datatables-demo.js"></script>
    </body>
</html>
