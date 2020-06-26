<?php

	include "../includes/connect.php";
    include "../includes/constants.php";
    include "event_functions.php";
    include "../functions/functions.php";

    if (devViewing($connection, $DEV_IP)) {
        if (eventStatus($connection) == 0) {
            echo "Error: Event is not running. Redirecting.";
            header("Refresh:2; url=leaderboard.php");
        } else {
            echo "Event Ended. Redirecting.";

            changeEventStatus($connection, 2);

            header("Refresh:2; url=leaderboard.php");
        }
    } else {
        echo "Error: No permission.";
        header("Refresh:1; url=leaderboard.php");
    }

    $connection->close();

?>