<?php
/**
 * Contains general functions which deal with backend issues.
 * PHP version 7.2.34
 *
 * @category Functions
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */

    /**
     * Gets user IP.
     *
     * @return IP - IP address of the user.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getUserIP() 
    {
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

    /**
     * Updates the stats log table in the database.
     *
     * @param $connection Connection to the database.
     * @param $name       Name of the player.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function updateStatsLog($connection, $name) 
    {
        $query = "INSERT INTO stats_log (updated_time, action) VALUES (now(), '$name')";         
        mysqli_query($connection, $query);
    }

    /**
     * Updates page views in the database.
     *
     * @param $connection Connection to the database.
     * @param $page       Page to update.
     * @param $dev_ip     IP address for developer updates.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function updatePageViews($connection, $page, $dev_ip) 
    {
    	if (getUserIP() == $dev_ip) {
    		$query = "UPDATE page_views SET dev_views = dev_views + 1 WHERE page = '$page'";         
            mysqli_query($connection, $query);

    	} else {
    		$query = "UPDATE page_views SET views = views + 1 WHERE page = '$page'";       
            mysqli_query($connection, $query);
    	}
    }

    /**
     * Gets a players real name using the UUID
     *
     * @param $uuid       UUID to translate to name.
     *
     * @return $name - Name of the player
     * @author ExKay <exkay61@hotmail.com>
     */
    function getRealName($uuid) 
    {
        $mojang_url = file_get_contents("https://api.mojang.com/user/profiles/" . $uuid . "/names");
        $mojang_decoded_url = json_decode($mojang_url, true);
        $real_name = array_pop($mojang_decoded_url);
        $name = $real_name['name'];
        return $name;
    }

    /**
     * Gets a players UUID using their name.
     *
     * @param $connection Connection to the database.
     * @param $name       Name of the user to check.
     *
     * @return $uuid - UUID of the user.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getUUID($connection, $name) 
    {
        $mojang_url = file_get_contents("https://api.mojang.com/users/profiles/minecraft/" . $name);
        $mojang_decoded_url = json_decode($mojang_url, true);
        $uuid = $mojang_decoded_url['id'];
        return $uuid;
    }

    /**
     * Checks if the Hypixel API limit has been reached.
     *
     * @param $key Hypixel API key.
     *
     * @return Boolean - whether the limit has been reached.
     * @author ExKay <exkay61@hotmail.com>
     */
    function apiLimitReached($key) 
    {
        $url = file_get_contents("https://api.hypixel.net/key?key=" . $key);
        $decoded_url = json_decode($url);
        $queries = $decoded_url->record->queriesInPastMin;
        if ($queries >= 110) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets a formatted leaderboard using a parameter to get the statistic required.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @param leaderboard - Path to statistic to sort by.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
	function getLeaderboard($mongo_mng, $leaderboard) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => [$leaderboard => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
	}
    
?>