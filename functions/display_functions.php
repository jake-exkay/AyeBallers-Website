<?php

    function displayUpdateButton($mins) {
        echo '<div>';
        if ($mins < 10) {
            echo '<button type="submit" title="Last Updated: ' . $mins . ' minutes ago." class="btn btn-danger">Update</button>';
            if ($mins == 0) {
                echo "<p><i>Last Updated: A moment ago</i></p>";
            } elseif ($mins == 1) {
                echo "<p><i>Last Updated: " . $mins . " minute ago</i></p>";
            } else {
                echo "<p><i>Last Updated: " . $mins . " minutes ago</i></p>";
            }
            echo '<h6><i>(Leaderboard data can be updated every 10 minutes)</i></h6>';
        } else { 
            echo '<form action="../../overall_leaderboard_update.php">';
            echo '<button type="submit" title="Last Updated: ' . $mins . ' minutes ago." class="btn btn-success">Update</button>';
            if ($mins == 0) {
                echo "<p><i>Last Updated: A moment ago</i></p>";
            } elseif ($mins >= 60) {
                echo "<p><i>Last Updated: more than an hour ago</i></p>";
            } elseif ($mins == 1) {
                echo "<p><i>Last Updated: " . $mins . " minute ago</i></p>";
            } else {
                echo "<p><i>Last Updated: " . $mins . " minutes ago</i></p>";
            }
            echo '</form>';
        }
        echo '</div>';
    }

    function displayStaffMember($name, $rank, $role) {
        echo '<div class="col-md-6" style="padding-left: 50px; padding-right: 50px; padding-top: 10px; padding-bottom: 20px;">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h5>' . $rank . '</h5>';
        echo '<h5>' . $name . '</h5>';
        echo '<img style="height: 200px; width: 200px;" src="assets/img/' . $name . '.png"/>';
        echo '<h5>' . $role . '</h5>';                                    
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

?>