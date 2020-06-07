<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <link href="css/custom_styles.css" rel="stylesheet" />
        <title>Event - AyeBallers</title>

        <?php

            include "includes/connect.php";
            include "functions/functions.php";

            updatePageViews($connection, 'events');

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>

                    <center><img style="padding-top: 50px" class="website_header" src="assets/img/ayeballers.png"/></center>

                    <center><h2 style="font-family: BKANT, sans-serif">Next Event</h2></center>
                    <center><h3 style="font-family: BKANT, sans-serif">TBA</h2></center>

                    <!-- Display the countdown timer in an element -->
                    <center><h1 style="font-family: BKANT, sans-serif" id="demo"></h1></center>

                    <script>
                        // Set the date we're counting down to
                        var countDownDate = new Date("May 23, 2020 22:00:00").getTime();

                        // Update the count down every 1 second
                        var x = setInterval(function() {

                          // Get today's date and time
                          var now = new Date().getTime();

                          // Find the distance between now and the count down date
                          var distance = countDownDate - now;

                          // Time calculations for days, hours, minutes and seconds
                          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                          var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                          // Display the result in the element with id="demo"
                          document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                          + minutes + "m " + seconds + "s ";

                          // If the count down is finished, write some text
                          if (distance < 0) {
                            clearInterval(x);
                            document.getElementById("demo").innerHTML = "";
                          }
                        }, 1000);
                    </script>
                    
                </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; AyeBallers / ExKay 2020</div>
                    </div>
                </div>
            </footer>
        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
