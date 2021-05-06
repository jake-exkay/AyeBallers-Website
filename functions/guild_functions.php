<?php
/**
 * Guild Functions - Functions for getting guild data. Used on search guild page.
 * PHP version 7.2.34
 *
 * @category Functions
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */
    /**
     * Gets a players paintball kills from their document entry.
     *
     * @param $mongo_mng  MongoDB driver manager.
     * @param $uuid       UUID of the player.
     *
     * @return kills - Amount of paintball kills.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getPaintballKills($mongo_mng, $uuid) 
    {
        $filter = ['uuid' => $uuid]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        $player = current($res->toArray());
        $kills = $player->paintball->kills;
        return $kills;
    }

    /**
     * Gets a players paintball wins from their document entry.
     *
     * @param $mongo_mng  MongoDB driver manager.
     * @param $uuid       UUID of the player.
     *
     * @return wins - Amount of paintball wins.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getPaintballWins($mongo_mng, $uuid) 
    {
        $filter = ['uuid' => $uuid]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        $player = current($res->toArray());
        $wins = $player->paintball->wins;
        return $wins;
    }

    /**
     * Gets a guilds total paintball kills from their document entries.
     *
     * @param $mongo_mng  MongoDB driver manager.
     * @param $guild      Guild name.
     *
     * @return kills - Amount of paintball kills.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getGuildPaintballKills($mongo_mng, $guild) 
    {
        $filter = ['name' => $guild]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.guild", $query);
        $guild = current($res->toArray());
        $members = $guild->members;

        $total_kills = 0;

        foreach ($members as $member) {
            $uuid = $member->uuid;
            $total_kills = $total_kills + getPaintballKills($mongo_mng, $uuid);
        }

        return $total_kills;
    }

    /**
     * Gets a guilds total paintball kills from their document entries.
     *
     * @param $mongo_mng  MongoDB driver manager.
     * @param $guild      Guild name.
     *
     * @return wins - Amount of paintball wins.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getGuildPaintballWins($mongo_mng, $guild) 
    {
        $filter = ['name' => $guild]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.guild", $query);
        $guild = current($res->toArray());
        $members = $guild->members;

        $total_wins = 0;

        foreach ($members as $member) {
            $uuid = $member->uuid;
            $total_wins = $total_wins + getPaintballWins($mongo_mng, $uuid);
        }

        return $total_wins;
    }

    /**
     * Gets a list of guild ranks in order of priority.
     *
     * @param $mongo_mng  MongoDB driver manager.
     * @param $guild      Guild name.
     *
     * @return ordered_ranks - List of ranks ordered by priority.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getGuildRanksInOrder($mongo_mng, $guild) 
    {
        $filter = ['name' => $guild]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.guild", $query);
        $guild = current($res->toArray());
        $ranks = $guild->ranks;

        $ordered_ranks = array();

        foreach ($ranks as $rank) {
            $priority = $rank->priority;
            $ordered_ranks[$priority] = $rank->name;
        }

        array_push($ordered_ranks, "Guild Master");
        $ordered_ranks = array_reverse($ordered_ranks);

        return $ordered_ranks;
    }

    /**
     * Converts guild experience to a guile level.
     *
     * @param $exp Guild experience to convert.
     *
     * @return Guild level translated from experience.
     * @author Picsou993
     */
    function getGuildLevel($exp) 
    {
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