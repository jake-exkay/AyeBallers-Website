<?php

    function getUserIP() {
    	$ip = "";
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
    }

    function userInGuild($connection, $name) {
        $query = "SELECT * FROM guild_members_current WHERE name='$name'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }

    }

    function updatePageViews($connection, $page, $dev_ip) {
    	if (getUserIP() == $dev_ip) {
			$query = "UPDATE page_views SET dev_views = dev_views + 1 WHERE page = '$page'";         
	        mysqli_query($connection, $query);

    	} else {
    		$query = "UPDATE page_views SET views = views + 1 WHERE page = '$page'";       
	        mysqli_query($connection, $query);
    	}
    }

    function timeSinceUpdate($last_updated) {
        $start_date = new DateTime($last_updated);
        $since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s')));

        $mins = $since_start->i;
        $hours = $since_start->h;
        $days = $since_start->d;

        return (($days * 60 * 60) + ($hours * 60) + $mins);
    }

    function getRealName($connection, $uuid) {
        $mojang_url = file_get_contents("https://api.mojang.com/user/profiles/" . $uuid . "/names");
        $mojang_decoded_url = json_decode($mojang_url, true);
        $real_name = array_pop($mojang_decoded_url);
        $name = $real_name['name'];
        return $name;
    }

    function getUUID($connection, $name) {
        $mojang_url = file_get_contents("https://api.mojang.com/users/profiles/minecraft/" . $name);
        $mojang_decoded_url = json_decode($mojang_url, true);
        $uuid = $mojang_decoded_url['id'];
        return $uuid;
    }

    function apiLimitReached($key) {
        $url = file_get_contents("https://api.hypixel.net/key?key=" . $key);
        $decoded_url = json_decode($url);
        $queries = $decoded_url->record->queriesInPastMin;
        if ($queries >= 110) {
            return true;
        } else {
            return false;
        }
    }

    function canBeUpdated($connection, $table) {
        $last_updated_query = "SELECT * FROM $table LIMIT 1";
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

    function getLastUpdated($connection, $table) {
        $last_updated = "";

        $last_updated_query = "SELECT * FROM $table LIMIT 1";
        $last_updated_result = $connection->query($last_updated_query);

        if ($last_updated_result->num_rows > 0) {
            while($last_updated_row = $last_updated_result->fetch_assoc()) {
                $last_updated = $last_updated_row['last_updated'];
            }
        }

        return $last_updated;
    }

    
?>