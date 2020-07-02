<?php

    $participants = array('bb0b8eeedc584ee9bbf7c590d5aa2319','dda3fc724a8f467b8a8033aadde1b569','a344f3da8a6145b48de72e67c1f47d68','e56feecaa92b48799838b5854bf96e94','dc4c8cadcf684ef8a95208520136ccc3','68ebc017179e46fab198211c038bb5e5','e0160b312d1945d5b2afb289b0cdf7fa','d3a95194b1bf4cb4836c7388236aa2f0','6691e00765fa40c7aa033c63dc318eb3','796cf0f4332c447d88a6fbfffbe0bd70','9424483cee334c28b3572d3cc77eb6b6','551149424b504206af009a1fa56490b3','47d4bf0a89dd4eba9d198c03baf3b980','0f639d26aa51462f81b3d602604eb204','5e5af7934a504d60acad3ab18763dc8c','53366216b97f457690c2ece2adf509a4','e8dd1375bf544941a80867e2a6fa6491','31ff34353b4c451aa0a14d1185e17f68','e86baaede4e346269ae5b05bc13a14d7','61c86088a35c42749b57165bb8cd04f3','ba55489938d241ea8048a59a00ba112a','a76b01c8a4c04f6ab1ab898f97469224','3ab55a5d31fe4ceb86e069c5b3ea91d6','3b1314281dd64607abdb3880b8188755','d3b48bc94ca04364a4b81abe3f75b042','6172d00413c0435daf17e8ecb19f4acf','8023dde0756d4e44b3090bb3ff53e134','b366e68639834cae81401b458c1c11fa','6b3053e95f404ca4982b039c8a9729bb','bb4314a7cbc44e1a8f12d62b21f8671e','7b08e95d217149efb27e0e7aa26d7b70','4994e1acecf141eb80d0dba13be7cb63','4b3b5333e9444f2c8762377729a18c59','14016bbfdcf547dab04549b49e891dc8','9fba9f186ff74966a49f7e2b109cf9cf','a1adc3f692ac4014ab0750c10ecff9c0','7e6fa1c92077403a8407b9ad34159e7e','d2ad0fd83f4a475fbbc17ef1d1a43deb','9c2714fa13e6469aa6532d7bdfd86dff','ad961abf28f34496aac451f664c1d56a','44ad14730a2a4e919559f6f614478156','3ad78f14d5524fa4b54a1cbb40980942','f97516456be14f6097235052570ed256','2e1884f69c294bd589e6d7709b100298','486eb6e2ab764dd480c34b337692af9c','26548587ca8b4183984d7559514a78a9','55308348096d4798bed699f831b75f97','d638d31ca9f04bd1b7f1bbf1b9df8dae','ad988df25a274cf592b66c9562834230','bd72d06292684a8f9b951239b94ac81f','93d63eb4c243429f8b71a301eff9853f','8ad3b6f4b99745a0ba9d78670c4fa127','ede6a270051b4dadb8ec1758542dbbbe','7877dfc253e349d2a989538cde3ee189','833141152ece47f7bde0b1594af0e60e','687cf91319a246dfb54fa869c5d31554','44b04beefac2498f9d444150794db020','c8101d738d354edbb495c0e46f5627f6','0ebbcd9236334526891af790b20610a5','f385df39505b45989f1ea5c0cf158380','129040ec0e7d4afa8c4016bb5d0a7fbd','82df5a8fa7934e6087d186d8741a1d23','38839c0e43ac4b1aa0e6c189ca15412f');

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