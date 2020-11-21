<?php
/**
 * Player page - Allows for searching for specific players.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/player.php
 */

require "includes/links.php";

updatePageViews($connection, 'player_page', $DEV_IP);

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Player Search - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

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
            
            <?php require "includes/footer.php"; ?>

        </div>

    </body>
</html>
