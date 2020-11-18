<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Player Search - AyeBallers</title>

        <?php

            include "includes/links.php";
            include "includes/connect.php";
            include "includes/constants.php";
            include "functions/functions.php";
            include "functions/display_functions.php";
            include "functions/text_constants.php";
            include "functions/player_functions.php";

            updatePageViews($connection, 'player_page', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php include "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

                	<div class="card">
            			<div class="card-body">

                			<form style="padding: 300px;" class="form-signin" name="playerForm" action="stats.php" method="GET" enctype="multipart/form-data">

                    			<div class="form-label-group">
                        			<center>
                            			<label>Player</label>
                        			</center>
                        			<input type="text" class="form-control" name="player" placeholder="Player Name" required>
                    			</div> 

                    			<br>

			                    <center>
			                        <button type="submit" class="btn btn-lg btn-primary">Search</button>
			                    </center>

                			</form>

			            </div>
			        </div>

            	</main>
                
                <?php include "includes/footer.php"; ?>

            </div>

    </body>
</html>
