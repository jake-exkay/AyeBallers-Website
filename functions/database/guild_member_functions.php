<?php
    
    // Usage: Getting AyeBallers members from SQL database used in Enderpearl.
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

    // Usage: Get paintball kills for specific player. Used in enderpearl and guild stats page.
    function getPaintballKills($mongo_mng, $uuid) {
        $filter = ['uuid' => $uuid]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        $player = current($res->toArray());
        $kills = $player->paintball->kills;
        return $kills;
    }

    // Usage: Get paintball wins for specific player. Used in enderpearl and guild stats page.
    function getPaintballWins($mongo_mng, $uuid) {
        $filter = ['uuid' => $uuid]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        $player = current($res->toArray());
        $wins = $player->paintball->wins;
        return $wins;
    }

    function getGuildPaintballKills($mongo_mng, $guild) {
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

    function getGuildPaintballWins($mongo_mng, $guild) {
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

    function getGuildRanksInOrder($mongo_mng, $guild) {
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

?>