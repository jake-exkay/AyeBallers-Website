<?php

    $participants = array('bb0b8eeedc584ee9bbf7c590d5aa2319','dda3fc724a8f467b8a8033aadde1b569','a344f3da8a6145b48de72e67c1f47d68','e56feecaa92b48799838b5854bf96e94','dc4c8cadcf684ef8a95208520136ccc3','68ebc017179e46fab198211c038bb5e5','e0160b312d1945d5b2afb289b0cdf7fa','d3a95194b1bf4cb4836c7388236aa2f0','6691e00765fa40c7aa033c63dc318eb3','796cf0f4332c447d88a6fbfffbe0bd70','9424483cee334c28b3572d3cc77eb6b6','551149424b504206af009a1fa56490b3','47d4bf0a89dd4eba9d198c03baf3b980','0f639d26aa51462f81b3d602604eb204','5e5af7934a504d60acad3ab18763dc8c','53366216b97f457690c2ece2adf509a4','e8dd1375bf544941a80867e2a6fa6491','31ff34353b4c451aa0a14d1185e17f68','e86baaede4e346269ae5b05bc13a14d7','61c86088a35c42749b57165bb8cd04f3','ba55489938d241ea8048a59a00ba112a','a76b01c8a4c04f6ab1ab898f97469224','3ab55a5d31fe4ceb86e069c5b3ea91d6','3b1314281dd64607abdb3880b8188755');

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

    function calculatePoints($connection, $uuid, $kills, $wins, $deaths, $ff) {
        $query = "SELECT * FROM event WHERE UUID = '$uuid'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $starting_kills = $row['starting_kills'];
                $starting_wins = $row['starting_wins'];
                $starting_ff = $row['starting_ff'];
                $starting_deaths = $row['starting_deaths'];
            }
        }

        $kills_points = $kills - $starting_kills;
        $wins_points = $wins - $starting_wins;
        $ff_points = $ff - $starting_ff;
        $deaths_points = $deaths - $starting_deaths;

        $total_points = $kills_points + ($wins_points * 15) + ($ff_points * 5 / 60) - $deaths_points;
        return $total_points;
       
    }

    function setLastUpdated($connection) {
        $last_updated_query = "UPDATE event_management SET last_updated = now()";

        if($last_updated_statement = mysqli_prepare($connection, $last_updated_query)) {
            mysqli_stmt_execute($last_updated_statement);
        } else {
            echo '<b>[ERROR] </b>An Error Occured Updating Time!<br>'; 
        }
    }

    function updatePlayer($connection, $total_points, $current_kills, $current_deaths, $current_wins, $current_forcefield, $uuid, $name) {
        $query = "UPDATE event SET total_points = ?, current_kills = ?, current_deaths = ?, current_wins = ?, current_ff = ? WHERE UUID = ?";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "iiiiis", $total_points, $current_kills, $current_deaths, $current_wins, $current_forcefield, $uuid);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[ERROR] ' . $name . ' </b>An Error Occured!<br>'; 
        }
    }

    function insertNewPlayer($connection, $uuid, $name, $kills, $wins, $forcefield_time, $deaths, $zero) {
        $query = "INSERT INTO event (UUID, name, starting_kills, starting_wins, starting_ff, starting_deaths, total_points, current_kills, current_wins, current_ff, current_deaths)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "ssiiiiiiiii", $uuid, $name, $kills, $wins, $forcefield_time, $deaths, $zero, $kills, $wins, $forcefield_time, $deaths);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[PAINTBALL] ' . $name . ' </b>An Error Occured!<br> ' . $query . ' ' . mysqli_error($connection); 
        }
    }

    function insertBackupPlayer($connection, $uuid, $name, $kills, $wins, $forcefield_time, $deaths, $zero) {
        $query = "INSERT INTO event_backup (UUID, name, starting_kills, starting_wins, starting_ff, starting_deaths, total_points, current_kills, current_wins, current_ff, current_deaths)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "ssiiiiiiiii", $uuid, $name, $kills, $wins, $forcefield_time, $deaths, $zero, $kills, $wins, $forcefield_time, $deaths);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[PAINTBALL] ' . $name . ' </b>An Error Occured!<br> ' . $query . ' ' . mysqli_error($connection); 
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

?>