<?php
/**
 * Player Functions - Involves getting, manipulating and displaying player statistic data.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */
    /**
     * Uses player UUID to get data from the Hypixel API and inserts/updates specific mongodb document.
     *
     * @param $mongo_mng  MongoDB driver manager.
     * @param $uuid       UUID of the player to update.
     * @param $name       Name of the player to update.
     * @param $API_KEY    API key to the Hypixel API.
     *
     * @return boolean - whether update was successful.
     * @author ExKay <exkay61@hotmail.com>
     */
	function updatePlayerInDatabase($mongo_mng, $uuid, $name, $API_KEY) 
    {
        // Get player JSON data from the Hypixel API.
		$player_url = file_get_contents("https://api.hypixel.net/player?key=" . $API_KEY . "&uuid=" . $uuid);
		$player_decoded_url = json_decode($player_url);

        // JSON paths for specific stats endpoints.
        $gen = !empty($player_decoded_url->player) ? $player_decoded_url->player : "No Stats";
        $pb = !empty($gen->stats->Paintball) ? $gen->stats->Paintball : "No Stats";
        $qc = !empty($gen->stats->Quake) ? $gen->stats->Quake : "No Stats";
        $ab = !empty($gen->stats->Arena) ? $gen->stats->Arena : "No Stats";
        $tkr = !empty($gen->stats->GingerBread) ? $gen->stats->GingerBread : "No Stats";
        $vz = !empty($gen->stats->VampireZ) ? $gen->stats->VampireZ : "No Stats";
        $walls = !empty($gen->stats->Walls) ? $gen->stats->Walls : "No Stats";
        $bw = !empty($gen->stats->Bedwars) ? $gen->stats->Bedwars : "No Stats";
        $tnt = !empty($gen->stats->TNTGames) ? $gen->stats->TNTGames : "No Stats";
        $arcade = !empty($gen->stats->Arcade) ? $gen->stats->Arcade : "No Stats";
        $wl = !empty($gen->stats->Battleground) ? $gen->stats->Battleground : "No Stats";
        $bsg = !empty($gen->stats->HungerGames) ? $gen->stats->HungerGames : "No Stats";
        $cac = !empty($gen->stats->MCGO) ? $gen->stats->MCGO : "No Stats";
        $uhc = !empty($gen->stats->UHC) ? $gen->stats->UHC : "No Stats";
        $mw = !empty($gen->stats->Walls3) ? $gen->stats->Walls3 : "No Stats";
        $sw = !empty($gen->stats->SkyWars) ? $gen->stats->SkyWars : "No Stats";
        $sh = !empty($gen->stats->SuperSmash) ? $gen->stats->SuperSmash : "No Stats";
        $mm = !empty($gen->stats->MurderMystery) ? $gen->stats->MurderMystery : "No Stats";
        $bb = !empty($gen->stats->BuildBattle) ? $gen->stats->BuildBattle : "No Stats";
        $duels = !empty($gen->stats->Duels) ? $gen->stats->Duels : "No Stats";
        $pit = !empty($gen->stats->Pit) ? $gen->stats->Pit : "No Stats";

        // Define rank data endpoints.
        $staff_rank = !empty($gen->rank) ? $gen->rank : "NONE";
        $monthly_package_rank = !empty($gen->monthlyPackageRank) ? $gen->monthlyPackageRank : "NONE";
        $package_rank = !empty($gen->packageRank) ? $gen->packageRank : "NONE";
        $new_package_rank = !empty($gen->newPackageRank) ? $gen->newPackageRank : "NONE";

        if ($staff_rank == "NORMAL" || $staff_rank == "NONE") {
            if ($monthly_package_rank == "NONE") {
                if ($new_package_rank == "NONE") {
                    $rank = $package_rank;
                } else {
                    $rank = $new_package_rank;
                }
            } else {
                $rank = $monthly_package_rank;
            }
        } else {
            $rank = $staff_rank;
        }

        $doc = [
            'uuid' => $uuid, 
            'name' => $name, 
            'rank' => $rank,
            'rankColour' => $gen->rankPlusColor,
            'karma' => $gen->karma,
            'firstLogin' => $gen->firstLogin,
            'lastLogin' => $gen->lastLogin,
            'networkExp' => $gen->networkExp,
            'achievementPoints' => $gen->achievementPoints,
            'recentGameType' => $gen->mostRecentGameType,
            'selectedGadget' => $gen->gadget,
            'thanksReceived' => $gen->thanksReceived,
            'giftsGiven' => $gen->giftingMeta->giftsGiven,
            'rewardsClaimed' => $gen->totalRewards,
            'totalVotes' => $gen->voting->total,
            'lastVote' => $gen->voting->last_vote,
            'paintball' => [
                'coins' => $pb->coins,
                'kills' => $pb->kills, 
                'wins' => $pb->wins,
                'deaths' => $pb->deaths,
                'forcefieldTime' => $pb->forcefieldTime,
                'shotsFired' => $pb->shots_fired,
                'killstreaks' => $pb->killstreaks,
                'hat' => $pb->hat,
                'godfather' => $pb->godfather,
                'endurance' => $pb->endurance,
                'superluck' => $pb->superluck,
                'fortune' => $pb->fortune,
                'adrenaline' => $pb->adrenaline,
                'transfusion' => $pb->transfusion
            ],
            'quakecraft' => [
                'coins' => $qc->coins,
                'highestKillstreak' => $qc->highest_killstreak,
                'soloKills' => $qc->kills,
                'soloWins' => $qc->wins,
                'soloDeaths' => $qc->deaths,
                'soloKillstreaks' => $qc->killstreaks,
                'soloHeadshots' => $qc->headshots,
                'soloShotsFired' => $qc->shots_fired,
                'soloDistanceTravelled' => $qc->distance_travelled,
                'teamKills' => $qc->kills_teams,
                'teamWins' => $qc->wins_teams,
                'teamDeaths' => $qc->deaths_teams,
                'teamKillstreaks' => $qc->killstreaks_teams,
                'teamHeadshots' => $qc->headshots_teams,
                'teamShotsFired' => $qc->shots_fired_teams,
                'teamDistanceTravelled' => $qc->distance_travelled_teams
            ],
            'arena' => [
                'coins' => $ab->coins,
                'coinsSpent' => $ab->coins_spent,
                'keys' => $ab->keys,
                'rating' => $ab->rating,
                'twos' => [
                    'damage' => $ab->damage_2v2,
                    'deaths' => $ab->deaths_2v2,
                    'kills' => $ab->kills_2v2,
                    'wins' => $ab->wins_2v2,
                    'games' => $ab->games_2v2,
                    'losses' => $ab->losses_2v2,
                    'healed' => $ab->healed_2v2
                ],
                'fours' => [
                    'damage' => $ab->damage_4v4,
                    'deaths' => $ab->deaths_4v4,
                    'kills' => $ab->kills_4v4,
                    'wins' => $ab->wins_4v4,
                    'games' => $ab->games_4v4,
                    'losses' => $ab->losses_4v4,
                    'healed' => $ab->healed_4v4
                ],
                'ones' => [
                    'damage' => $ab->damage_1v1,
                    'deaths' => $ab->deaths_1v1,
                    'kills' => $ab->kills_1v1,
                    'wins' => $ab->wins_1v1,
                    'games' => $ab->games_1v1,
                    'losses' => $ab->losses_1v1,
                    'healed' => $ab->healed_1v1
                ]
            ],
            'tkr' => [
                'coins' => $tkr->coins,
                'boxPickups' => $tkr->box_pickups,
                'coinPickups' => $tkr->coins_picked_up,
                'wins' => $tkr->wins,
                'goldTrophy' => $tkr->gold_trophy,
                'silverTrophy' => $tkr->silver_trophy,
                'bronzeTrophy' => $tkr->bronze_trophy,
                'lapsCompleted' => $tkr->laps_completed,
                'mapPlays' => [
                    'olympus' => $tkr->olympus_plays,
                    'junglerush' => $tkr->junglerush_plays,
                    'hypixelgp' => $tkr->hypixelgp_plays,
                    'retro' => $tkr->retro_plays,
                    'canyon' => $tkr->canyon_plays,
                ]
            ],
            'vampirez' => [
                'coins' => $vz->coins,
                'asHuman' => [
                    'humanDeaths' => $vz->human_deaths,
                    'vampireKills' => $vz->vampire_kills,
                    'zombieKills' => $vz->zombie_kills,
                    'mostVampireKills' => $vz->most_vampire_kills_new,
                    'humanWins' => $vz->human_wins,
                    'goldBought' => $vz->gold_bought
                ],
                'asVampire' => [
                    'vampireDeaths' => $vz->vampire_deaths,
                    'humanKills' => $vz->human_kills,
                    'vampireWins' => $vz->vampire_wins
                ]
            ],
            'walls' => [
                'coins' => $walls->coins,
                'wins' => $walls->wins,
                'deaths' => $walls->deaths,
                'kills' => $walls->kills,
                'losses' => $walls->losses,
                'assists' => $walls->assists
            ],
            'bedwars' => [
                'coins' => $bw->coins,
                'experience' => $bw->Experience,
                'deaths' => $bw->deaths_bedwars,
                'finalDeaths' => $bw->final_deaths_bedwars,
                'gamesPlayed' => $bw->games_played_bedwars,
                'losses' => $bw->losses_bedwars,
                'kills' => $bw->kills_bedwars,
                'voidKills' => $bw->void_kills_bedwars,
                'voidDeaths' => $bw->void_deaths_bedwars,
                'bedsBroken' => $bw->beds_broken_bedwars,
                'winstreak' => $bw->winstreak,
                'finalKills' => $bw->final_kills_bedwars,
                'wins' => $bw->wins_bedwars,
                'resourcesCollected' => [
                    'total' => $bw->resources_collected_bedwars,
                    'diamond' => $bw->diamond_resources_collected_bedwars,
                    'emerald' => $bw->emerald_resources_collected_bedwars,
                    'gold' => $bw->gold_resources_collected_bedwars,
                    'iron' => $bw->iron_resources_collected_bedwars
                ]
            ],
            'tntgames' => [
                'coins' => $tnt->coins,
                'hat' => $tnt->new_selected_hat,
                'winstreak' => $tnt->winstreak,
                'wins' => $tnt->wins,
                'pvprun' => [
                    'wins' => $tnt->wins_pvprun,
                    'deaths' => $tnt->deaths_pvprun,
                    'kills' => $tnt->kills_pvprun,
                    'record' => $tnt->record_pvprun
                ],
                'tntrun' => [
                    'wins' => $tnt->wins_tntrun,
                    'record' => $tnt->record_tntrun,
                    'deaths' => $tnt->deaths_tntrun
                ],
                'bowspleef' => [
                    'deaths' => $tnt->deaths_bowspleef,
                    'wins' => $tnt->wins_bowspleef
                ],
                'wizards' => [
                    'deaths' => $tnt->deaths_capture,
                    'kills' => $tnt->kills_capture,
                    'wins' => $tnt->wins_capture,
                    'assists' => $tnt->assists_capture,
                    'points' => $tnt->points_capture
                ],
                'tntag' => [
                    'kills' => $tnt->kills_tntag,
                    'wins' => $tnt->wins_tntag
                ]
            ],
            'arcade' => [
                'coins' => $arcade->coins,
                'bountyHunters' => [
                    'deaths' => $arcade->deaths_oneinthequiver,
                    'kills' => $arcade->kills_oneinthequiver
                ],
                'throwOut' => [
                    'deaths' => $arcade->deaths_throw_out,
                    'kills' => $arcade->kills_throw_out
                ],
                'blockingDead' => [
                    'headshots' => $arcade->headshots_dayone,
                    'kills' => $arcade->kills_dayone,
                    'wins' => $arcade->wins_dayone
                ],
                'dragonWars' => [
                    'kills' => $arcade->kills_dragonwars2,
                    'wins' => $arcade->wins_dragonwars2
                ],
                'creeperAttack' => [
                    'maxWave' => $arcade->max_wave
                ],
                'farmHunt' => [
                    'poopCollected' => $arcade->poop_collected,
                    'wins' => $arcade->wins_farm_hunt
                ],
                'enderSpleef' => [
                    'wins' => $arcade->wins_ender
                ],
                'partyGamesOne' => [
                    'wins' => $arcade->wins_party
                ],
                'partyGamesTwo' => [
                    'wins' => $arcade->wins_party_2
                ],
                'galaxyWars' => [
                    'kills' => $arcade->sw_kills,
                    'shotsFired' => $arcade->sw_shots_fired,
                    'rebelKills' => $arcade->sw_rebel_kills,
                    'empireKills' => $arcade->sw_empire_kills,
                    'wins' => $arcade->sw_game_wins
                ],
                'holeInTheWall' => [
                    'rounds' => $arcade->rounds_hole_in_the_wall
                ],
                'hypixelSays' => [
                    'rounds' => $arcade->rounds_simon_says,
                    'wins' => $arcade->wins_simon_says
                ],
                'miniWalls' => [
                    'wins' => $arcade->wins_mini_walls,
                    'deaths' => $arcade->deaths_mini_walls,
                    'arrowsHit' => $arcade->arrows_hit_mini_walls,
                    'kills' => $arcade->kills_mini_walls,
                    'arrowsShot' => $arcade->arrows_shot_mini_walls,
                    'witherDamage' => $arcade->wither_damage_mini_walls,
                    'finalKills' => $arcade->final_kills_mini_walls,
                    'witherKills' => $arcade->wither_kills_mini_walls
                ],
                'football' => [
                    'powerKicks' => $arcade->powerkicks_soccer,
                    'goals' => $arcade->goals_soccer,
                    'kicks' => $arcade->kicks_soccer,
                    'wins' => $arcade->wins_soccer
                ],
                'zombies' => [
                    'bestRound' => $arcade->best_round_zombies,
                    'killsByType' => [
                        'total' => $arcade->zombie_kills_zombies,
                        'basic' => $arcade->basic_zombie_kills_zombies,
                        'blaze' => $arcade->blaze_zombie_kills_zombies,
                        'empowered' => $arcade->empowered_zombie_kills_zombies,
                        'fire' => $arcade->fire_zombie_kills_zombies,
                        'wolf' => $arcade->wolf_zombie_kills_zombies,
                        'magmaCube' => $arcade->magma_cube_zombie_kills_zombies,
                        'blob' => $arcade->blob_zombie_kills_zombies,
                        'pigZombie' => $arcade->pig_zombie_zombie_kills_zombies,
                        'tntBaby' => $arcade->tnt_baby_zombie_kills_zombies,
                        'tnt' => $arcade->tnt_zombie_kills_zombies,
                        'chgluglu' => $arcade->chgluglu_zombie_kills_zombies,
                        'clown' => $arcade->clown_zombie_kills_zombies,
                        'ghast' => $arcade->ghast_zombie_kills_zombies,
                        'giant' => $arcade->giant_zombie_kills_zombies,
                        'rainbow' => $arcade->rainbow_zombie_kills_zombies,
                        'sentinel' => $arcade->sentinel_zombie_kills_zombies,
                        'skeleton' => $arcade->skeleton_zombie_kills_zombies,
                        'spaceBlaster' => $arcade->space_blaster_zombie_kills_zombies,
                        'spaceGrunt' => $arcade->space_grunt_zombie_kills_zombies,
                        'wormSmall' => $arcade->worm_small_zombie_kills_zombies,
                        'worm' => $arcade->worm_zombie_kills_zombies,
                        'megaBlob' => $arcade->mega_blob_zombie_kills_zombies,
                        'enderZombie' => $arcade->ender_zombie_kills_zombies,
                        'endermite' => $arcade->endermite_zombie_kills_zombies,
                        'guardian' => $arcade->guardian_zombie_kills_zombies,
                        'silverfish' => $arcade->silverfish_zombie_kills_zombies,
                        'skelefish' => $arcade->skelefish_zombie_kills_zombies,
                        'caveSpider' => $arcade->cave_spider_zombie_kills_zombies,
                        'werewolf' => $arcade->werewolf_zombie_kills_zombies,
                        'witch' => $arcade->witch_zombie_kills_zombies,
                        'ironGolem' => $arcade->iron_golem_zombie_kills_zombies,
                        'megaMagma' => $arcade->mega_magma_zombie_kills_zombies
                    ],
                    'playersRevived' => $arcade->players_revived_zombies,
                    'headshots' => $arcade->headshost_zombies,
                    'bulletsHit' => $arcade->bullets_hit_zombies,
                    'bulletsShot' => $arcade->bullets_shot_zombies,
                    'deaths' => $arcade->deaths_zombies,
                    'doorsOpened' => $arcade->doors_opened_zombies,
                    'fastestTen' => $arcade->fastest_time_10_zombies,
                    'fastestTwenty' => $arcade->fastest_time_20_zombies,
                    'timesKnockedDown' => $arcade->times_knocked_down_zombies,
                    'totalRounds' => $arcade->total_rounds_survived_zombies,
                    'windowsRepaired' => $arcade->windows_repaired_zombies,
                    'deadend' => [
                        'bestRound' => $arcade->best_round_zombies_deadend,
                        'zombieKills' => $arcade->zombie_kills_zombies_deadend,
                        'deaths' => $arcade->deaths_zombies_deadend,
                        'doorsOpened' => $arcade->doors_opened_zombies_deadend,
                        'fastestTen' => $arcade->fastest_time_10_zombies_deadend_normal,
                        'playersRevived' => $arcade->players_revived_zombies_deadend,
                        'timesKnockedDown' => $arcade->times_knocked_down_zombies_deadend,
                        'totalRounds' => $arcade->total_rounds_survived_zombies_deadend,
                        'windowsRepaired' => $arcade->windows_repaired_zombies_deadend,
                        'fastestTwenty' => $arcade->fastest_time_20_zombies_deadend_normal
                    ],
                    'badblood' => [
                        'bestRound' => $arcade->best_round_zombies_badblood,
                        'deaths' => $arcade->deaths_zombies_badblood,
                        'doorsOpened' => $arcade->doors_opened_zombies_badblood,
                        'playersRevived' => $arcade->players_revived_zombies_badblood,
                        'timesKnockedDown' => $arcade->times_knocked_down_zombies_badblood,
                        'roundsSurvived' => $arcade->total_rounds_survived_zombies_badblood,
                        'windowsRepaired' => $arcade->windows_repaired_zombies_badblood,
                        'zombieKills' => $arcade->zombie_kills_zombies_badblood
                    ],
                    'alienArcadium' => [
                        'bestRound' => $arcade->best_round_zombies_alienarcadium,
                        'deaths' => $arcade->deaths_zombies_alienarcadium,
                        'fastestTen' => $arcade->fastest_time_10_zombies_alienarcadium_normal,
                        'playersRevived' => $arcade->players_revived_zombies_alienarcadium,
                        'timesKnockedDown' => $arcade->times_knocked_down_zombies_alienarcadium,
                        'roundsSurvived' => $arcade->total_rounds_survived_zombies_alienarcadium,
                        'windowsRepaired' => $arcade->windows_repaired_zombies_alienarcadium,
                        'zombieKills' => $arcade->zombie_kills_zombies_alienarcadium,
                        'fastestTwenty' => $arcade->fastest_time_20_zombies_alienarcadium_normal,
                        'doorsOpened' => $arcade->doors_opened_zombies_alienarcadium
                    ]
                ],
                'seasonal' => [
                    'santaSays' => [
                        'rounds' => $arcade->rounds_santa_says
                    ],
                    'santaSimulator' => [
                        'wins' => $arcade->wins_santa_simulator,
                        'delivered' => $arcade->delivered_santa_simulator,
                        'spotted' => $arcade->spotted_santa_simulator
                    ],
                    'easterSimulator' => [
                        'eggsFound' => $arcade->eggs_found_easter_simulator,
                        'wins' => $arcade->wins_easter_simulator
                    ],
                    'scubaSimulator' => [
                        'totalPoints' => $arcade->total_points_scuba_simulator,
                        'itemsFound' => $arcade->items_found_scuba_simulator
                    ]
                ],
                'hideAndSeek' => [
                    'seekerWins' => $arcade->seeker_wins_hide_and_seek,
                    'hiderWins' => $arcade->hider_wins_hide_and_seek,
                    'partyPooper' => [
                        'seekerWins' => $arcade->party_pooper_seeker_wins_hide_and_seek,
                        'hiderWins' => $arcade->party_pooper_hider_wins_hide_and_seek
                    ],
                    'propHunt' => [
                        'hiderWins' => $arcade->prop_hunt_hider_wins_hide_and_seek
                    ]
                ]
            ],
            'murderMystery' => [
                'coins' => $mm->coins,
                'coinPickups' => $mm->coins_pickedup,
                'games' => $mm->games,
                'wins' => $mm->wins,
                'deaths' => $mm->deaths,
                'kills' => $mm->kills,
                'bowKills' => $mm->bow_kills,
                'knifeKills' => $mm->knife_kills,
                'asMurderer' => [
                    'kills' => $mm->kills_as_murderer
                ],
                'asDetective' => [
                    'wins' => $mm->detective_wins
                ]
            ],
            'buildBattle' => [
                'wins' => $bb->wins,
                'coins' => $bb->coins,
                'games' => $bb->games_played,
                'score' => $bb->score,
                'mostPointsSolo' => $bb->solo_most_points,
                'mostPointsTeams' => $bb->teams_most_points,
                'totalVotes' => $bb->total_votes,
                'correctGuesses' => $bb->correct_guesses
            ]
        ];

        $filter = ['uuid' => $uuid]; 
        $query = new MongoDB\Driver\Query($filter);     
        
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        
        $player = current($res->toArray());
        
        if (!empty($player)) {
            try {
                $bulk = new MongoDB\Driver\BulkWrite();
                $bulk->update(['uuid' => $uuid], ['$set' => $doc]);
                $result = $mongo_mng->executeBulkWrite('ayeballers.player', $bulk); 
            } catch (MongoDB\Driver\Exception\Exception $e) {
                error_log($e->getMessage());
            }
        } else {
            try {
                $bulk = new MongoDB\Driver\BulkWrite();
                $bulk->insert($doc);
                $result = $mongo_mng->executeBulkWrite('ayeballers.player', $bulk); 
            } catch (MongoDB\Driver\Exception\Exception $e) {
                error_log($e->getMessage());
            }
        }

	}

    /**
     * Gets player data specific to a UUID.
     *
     * @param $connection Connection to the database.
     * @param $uuid       UUID of the player to check.
     *
     * @return result - the row of data associated with the player.
     * @author ExKay <exkay61@hotmail.com>
     */
	function getPlayerInformation($connection, $uuid) 
    {
        $query = "SELECT * FROM player WHERE UUID = '" . $uuid . "'";
        $result = $connection->query($query);
        return $result;
	}

    /**
     * Gets the guild of the player using a UUID.
     *
     * @param $connection Connection to the database.
     * @param $uuid       UUID of the player to check.
     * @param $API_KEY    API key to the Hypixel API.
     *
     * @return decoded_url URL of the JSON data with guild information.
     * @author ExKay <exkay61@hotmail.com>
     */
	function getPlayersGuild($connection, $uuid, $API_KEY) 
    {
		$api_guild_url = file_get_contents("https://api.hypixel.net/guild?key=" . $API_KEY . "&player=" . $uuid);
		$decoded_url  = json_decode($api_guild_url);
		return $decoded_url;
	}

    /**
     * Gets correct formatting of a players rank with their name.
     *
     * @param $name        Name of the player.
     * @param $rank        Rank of the player.
     * @param $rank_colour Colour of the rank (if MVP+ colour used).
     *
     * @return rank_with_name Formatting of the rank with the players name included.
     * @author ExKay <exkay61@hotmail.com>
     */
	function getRankFormatting($name, $rank, $rank_colour) 
    {
		if ($rank_colour == "BLACK") {
			$plus_colour = '<span style="color:#000000;">+</span>';
		} else if ($rank_colour == "RED") {
			$plus_colour = '<span style="color:#e72323;">+</span>';
		} else if ($rank_colour == "DARK_GREEN") {
			$plus_colour = '<span style="color:#13850f;">+</span>';
		} else if ($rank_colour == "None") {
			$plus_colour = '<span style="color:#ed5a64;">+</span>';
		} else if ($rank_colour == "WHITE") {
			$plus_colour = '<span style="color:#ffffff;">+</span>';
		} else if ($rank_colour == "BLUE") {
			$plus_colour = '<span style="color:#5a97ed;">+</span>';
		} else if ($rank_colour == "GREEN") {
			$plus_colour = '<span style="color:#19e657;">+</span>';
		} else if ($rank_colour == "DARK_RED") {
			$plus_colour = '<span style="color:#8a0f19;">+</span>';
		} else if ($rank_colour == "DARK_PURPLE") {
			$plus_colour = '<span style="color:#510f8a;">+</span>';
        } else if ($rank_colour == "YELLOW") {
            $plus_colour = '<span style="color:#fee125;">+</span>';
        } else if ($rank_colour == "GOLD") {
            $plus_colour = '<span style="color:#d1aa0a;">+</span>';
        } else if ($rank_colour == "DARK_AQUA") {
            $plus_colour = '<span style="color:#0a85d1;">+</span>';
        } else if ($rank_colour == "DARK_GRAY") {
            $plus_colour = '<span style="color:#4c5052;">+</span>';
        } else if ($rank_colour == "LIGHT_PURPLE") {
            $plus_colour = '<span style="color:#a75de5;">+</span>';
		} else {
            $plus_colour = '<span style="color:#e72323;">+</span>';
        }

		if ($rank == "MVP_PLUS") {
			$rank_with_name = '<span style="color:#50e0e7;">' . '[MVP' . $plus_colour . '] ' . $name . '</span>';
		} else if ($rank == "DEFAULT" || $rank == "NONE") {
			$rank_with_name = '<span style="color:#a7aaa1;">' . $name . '</span>';
		} else if ($rank == "SUPERSTAR") {
			$rank_with_name = '<span style="color:#e6b400;">' . '[MVP' . $plus_colour . $plus_colour . '] ' . $name . '</span>';
		} else if ($rank == "MVP") {
			$rank_with_name = '<span style="color:#50e0e7;">' . '[MVP] ' . $name . '</span>';
		} else if ($rank == "VIP_PLUS") {
			$rank_with_name = '<span style="color:#7cc841;">' . '[VIP<span style="color:#e6b400;">+</span><span style="color:#7cc841;">]</span> ' . $name . '</span>';
        } else if ($rank == "VIP") {
            $rank_with_name = '<span style="color:#7cc841;">' . '[VIP] ' . $name . '</span>';
		} else if ($rank == "ADMIN") {
			$rank_with_name = '<span style="color:#ce1c1c;">' . '[ADMIN] ' . $name . '</span>';
		} else if ($rank == "YOUTUBER") {
			$rank_with_name = '<span style="color:#ce1c1c;">' . '[<span style="color:#ffffff;">YOUTUBE<span style="color:#ce1c1c;">] ' . $name . '</span>';
		} else if ($rank == "MODERATOR") {
			$rank_with_name = '<span style="color:#238212;">' . '[MOD] ' . $name . '</span>';
		} else if ($rank == "HELPER") {
			$rank_with_name = '<span style="color:#146594;">' . '[HELPER] ' . $name . '</span>';
		} else {
			$rank_with_name = '<span style="color:#a7aaa1;">' . $name . '</span>';
		}

		return $rank_with_name;
	}

    /**
     * Gets the leaderboard position of a player in a specific game.
     *
     * @param $connection Connection to the database.
     * @param $name       Name of the player to check.
     * @param $game       Game to check leaderboard data.
     *
     * @return result The position in the leaderboard of the player.
     * @author ExKay <exkay61@hotmail.com>
     */
	function getLeaderboardPosition($connection, $name, $game) 
    {
        if ($game == "Paintball") {
    		$query = "SELECT name FROM player ORDER BY kills_paintball DESC";
    		$result = $connection->query($query);
        } else if ($game == "Quakecraft") {
            $query = "SELECT name FROM player ORDER BY kills_quake DESC";
            $result = $connection->query($query);
        } else if ($game == "Arena") {
            $query = "SELECT name FROM player ORDER BY rating_arena DESC";
            $result = $connection->query($query);
        } else if ($game == "TKR") {
            $query = "SELECT name FROM player ORDER BY wins_tkr DESC";
            $result = $connection->query($query);
        } else if ($game == "VampireZ") {
            $query = "SELECT name FROM player ORDER BY human_wins_vz DESC";
            $result = $connection->query($query);
        } else if ($game == "Walls") {
            $query = "SELECT name FROM player ORDER BY wins_walls DESC";
            $result = $connection->query($query);
        } else if ($game == "TNT") {
            $query = "SELECT name FROM player ORDER BY wins_tnt DESC";
            $result = $connection->query($query);
        } else if ($game == "Bedwars") {
            $query = "SELECT name FROM player ORDER BY wins_bw DESC";
            $result = $connection->query($query);
        } else {
            $result = "";
        }

        $rows = "";
        $data = array();

        if (!empty($result)) {
            $rows = mysqli_num_rows($result);
        } else {
            $rows = "";
        }

        if (!empty($rows)) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $data[] = $rows;
            }
        }

        $rank = 1;

        foreach ($data as $item) {
            if ($item['name'] == $name) {
                return $rank;
            }
            ++$rank;
        }

		return 501;
	}

    /**
     * Uses the experience value to calculate the network level.
     *
     * @param $exp The experience to convert.
     *
     * @return Network level value.
     * @author Plancke hypixel-php <https://github.com/Plancke/hypixel-php>
     */
    function getLevel(float $exp) 
    {
        $BASE = 10000;
        $GROWTH = 2500;
        $HALF_GROWTH = 0.5 * $GROWTH;
        $REVERSE_PQ_PREFIX = -($BASE - 0.5 * $GROWTH) / $GROWTH;
        $REVERSE_CONST = $REVERSE_PQ_PREFIX * $REVERSE_PQ_PREFIX;
        $GROWTH_DIVIDES_2 = 2 / $GROWTH;

        return $exp < 0 ? 1 : floor(1 + $REVERSE_PQ_PREFIX + sqrt($REVERSE_CONST + $GROWTH_DIVIDES_2 * $exp));
    }

    function updateStatsLog($connection, $name, $ip) {
        $query = "INSERT INTO stats_log (updated_time, action, IP) VALUES (now(), '$name', '$ip')";         
        mysqli_query($connection, $query);
    }

    function getGuildInformation($connection, $guild, $API_KEY) 
    {
        $api_guild_url = file_get_contents("https://api.hypixel.net/guild?key=" . $API_KEY . "&name=" . $guild);
        $decoded_url  = json_decode($api_guild_url);
        return $decoded_url;
    }

    function translatePaintballHat($hat) {
        $hat_paintball = "No hat selected";

        switch ($hat) {
            case "speed_hat":
                $hat_paintball = "Speed Hat";
                break;
            case "tnt_hat":
                $hat_paintball = "TNT Hat";
                break;
            case "vip_paintballkitty_hat":
                $hat_paintball = "PaintballKitty Hat";
                break;
            case "vip_rezzus_hat":
                $hat_paintball = "Rezzus Hat";
                break;
            case "vip_noxyd_hat":
                $hat_paintball = "NoxyD Hat";
                break;
            case "vip_ghost_hat":
                $hat_paintball = "Ghost Hat";
                break;
            case "hard_hat":
                $hat_paintball = "Hard Hat";
                break;
            case "shaky_hat":
                $hat_paintball = "Shaky Hat";
                break;
            case "spider_hat":
                $hat_paintball = "Spider Hat";
                break;
            case "trololol_hat":
                $hat_paintball = "Trololol Hat";
                break;
            case "vip_agentk_hat":
                $hat_paintball = "AgentK Hat";
                break;
            case "vip_codename_b_hat":
                $hat_paintball = "Codename_B Hat";
                break;
            case "vip_hypixel_hat":
                $hat_paintball = "Hypixel Hat";
                break;
            case "vip_kevinkool_hat":
                $hat_paintball = "Kevinkool Hat";
                break;
            case "NONE":
                $hat_paintball = "No Hat Selected";
                break;
            default:
                $hat_paintball = "No Hat Selected";
        }
        return $hat_paintball;
    }

?>