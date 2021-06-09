<?php
/**
 * Contains general functions which interact with the database and backend systems.
 * Used in admin panel only.
 * PHP version 7.2.34
 *
 * @category Functions
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */

    /**
     * Gets page views from the database based on a specified page.
     *
     * @param $connection Connection to the database.
     * @param $page       Page to get.
     * 
     * @return $views     Total page views from specified page.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function getPageViews($connection, $page) 
    {
        $query = "SELECT * FROM page_views WHERE page = '$page'";

        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row['views'];
            }
        }
    }

    /**
     * Gets the most recent player lookups as a list of specified size.
     *
     * @param $connection Connection to the database.
     * @param $size       Size of the list to return.
     * 
     * @return $result    List of recent lookups.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function getRecentLookups($connection, $size) 
    {
        $query = "SELECT * FROM stats_log ORDER BY updated_time DESC LIMIT " . $size;
        $result = $connection->query($query);
        return $result;
    }

    /**
     * Gets the most popular lookups as a list of specified size.
     *
     * @param $connection Connection to the database.
     * @param $size       Size of the list to return.
     * 
     * @return $result    List of popular lookups.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function getPopularLookups($connection, $size) 
    {
        $query = "SELECT action, COUNT(action) as lookups FROM stats_log GROUP BY action ORDER BY lookups DESC LIMIT " . $size;
        $result = $connection->query($query);
        return $result;
    }

    /**
     * Gets total unique players who are saved in the database.
     *
     * @param $mongo_mng MongoDB driver manager.
     * 
     * @return $count    Amount of cached players.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function getTotalCachedPlayers($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        $players = array();
        foreach ($res as $i) {
            array_push($players, $i->name);
        }
        return count($players);
    }

    /**
     * Gets total unique guilds which are saved in the database.
     *
     * @param $mongo_mng MongoDB driver manager.
     * 
     * @return $count    Amount of cached guilds.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function getTotalCachedGuilds($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([]);
        $res = $mongo_mng->executeQuery("ayeballers.guild", $query);
        $guilds = array();
        foreach ($res as $i) {
            array_push($guilds, $i->name);
        }
        return count($guilds);
    }

    /**
     * Gets total player lookups.
     *
     * @param $connection Connection to the database.
     * 
     * @return $views     Amount of player lookups.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function getTotalPlayerLookups($connection) 
    {
        $query = "SELECT COUNT(*) AS 'views' FROM stats_log";
        $result = $connection->query($query);
        $row = $result->fetch_assoc();
        return number_format($row['views']);
    }

    /**
     * Gets total page views of all pages.
     *
     * @param $connection Connection to the database.
     * 
     * @return $views     Amount of page views.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function getTotalPageViews($connection) 
    {
        $query = "SELECT SUM(views) AS 'views' FROM page_views";
        $result = $connection->query($query);
        $row = $result->fetch_assoc();
        $views = number_format($row['views']);
        return $views;
    }

    /**
     * Gets a list of Hypixel players by specified rank.
     *
     * @param $mongo_mng MongoDB driver manager.
     * @param $rank      Rank to get.
     * 
     * @return $players  List of returned players.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function getPlayersByRank($mongo_mng, $rank) 
    {
        $filter = ['rank' => $rank]; 
        $query = new MongoDB\Driver\Query($filter);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        $players = array();
        foreach ($res as $i) {
            array_push($players, $i->name);
        }
        return $players;
    }

?>