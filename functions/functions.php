<?php
/**
 * Contains general functions.
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
     * Checks if a player is in a specific guild.
     *
     * @param $connection Connection to the database.
     * @param $name       Name of the user to check.
     *
     * @return Boolean - whether the user is in the guild or not.
     * @author ExKay <exkay61@hotmail.com>
     */
    function userInGuild($connection, $name) 
    {
        $query = "SELECT * FROM guild_members_current WHERE name = '$name'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }

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
    function getRealName($uuid) {
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
    function getUUID($connection, $name) {
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

    /**
     * Converts guild experience to a guile level.
     *
     * @param $exp Guild experience to convert.
     *
     * @return Guild level translated from experience.
     * @author Picsou993
     */
    function getGuildLevel($exp) {
        switch ($exp):
            case $exp<100000:
                return 0;
            case $exp<250000:
                return 1;
            case $exp<500000:
                return 2;
            case $exp<1000000:
                return 3;
            case $exp<1750000:
                return 4;
            case $exp<2750000:
                return 5;
            case $exp<4000000:
                return 6;
            case $exp<5500000:
                return 7;
            case $exp<7500000:
                return 8;
            case $exp>=7500000:
                if ($exp<15000000) {
                    return floor(($exp - 7500000) / 2500000) + 9;
                } else {
                    return floor(($exp - 15000000) / 3000000) + 12;
                }
            default:
                return 0;
        endswitch;
    }
    
?>