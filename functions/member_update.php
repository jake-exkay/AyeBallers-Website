<?php
/**
 * Member Update - Updates AyeBallers guild page.
 * PHP version 7.2.34
 *
 * @category Functions
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */
include "functions.php";
include "player_functions.php";
include "../includes/connect.php";
include "../includes/constants.php";

if (!apiLimitReached($API_KEY)) {
    $last_updated_query = "SELECT * FROM guild_members_current";
    $last_updated_result = $connection->query($last_updated_query);

    if ($last_updated_result->num_rows > 0) {
        while($last_updated_row = $last_updated_result->fetch_assoc()) {
            $last_updated = $last_updated_row['last_updated'];
        }
    }

    $start_date = new DateTime($last_updated);
    $since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s')));

    if ($since_start->i >= 1 || $since_start->y != 0 || $since_start->m != 0 || $since_start->d != 0 || $since_start->h != 0) {

        $api_guild_url = file_get_contents("https://api.hypixel.net/guild?key=" . $API_KEY . "&player=82df5a8fa7934e6087d186d8741a1d23");
        $decoded_url  = json_decode($api_guild_url);
        $guild_members = $decoded_url->guild->members;

        $truncate_query = "DELETE FROM guild_members_current";

        if($truncate_statement = mysqli_prepare($connection, $truncate_query)) {
            mysqli_stmt_execute($truncate_statement);
        } else {
            echo 'Error truncating member table<br>' . mysqli_error($connection); 
        }

        foreach($guild_members as $member) {
            if (!apiLimitReached($API_KEY)) {
                $uuid = $member->uuid;
                $guild_rank = $member->rank;

                // Get real name
                $mojang_url = file_get_contents("https://api.mojang.com/user/profiles/" . $uuid . "/names");
                $mojang_decoded_url = json_decode($mojang_url, true);
                $real_name = array_pop($mojang_decoded_url);
                $name = $real_name['name'];

                $query = "INSERT INTO guild_members_current (UUID, name, guild_rank, last_updated) VALUES (?, ?, ?, now())";

                if($statement = mysqli_prepare($connection, $query)) {
                    mysqli_stmt_bind_param($statement, "sss", $uuid, $name, $guild_rank);
                    mysqli_stmt_execute($statement);
                    updatePlayer($mongo_mng, $uuid, $name, $API_KEY);
                } else {
                    echo '<b>[GUILD] ' . $name . ' </b>An Error Occured!<br>'; 
                }

                header("Refresh:0.01; url=../../../ayeballers.php");
            } else {
                echo "Error: Too many concurrent API requests, please try again in a minute.";
                header("Refresh:2; url=../../../ayeballers.php");
            }

        }

    } else {
        echo "Database was updated less than 1 minute ago. Redirecting.";
        header("Refresh:2; url=../../../ayeballers.php");
    }
} else {
    echo "Error: Too many concurrent API requests, please try again in a minute.";
    header("Refresh:2; url=../../../ayeballers.php");
}

?>