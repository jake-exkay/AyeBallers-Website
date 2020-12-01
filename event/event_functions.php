<?php

    $participants = array('a76b01c8a4c04f6ab1ab898f97469224','11b8466e2c724fe994a00cada8112674');

    function eventStatus($connection) {
        $query = "SELECT * FROM event_management";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $event_started = $row['event_started'];
            }
        }

        return $event_started;
    }

    function updateLog($connection, $event_function) {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        $query = "INSERT INTO update_log (IP, time_update, function)
                  VALUES (?, now(), ?)";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "ss", $ip, $event_function);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[LOG]</b> An Error Occured!<br>'; 
        }
    }

    function needsUpdating($connection) {
        $last_updated_query = "SELECT * FROM event_management";
        $last_updated_result = $connection->query($last_updated_query);

        if ($last_updated_result->num_rows > 0) {
            while($last_updated_row = $last_updated_result->fetch_assoc()) {
                $last_updated = $last_updated_row['last_updated'];
            }
        }

        $start_date = new DateTime($last_updated);
        $since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s')));

        if (empty($last_updated) || $since_start->i >= 5 || $since_start->y != 0 || $since_start->m != 0 || $since_start->d != 0 || $since_start->h != 0) {
            return true;
        } else {
            return false;
        }
    }

    function calculatePoints($connection, $uuid, $wins) {
        $query = "SELECT * FROM event WHERE UUID = '$uuid'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $starting_wins = $row['starting_wins'];
            }
        }

        $wins_points = $wins - $starting_wins;

        return $wins_points;
       
    }

    function setLastUpdated($connection) {
        $last_updated_query = "UPDATE event_management SET last_updated = now()";

        if($last_updated_statement = mysqli_prepare($connection, $last_updated_query)) {
            mysqli_stmt_execute($last_updated_statement);
        } else {
            echo '<b>[ERROR] </b>An Error Occured Updating Time!<br>'; 
        }
    }

    function updateTournamentPlayer($connection, $current_wins, $uuid, $name) {
        $query = "UPDATE event SET current_wins = ? WHERE UUID = ?";

        $event_wins = calculatePoints($connection, $uuid, $current_wins);

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "is", $current_wins, $uuid);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[ERROR] ' . $name . ' </b>An Error Occured!<br>'; 
        }
    }

    function insertNewPlayer($connection, $uuid, $name, $wins) {
        $query = "INSERT INTO event (UUID, name, starting_wins, current_wins)
                  VALUES (?, ?, ?, ?)";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "ssii", $uuid, $name, $wins, $wins);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[MW] ' . $name . ' </b>An Error Occured!<br> ' . $query . ' ' . mysqli_error($connection); 
        }
    }

    function insertBackupPlayer($connection, $uuid, $name, $wins) {
        $query = "INSERT INTO event_backup (UUID, name, starting_wins, current_wins)
                  VALUES (?, ?, ?, ?)";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "ssii", $uuid, $name, $wins, $wins);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[MW] ' . $name . ' </b>An Error Occured!<br> ' . $query . ' ' . mysqli_error($connection); 
        }
    }

    function isPlayerInDatabase($connection, $uuid) {
        $query = "SELECT * FROM event WHERE UUID = '$uuid'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function changeEventStatus($connection, $status) {
        $query = "UPDATE event_management SET event_started = $status";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[ERROR] ' . $name . ' </b>An Error Occured!<br>'; 
        }
    }

    function devViewing($connection, $dev_ip) {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if ($ip == $dev_ip) {
            return true;
        } else {
            return false;
        }
    }

    function getParticipantsData($connection) 
    {
        $query = "SELECT player.name, player.UUID, player.rank, player.rank_colour FROM pb3 INNER JOIN player ON player.UUID = pb3.UUID ORDER BY player.name";
        $result = $connection->query($query);
        return $result;
    }

    function getEventLeaderboard($connection) 
    {
        $query = "SELECT * FROM pb3 INNER JOIN player ON pb3.UUID = player.UUID ORDER BY pb3.total_points DESC";
        $result = $connection->query($query);
        return $result;
    }

?>