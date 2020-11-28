<?php

    function update_stats($connection, $uuid, $name, $API_KEY) {
        $uuid = "82df5a8f-a793-4e60-87d1-86d8741a1d23";
        $row = 0;
        $file_values = array();

        if (($handle = fopen("../assets/tracked_stats.csv", "r")) !== FALSE) {
            $path = "";
            $player_url = file_get_contents("https://api.hypixel.net/player?key=5371a9dc-9a7e-4784-b9e4-7fc37ec6ac4f&uuid=" . $uuid);
            $dec = json_decode($player_url, true);

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $row++;

                if ($data[0] == "Game") {
                    $file_values["game_stats_" . $data[1] . "_" . $data[2]][] = [$dec["player"]["stats"][$data[1]][$data[2]]];
                }

                if ($data[0] == "Player") {
                    if ($data[1] == "Voting") {
                        $db_values .= $dec["player"]["voting"][$data[2]];
                    }
                    if ($data[1] == "General") {
                        $db_values .= $dec["player"][$data[2]];
                    }
                }
                  
            }

            if($output_file = fopen("../assets/players/" . $uuid + ".csv", "w")) {
                foreach ($file_values as $line) {
                    fputcsv($output_file, $line, ",");
                    print(var_dump($line));
                }
            } else {
                echo "cannot make file";
            }

            fclose($handle);
        }
    }

?>