<?php

    function displayOverallUpdateButton($mins) {
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
            echo '<form action="../../../functions/update_functions/overall_update.php">';
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
            echo '<form action="../../../functions/update_functions/guild_update.php">';
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
        echo '<div class="row">';
        echo '<div class="col-md-10" style="padding-left: 50px; padding-right: 50px; padding-top: 10px; padding-bottom: 20px;">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<img style="height: 50px; width: 50px;" src="assets/img/' . $name . '.png"/>';
        echo '<h5>' . $name . '</h5>';
        echo '<h6>' . $rank . '</h6>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    function displayGuildMember($name, $uuid, $rank) {
        echo '<div class="col-md-2" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 20px;">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<center><img style="height: 50px; width: 50px;" src="https://crafatar.com/avatars/' . $uuid . '"/>';
        echo '<h5>' . $name . '</h5>';
        echo '<h6>' . $rank . '</h6></center>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    function displayGuildMemberUpdateButton() {
        echo '<div>';
        if (apiLimitReached($API_KEY)) {
            echo '<button type="submit" title="API limit reached, please refresh the page." class="btn btn-danger">Update</button>';
        } else { 
            echo '<form action="../../../functions/update_functions/member_update.php">';
            echo '<button type="submit" title="Update guild members" class="btn btn-success">Update</button>';
            echo '</form>';
        }
        echo '</div>';
    }

?>