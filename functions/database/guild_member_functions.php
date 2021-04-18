<?php

    function getGuildMembersInOrder($connection) {
        $query = "SELECT * FROM GuildMembers ORDER BY CASE 
                                WHEN guild_rank = 'Guild Master' THEN 1
                                WHEN guild_rank = 'Co-Master' THEN 2 
                                WHEN guild_rank = 'Officer' THEN 3
                                WHEN guild_rank = 'Paintball God' THEN 4
                                WHEN guild_rank = 'Elite' THEN 5
                                WHEN guild_rank = 'Member' THEN 6
                                WHEN guild_rank = 'Veteran' THEN 7 END ASC";
        $result = $connection->query($query);
        return $result;
    }

    function getPaintballKills($mongo_mng, $uuid) {
        $filter = ['uuid' => $uuid]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        $player = current($res->toArray());
        $kills = $player->paintball->kills;
        return $kills;
    }

?>