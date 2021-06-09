<?php
/**
 * Player Functions - Involves getting, manipulating and displaying player statistic data.
 * PHP version 7.2.34
 *
 * @category Functions
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
	function updatePlayer($mongo_mng, $uuid, $API_KEY) 
    {
        if (!$uuid) {
            return false;
        } else {
        // Get player JSON data from the Hypixel API.
		$player_url = file_get_contents("https://api.hypixel.net/player?key=" . $API_KEY . "&uuid=" . $uuid);
		$player_decoded_url = json_decode($player_url);

        if ($player_decoded_url->success == false) {
            return false;
        } else {

            $name = !empty($player_decoded_url->player->displayname) ? $player_decoded_url->player->displayname : "Unknown";

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
            $smash = !empty($gen->stats->SuperSmash) ? $gen->stats->SuperSmash : "No Stats";
            $mm = !empty($gen->stats->MurderMystery) ? $gen->stats->MurderMystery : "No Stats";
            $bb = !empty($gen->stats->BuildBattle) ? $gen->stats->BuildBattle : "No Stats";
            $duels = !empty($gen->stats->Duels) ? $gen->stats->Duels : "No Stats";
            $pit = !empty($gen->stats->Pit) ? $gen->stats->Pit : "No Stats";

            // Define rank data endpoints.
            $staff_rank = !empty($gen->rank) ? $gen->rank : "NONE";
            $monthly_package_rank = !empty($gen->monthlyPackageRank) ? $gen->monthlyPackageRank : "NONE";
            $package_rank = !empty($gen->packageRank) ? $gen->packageRank : "NONE";
            $new_package_rank = !empty($gen->newPackageRank) ? $gen->newPackageRank : "NONE";
            $prefix = !empty($gen->prefix) ? $gen->prefix : "NONE";

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
                'prefix' => $prefix,
                'rankColour' => !empty($gen->rankPlusColor) ? $gen->rankPlusColor : "None",
                'karma' => !empty($gen->karma) ? $gen->karma : 0,
                'firstLogin' => !empty($gen->firstLogin) ? $gen->firstLogin : 0,
                'lastLogin' => !empty($gen->lastLogin) ? $gen->lastLogin : 0,
                'networkExp' => !empty($gen->networkExp) ? $gen->networkExp : 0,
                'achievementPoints' => !empty($gen->achievementPoints) ? $gen->achievementPoints : 0,
                'recentGameType' => !empty($gen->mostRecentGameType) ? $gen->mostRecentGameType : "Unknown",
                'selectedGadget' => !empty($gen->gadget) ? $gen->gadget : "Not Selected",
                'thanksReceived' => !empty($gen->thanksReceived) ? $gen->thanksReceived : 0,
                'giftsGiven' => !empty($gen->giftingMeta->giftsGiven) ? $gen->giftingMeta->giftsGiven : 0,
                'rewardsClaimed' => !empty($gen->totalRewards) ? $gen->totalRewards : 0,
                'totalVotes' => !empty($gen->voting->total) ? $gen->voting->total : 0,
                'lastVote' => !empty($gen->voting->last_vote) ? $gen->voting->last_vote : 0,
                'paintball' => [
                    'coins' => !empty($pb->coins) ? $pb->coins : 0,
                    'kills' => !empty($pb->kills) ? $pb->kills : 0, 
                    'wins' => !empty($pb->wins) ? $pb->wins : 0,
                    'deaths' => !empty($pb->deaths) ? $pb->deaths : 0,
                    'forcefieldTime' => !empty($pb->forcefieldTime) ? $pb->forcefieldTime : 0,
                    'shotsFired' => !empty($pb->shots_fired) ? $pb->shots_fired : 0,
                    'killstreaks' => !empty($pb->killstreaks) ? $pb->killstreaks : 0,
                    'hat' => !empty($pb->hat) ? $pb->hat : "None",
                    'godfather' => !empty($pb->godfather) ? $pb->godfather : 0,
                    'endurance' => !empty($pb->endurance) ? $pb->endurance : 0,
                    'superluck' => !empty($pb->superluck) ? $pb->superluck : 0,
                    'fortune' => !empty($pb->fortune) ? $pb->fortune : 0,
                    'adrenaline' => !empty($pb->adrenaline) ? $pb->adrenaline : 0,
                    'transfusion' => !empty($pb->transfusion) ? $pb->transfusion : 0
                ],
                'quakecraft' => [
                    'coins' => !empty($qc->coins) ? $qc->coins : 0,
                    'highestKillstreak' => !empty($qc->highest_killstreak) ? $qc->highest_killstreak : 0,
                    'soloKills' => !empty($qc->kills) ? $qc->kills : 0,
                    'soloWins' => !empty($qc->wins) ? $qc->wins : 0,
                    'soloDeaths' => !empty($qc->deaths) ? $qc->deaths : 0,
                    'soloKillstreaks' => !empty($qc->killstreaks) ? $qc->killstreaks : 0,
                    'soloHeadshots' => !empty($qc->headshots) ? $qc->headshots : 0,
                    'soloShotsFired' => !empty($qc->shots_fired) ? $qc->shots_fired : 0,
                    'soloDistanceTravelled' => !empty($qc->distance_travelled) ? $qc->distance_travelled : 0,
                    'teamKills' => !empty($qc->kills_teams) ? $qc->kills_teams : 0,
                    'teamWins' => !empty($qc->wins_teams) ? $qc->wins_teams : 0,
                    'teamDeaths' => !empty($qc->deaths_teams) ? $qc->deaths_teams : 0,
                    'teamKillstreaks' => !empty($qc->killstreaks_teams) ? $qc->killstreaks_teams : 0,
                    'teamHeadshots' => !empty($qc->headshots_teams) ? $qc->headshots_teams : 0,
                    'teamShotsFired' => !empty($qc->shots_fired_teams) ? $qc->shots_fired_teams : 0,
                    'teamDistanceTravelled' => !empty($qc->distance_travelled_teams) ? $qc->distance_travelled_teams : 0
                ],
                'arena' => [
                    'coins' => !empty($ab->coins) ? $ab->coins : 0,
                    'coinsSpent' => !empty($ab->coins_spent) ? $ab->coins_spent : 0,
                    'keys' => !empty($ab->keys) ? $ab->keys : 0,
                    'rating' => !empty($ab->rating) ? $ab->rating : 0,
                    'twos' => [
                        'damage' => !empty($ab->damage_2v2) ? $ab->damage_2v2 : 0,
                        'deaths' => !empty($ab->deaths_2v2) ? $ab->deaths_2v2 : 0,
                        'kills' => !empty($ab->kills_2v2) ? $ab->kills_2v2 : 0,
                        'wins' => !empty($ab->wins_2v2) ? $ab->wins_2v2 : 0,
                        'games' => !empty($ab->games_2v2) ? $ab->games_2v2 : 0,
                        'losses' => !empty($ab->losses_2v2) ? $ab->losses_2v2 : 0,
                        'healed' => !empty($ab->healed_2v2) ? $ab->healed_2v2 : 0
                    ],
                    'fours' => [
                        'damage' => !empty($ab->damage_4v4) ? $ab->damage_4v4 : 0,
                        'deaths' => !empty($ab->deaths_4v4) ? $ab->deaths_4v4 : 0,
                        'kills' => !empty($ab->kills_4v4) ? $ab->kills_4v4 : 0,
                        'wins' => !empty($ab->wins_4v4) ? $ab->wins_4v4 : 0,
                        'games' => !empty($ab->games_4v4) ? $ab->games_4v4 : 0,
                        'losses' => !empty($ab->losses_4v4) ? $ab->losses_4v4 : 0,
                        'healed' => !empty($ab->healed_4v4) ? $ab->healed_4v4 : 0
                    ],
                    'ones' => [
                        'damage' => !empty($ab->damage_1v1) ? $ab->damage_1v1 : 0,
                        'deaths' => !empty($ab->deaths_1v1) ? $ab->deaths_1v1 : 0,
                        'kills' => !empty($ab->kills_1v1) ? $ab->kills_1v1 : 0,
                        'wins' => !empty($ab->wins_1v1) ? $ab->wins_1v1 : 0,
                        'games' => !empty($ab->games_1v1) ? $ab->games_1v1 : 0,
                        'losses' => !empty($ab->losses_1v1) ? $ab->losses_1v1 : 0,
                        'healed' => !empty($ab->healed_1v1) ? $ab->healed_1v1 : 0
                    ]
                ],
                'tkr' => [
                    'coins' => !empty($tkr->coins) ? $tkr->coins : 0,
                    'boxPickups' => !empty($tkr->box_pickups) ? $tkr->box_pickups : 0,
                    'coinPickups' => !empty($tkr->coins_picked_up) ? $tkr->coins_picked_up : 0,
                    'wins' => !empty($tkr->wins) ? $tkr->wins : 0,
                    'goldTrophy' => !empty($tkr->gold_trophy) ? $tkr->gold_trophy : 0,
                    'silverTrophy' => !empty($tkr->silver_trophy) ? $tkr->silver_trophy : 0,
                    'bronzeTrophy' => !empty($tkr->bronze_trophy) ? $tkr->bronze_trophy : 0, 
                    'lapsCompleted' => !empty($tkr->laps_completed) ? $tkr->laps_completed : 0,
                    'mapPlays' => [
                        'olympus' => !empty($tkr->olympus_plays) ? $tkr->olympus_plays : 0,
                        'junglerush' => !empty($tkr->junglerush_plays) ? $tkr->junglerush_plays : 0,
                        'hypixelgp' => !empty($tkr->hypixelgp_plays) ? $tkr->hypixelgp_plays : 0,
                        'retro' => !empty($tkr->retro_plays) ? $tkr->retro_plays : 0,
                        'canyon' => !empty($tkr->canyon_plays) ? $tkr->canyon_plays : 0
                    ]
                ],
                'vampirez' => [
                    'coins' => !empty($vz->coins) ? $vz->coins : 0,
                    'asHuman' => [
                        'humanDeaths' => !empty($vz->human_deaths) ? $vz->human_deaths : 0,
                        'vampireKills' => !empty($vz->vampire_kills) ? $vz->vampire_kills : 0,
                        'zombieKills' => !empty($vz->zombie_kills) ? $vz->zombie_kills : 0,
                        'mostVampireKills' => !empty($vz->most_vampire_kills_new) ? $vz->most_vampire_kills_new : 0,
                        'humanWins' => !empty($vz->human_wins) ? $vz->human_wins : 0,
                        'goldBought' => !empty($vz->gold_bought) ? $vz->gold_bought : 0
                    ],
                    'asVampire' => [
                        'vampireDeaths' => !empty($vz->vampire_deaths) ? $vz->vampire_deaths : 0,
                        'humanKills' => !empty($vz->human_kills) ? $vz->human_kills : 0,
                        'vampireWins' => !empty($vz->vampire_wins) ? $vz->vampire_wins : 0
                    ]
                ],
                'walls' => [
                    'coins' => !empty($walls->coins) ? $walls->coins : 0,
                    'wins' => !empty($walls->wins) ? $walls->wins : 0,
                    'deaths' => !empty($walls->deaths) ? $walls->deaths : 0,
                    'kills' => !empty($walls->kills) ? $walls->kills : 0,
                    'losses' => !empty($walls->losses) ? $walls->losses : 0,
                    'assists' => !empty($walls->assists) ? $walls->assists : 0
                ],
                'bedwars' => [
                    'coins' => !empty($bw->coins) ? $bw->coins : 0,
                    'experience' => !empty($bw->Experience) ? $bw->Experience : 0,
                    'deaths' => !empty($bw->deaths_bedwars) ? $bw->deaths_bedwars : 0,
                    'finalDeaths' => !empty($bw->final_deaths_bedwars) ? $bw->final_deaths_bedwars : 0,
                    'gamesPlayed' => !empty($bw->games_played_bedwars) ? $bw->games_played_bedwars : 0,
                    'losses' => !empty($bw->losses_bedwars) ? $bw->losses_bedwars : 0,
                    'kills' => !empty($bw->kills_bedwars) ? $bw->kills_bedwars : 0,
                    'voidKills' => !empty($bw->void_kills_bedwars) ? $bw->void_kills_bedwars : 0,
                    'voidDeaths' => !empty($bw->void_deaths_bedwars) ? $bw->void_deaths_bedwars : 0,
                    'bedsBroken' => !empty($bw->beds_broken_bedwars) ? $bw->beds_broken_bedwars : 0,
                    'winstreak' => !empty($bw->winstreak) ? $bw->winstreak : 0,
                    'finalKills' => !empty($bw->final_kills_bedwars) ? $bw->final_kills_bedwars : 0,
                    'wins' => !empty($bw->wins_bedwars) ? $bw->wins_bedwars : 0,
                    'resourcesCollected' => [
                        'total' => !empty($bw->resources_collected_bedwars) ? $bw->resources_collected_bedwars : 0,
                        'diamond' => !empty($bw->diamond_resources_collected_bedwars) ? $bw->diamond_resources_collected_bedwars : 0,
                        'emerald' => !empty($bw->emerald_resources_collected_bedwars) ? $bw->emerald_resources_collected_bedwars : 0,
                        'gold' => !empty($bw->gold_resources_collected_bedwars) ? $bw->gold_resources_collected_bedwars : 0,
                        'iron' => !empty($bw->iron_resources_collected_bedwars) ? $bw->iron_resources_collected_bedwars : 0
                    ]
                ],
                'tntgames' => [
                    'coins' => !empty($tnt->coins) ? $tnt->coins : 0,
                    'hat' => !empty($tnt->new_selected_hat) ? $tnt->new_selected_hat : 0,
                    'winstreak' => !empty($tnt->winstreak) ? $tnt->winstreak : 0,
                    'wins' => !empty($tnt->wins) ? $tnt->wins : 0,
                    'pvprun' => [
                        'wins' => !empty($tnt->wins_pvprun) ? $tnt->wins_pvprun : 0,
                        'deaths' => !empty($tnt->deaths_pvprun) ? $tnt->deaths_pvprun : 0,
                        'kills' => !empty($tnt->kills_pvprun) ? $tnt->kills_pvprun : 0,
                        'record' => !empty($tnt->record_pvprun) ? $tnt->record_pvprun : 0
                    ],
                    'tntrun' => [
                        'wins' => !empty($tnt->wins_tntrun) ? $tnt->wins_tntrun : 0,
                        'record' => !empty($tnt->record_tntrun) ? $tnt->record_tntrun : 0,
                        'deaths' => !empty($tnt->deaths_tntrun) ? $tnt->deaths_tntrun : 0
                    ],
                    'bowspleef' => [
                        'deaths' => !empty($tnt->deaths_bowspleef) ? $tnt->deaths_bowspleef : 0,
                        'wins' => !empty($tnt->wins_bowspleef) ? $tnt->wins_bowspleef : 0
                    ],
                    'wizards' => [
                        'deaths' => !empty($tnt->deaths_capture) ? $tnt->deaths_capture : 0,
                        'kills' => !empty($tnt->kills_capture) ? $tnt->kills_capture : 0,
                        'wins' => !empty($tnt->wins_capture) ? $tnt->wins_capture : 0,
                        'assists' => !empty($tnt->assists_capture) ? $tnt->assists_capture : 0,
                        'points' => !empty($tnt->points_capture) ? $tnt->points_capture : 0
                    ],
                    'tntag' => [
                        'kills' => !empty($tnt->kills_tntag) ? $tnt->kills_tntag : 0,
                        'wins' => !empty($tnt->wins_tntag) ? $tnt->wins_tntag : 0
                    ]
                ],
                'arcade' => [
                    'coins' => !empty($arcade->coins) ? $arcade->coins : 0,
                    'bountyHunters' => [
                        'deaths' => !empty($arcade->deaths_oneinthequiver) ? $arcade->deaths_oneinthequiver : 0,
                        'kills' => !empty($arcade->kills_oneinthequiver) ? $arcade->kills_oneinthequiver : 0,
                        'bountyKills' => !empty($arcade->bounty_kills_oneinthequiver) ? $arcade->bounty_kills_oneinthequiver : 0,
                        'wins' => !empty($arcade->wins_oneinthequiver) ? $arcade->wins_oneinthequiver : 0
                    ],
                    'throwOut' => [
                        'deaths' => !empty($arcade->deaths_throw_out) ? $arcade->deaths_throw_out : 0,
                        'kills' => !empty($arcade->kills_throw_out) ? $arcade->kills_throw_out : 0,
                        'wins' => !empty($arcade->wins_throw_out) ? $arcade->wins_throw_out : 0
                    ],
                    'blockingDead' => [
                        'headshots' => !empty($arcade->headshots_dayone) ? $arcade->headshots_dayone : 0,
                        'kills' => !empty($arcade->kills_dayone) ? $arcade->kills_dayone : 0,
                        'wins' => !empty($arcade->wins_dayone) ? $arcade->wins_dayone : 0
                    ],
                    'dragonWars' => [
                        'kills' => !empty($arcade->kills_dragonwars2) ? $arcade->kills_dragonwars2 : 0,
                        'wins' => !empty($arcade->wins_dragonwars2) ? $arcade->wins_dragonwars2 : 0
                    ],
                    'creeperAttack' => [
                        'maxWave' => !empty($arcade->max_wave) ? $arcade->max_wave : 0
                    ],
                    'farmHunt' => [
                        'poopCollected' => !empty($arcade->poop_collected) ? $arcade->poop_collected : 0,
                        'wins' => !empty($arcade->wins_farm_hunt) ? $arcade->wins_farm_hunt : 0
                    ],
                    'enderSpleef' => [
                        'wins' => !empty($arcade->wins_ender) ? $arcade->wins_ender : 0
                    ],
                    'partyGamesOne' => [
                        'wins' => !empty($arcade->wins_party) ? $arcade->wins_party : 0
                    ],
                    'partyGamesTwo' => [
                        'wins' => !empty($arcade->wins_party_2) ? $arcade->wins_party_2 : 0
                    ],
                    'partyGamesThree' => [
                        'wins' => !empty($arcade->wins_party_3) ? $arcade->wins_party_3 : 0
                    ],
                    'galaxyWars' => [
                        'kills' => !empty($arcade->sw_kills) ? $arcade->sw_kills : 0,
                        'shotsFired' => !empty($arcade->sw_shots_fired) ? $arcade->sw_shots_fired : 0,
                        'rebelKills' => !empty($arcade->sw_rebel_kills) ? $arcade->sw_rebel_kills : 0,
                        'empireKills' => !empty($arcade->sw_empire_kills) ? $arcade->sw_empire_kills : 0,
                        'wins' => !empty($arcade->sw_game_wins) ? $arcade->sw_game_wins : 0
                    ],
                    'holeInTheWall' => [
                        'rounds' => !empty($arcade->rounds_hole_in_the_wall) ? $arcade->rounds_hole_in_the_wall : 0,
                        'wins' => !empty($arcade->wins_hole_in_the_wall) ? $arcade->wins_hole_in_the_wall : 0
                    ],
                    'hypixelSays' => [
                        'rounds' => !empty($arcade->rounds_simon_says) ? $arcade->rounds_simon_says : 0,
                        'wins' => !empty($arcade->wins_simon_says) ? $arcade->wins_simon_says : 0
                    ],
                    'miniWalls' => [
                        'wins' => !empty($arcade->wins_mini_walls) ? $arcade->wins_mini_walls : 0,
                        'deaths' => !empty($arcade->deaths_mini_walls) ? $arcade->deaths_mini_walls : 0,
                        'arrowsHit' => !empty($arcade->arrows_hit_mini_walls) ? $arcade->arrows_hit_mini_walls : 0,
                        'kills' => !empty($arcade->kills_mini_walls) ? $arcade->kills_mini_walls : 0,
                        'arrowsShot' => !empty($arcade->arrows_shot_mini_walls) ? $arcade->arrows_shot_mini_walls : 0,
                        'witherDamage' => !empty($arcade->wither_damage_mini_walls) ? $arcade->wither_damage_mini_walls : 0,
                        'finalKills' => !empty($arcade->final_kills_mini_walls) ? $arcade->final_kills_mini_walls : 0,
                        'witherKills' => !empty($arcade->wither_kills_mini_walls) ? $arcade->wither_kills_mini_walls : 0
                    ],
                    'football' => [
                        'powerKicks' => !empty($arcade->powerkicks_soccer) ? $arcade->powerkicks_soccer : 0,
                        'goals' => !empty($arcade->goals_soccer) ? $arcade->goals_soccer : 0,
                        'kicks' => !empty($arcade->kicks_soccer) ? $arcade->kicks_soccer : 0,
                        'wins' => !empty($arcade->wins_soccer) ? $arcade->wins_soccer : 0
                    ],
                    'zombies' => [
                        'bestRound' => !empty($arcade->best_round_zombies) ? $arcade->best_round_zombies : 0,
                        'killsByType' => [
                            'total' => !empty($arcade->zombie_kills_zombies) ? $arcade->zombie_kills_zombies : 0,
                            'basic' => !empty($arcade->basic_zombie_kills_zombies) ? $arcade->basic_zombie_kills_zombies : 0,
                            'blaze' => !empty($arcade->blaze_zombie_kills_zombies) ? $arcade->blaze_zombie_kills_zombies : 0,
                            'empowered' => !empty($arcade->empowered_zombie_kills_zombies) ? $arcade->empowered_zombie_kills_zombies : 0,
                            'fire' => !empty($arcade->fire_zombie_kills_zombies) ? $arcade->fire_zombie_kills_zombies : 0,
                            'wolf' => !empty($arcade->wolf_zombie_kills_zombies) ? $arcade->wolf_zombie_kills_zombies : 0,
                            'magmaCube' => !empty($arcade->magma_cube_zombie_kills_zombies) ? $arcade->magma_cube_zombie_kills_zombies : 0,
                            'blob' => !empty($arcade->blob_zombie_kills_zombies) ? $arcade->blob_zombie_kills_zombies : 0,
                            'pigZombie' => !empty($arcade->pig_zombie_zombie_kills_zombies) ? $arcade->pig_zombie_zombie_kills_zombies : 0,
                            'tntBaby' => !empty($arcade->tnt_baby_zombie_kills_zombies) ? $arcade->tnt_baby_zombie_kills_zombies : 0,
                            'tnt' => !empty($arcade->tnt_zombie_kills_zombies) ? $arcade->tnt_zombie_kills_zombies : 0,
                            'chgluglu' => !empty($arcade->chgluglu_zombie_kills_zombies) ? $arcade->chgluglu_zombie_kills_zombies : 0,
                            'clown' => !empty($arcade->clown_zombie_kills_zombies) ? $arcade->clown_zombie_kills_zombies : 0,
                            'ghast' => !empty($arcade->ghast_zombie_kills_zombies) ? $arcade->ghast_zombie_kills_zombies : 0,
                            'giant' => !empty($arcade->giant_zombie_kills_zombies) ? $arcade->giant_zombie_kills_zombies : 0,
                            'rainbow' => !empty($arcade->rainbow_zombie_kills_zombies) ? $arcade->rainbow_zombie_kills_zombies : 0,
                            'sentinel' => !empty($arcade->sentinel_zombie_kills_zombies) ? $arcade->sentinel_zombie_kills_zombies : 0,
                            'skeleton' => !empty($arcade->skeleton_zombie_kills_zombies) ? $arcade->skeleton_zombie_kills_zombies : 0,
                            'spaceBlaster' => !empty($arcade->space_blaster_zombie_kills_zombies) ? $arcade->space_blaster_zombie_kills_zombies : 0,
                            'spaceGrunt' => !empty($arcade->space_grunt_zombie_kills_zombies) ? $arcade->space_grunt_zombie_kills_zombies : 0,
                            'wormSmall' => !empty($arcade->worm_small_zombie_kills_zombies) ? $arcade->worm_small_zombie_kills_zombies : 0,
                            'worm' => !empty($arcade->worm_zombie_kills_zombies) ? $arcade->worm_zombie_kills_zombies : 0,
                            'megaBlob' => !empty($arcade->mega_blob_zombie_kills_zombies) ? $arcade->mega_blob_zombie_kills_zombies : 0,
                            'enderZombie' => !empty($arcade->ender_zombie_kills_zombies) ? $arcade->ender_zombie_kills_zombies : 0,
                            'endermite' => !empty($arcade->endermite_zombie_kills_zombies) ? $arcade->endermite_zombie_kills_zombies : 0,
                            'guardian' => !empty($arcade->guardian_zombie_kills_zombies) ? $arcade->guardian_zombie_kills_zombies : 0,
                            'silverfish' => !empty($arcade->silverfish_zombie_kills_zombies) ? $arcade->silverfish_zombie_kills_zombies : 0,
                            'skelefish' => !empty($arcade->skelefish_zombie_kills_zombies) ? $arcade->skelefish_zombie_kills_zombies : 0,
                            'caveSpider' => !empty($arcade->cave_spider_zombie_kills_zombies) ? $arcade->cave_spider_zombie_kills_zombies : 0,
                            'werewolf' => !empty($arcade->werewolf_zombie_kills_zombies) ? $arcade->werewolf_zombie_kills_zombies : 0,
                            'witch' => !empty($arcade->witch_zombie_kills_zombies) ? $arcade->witch_zombie_kills_zombies : 0,
                            'ironGolem' => !empty($arcade->iron_golem_zombie_kills_zombies) ? $arcade->iron_golem_zombie_kills_zombies : 0,
                            'megaMagma' => !empty($arcade->mega_magma_zombie_kills_zombies) ? $arcade->mega_magma_zombie_kills_zombies : 0
                        ],
                        'playersRevived' => !empty($arcade->players_revived_zombies) ? $arcade->players_revived_zombies : 0,
                        'headshots' => !empty($arcade->headshots_zombies) ? $arcade->headshots_zombies : 0,
                        'bulletsHit' => !empty($arcade->bullets_hit_zombies) ? $arcade->bullets_hit_zombies : 0,
                        'bulletsShot' => !empty($arcade->bullets_shot_zombies) ? $arcade->bullets_shot_zombies : 0,
                        'deaths' => !empty($arcade->deaths_zombies) ? $arcade->deaths_zombies : 0,
                        'doorsOpened' => !empty($arcade->doors_opened_zombies) ? $arcade->doors_opened_zombies : 0,
                        'fastestTen' => !empty($arcade->fastest_time_10_zombies) ? $arcade->fastest_time_10_zombies : 0,
                        'fastestTwenty' => !empty($arcade->fastest_time_20_zombies) ? $arcade->fastest_time_20_zombies : 0,
                        'timesKnockedDown' => !empty($arcade->times_knocked_down_zombies) ? $arcade->times_knocked_down_zombies : 0,
                        'totalRounds' => !empty($arcade->total_rounds_survived_zombies) ? $arcade->total_rounds_survived_zombies : 0,
                        'windowsRepaired' => !empty($arcade->windows_repaired_zombies) ? $arcade->windows_repaired_zombies : 0,
                        'deadend' => [
                            'bestRound' => !empty($arcade->best_round_zombies_deadend) ? $arcade->best_round_zombies_deadend : 0,
                            'zombieKills' => !empty($arcade->zombie_kills_zombies_deadend) ? $arcade->zombie_kills_zombies_deadend : 0,
                            'deaths' => !empty($arcade->deaths_zombies_deadend) ? $arcade->deaths_zombies_deadend : 0,
                            'doorsOpened' => !empty($arcade->doors_opened_zombies_deadend) ? $arcade->doors_opened_zombies_deadend : 0,
                            'fastestTen' => !empty($arcade->fastest_time_10_zombies_deadend_normal) ? $arcade->fastest_time_10_zombies_deadend_normal : 0,
                            'playersRevived' => !empty($arcade->players_revived_zombies_deadend) ? $arcade->players_revived_zombies_deadend : 0,
                            'timesKnockedDown' => !empty($arcade->times_knocked_down_zombies_deadend) ? $arcade->times_knocked_down_zombies_deadend : 0,
                            'totalRounds' => !empty($arcade->total_rounds_survived_zombies_deadend) ? $arcade->total_rounds_survived_zombies_deadend : 0,
                            'windowsRepaired' => !empty($arcade->windows_repaired_zombies_deadend) ? $arcade->windows_repaired_zombies_deadend : 0,
                            'fastestTwenty' => !empty($arcade->fastest_time_20_zombies_deadend_normal) ? $arcade->fastest_time_20_zombies_deadend_normal : 0
                        ],
                        'badblood' => [
                            'bestRound' => !empty($arcade->best_round_zombies_badblood) ? $arcade->best_round_zombies_badblood : 0,
                            'deaths' => !empty($arcade->deaths_zombies_badblood) ? $arcade->deaths_zombies_badblood : 0,
                            'doorsOpened' => !empty($arcade->doors_opened_zombies_badblood) ? $arcade->doors_opened_zombies_badblood : 0,
                            'playersRevived' => !empty($arcade->players_revived_zombies_badblood) ? $arcade->players_revived_zombies_badblood : 0,
                            'timesKnockedDown' => !empty($arcade->times_knocked_down_zombies_badblood) ? $arcade->times_knocked_down_zombies_badblood : 0,
                            'roundsSurvived' => !empty($arcade->total_rounds_survived_zombies_badblood) ? $arcade->total_rounds_survived_zombies_badblood : 0,
                            'windowsRepaired' => !empty($arcade->windows_repaired_zombies_badblood) ? $arcade->windows_repaired_zombies_badblood : 0,
                            'zombieKills' => !empty($arcade->zombie_kills_zombies_badblood) ? $arcade->zombie_kills_zombies_badblood : 0
                        ],
                        'alienArcadium' => [
                            'bestRound' => !empty($arcade->best_round_zombies_alienarcadium) ? $arcade->best_round_zombies_alienarcadium : 0,
                            'deaths' => !empty($arcade->deaths_zombies_alienarcadium) ? $arcade->deaths_zombies_alienarcadium : 0,
                            'fastestTen' => !empty($arcade->fastest_time_10_zombies_alienarcadium_normal) ? $arcade->fastest_time_10_zombies_alienarcadium_normal : 0,
                            'playersRevived' => !empty($arcade->players_revived_zombies_alienarcadium) ? $arcade->players_revived_zombies_alienarcadium : 0,
                            'timesKnockedDown' => !empty($arcade->times_knocked_down_zombies_alienarcadium) ? $arcade->times_knocked_down_zombies_alienarcadium : 0,
                            'roundsSurvived' => !empty($arcade->total_rounds_survived_zombies_alienarcadium) ? $arcade->total_rounds_survived_zombies_alienarcadium : 0,
                            'windowsRepaired' => !empty($arcade->windows_repaired_zombies_alienarcadium) ? $arcade->windows_repaired_zombies_alienarcadium : 0,
                            'zombieKills' => !empty($arcade->zombie_kills_zombies_alienarcadium) ? $arcade->zombie_kills_zombies_alienarcadium : 0,
                            'fastestTwenty' => !empty($arcade->fastest_time_20_zombies_alienarcadium_normal) ? $arcade->fastest_time_20_zombies_alienarcadium_normal : 0,
                            'doorsOpened' => !empty($arcade->doors_opened_zombies_alienarcadium) ? $arcade->doors_opened_zombies_alienarcadium : 0
                        ]
                    ],
                    'seasonal' => [
                        'santaSays' => [
                            'rounds' => !empty($arcade->rounds_santa_says) ? $arcade->rounds_santa_says : 0
                        ],
                        'santaSimulator' => [
                            'wins' => !empty($arcade->wins_santa_simulator) ? $arcade->wins_santa_simulator : 0,
                            'delivered' => !empty($arcade->delivered_santa_simulator) ? $arcade->delivered_santa_simulator : 0,
                            'spotted' => !empty($arcade->spotted_santa_simulator) ? $arcade->spotted_santa_simulator : 0
                        ],
                        'easterSimulator' => [
                            'eggsFound' => !empty($arcade->eggs_found_easter_simulator) ? $arcade->eggs_found_easter_simulator : 0,
                            'wins' => !empty($arcade->wins_easter_simulator) ? $arcade->wins_easter_simulator : 0
                        ],
                        'scubaSimulator' => [
                            'totalPoints' => !empty($arcade->total_points_scuba_simulator) ? $arcade->total_points_scuba_simulator : 0,
                            'itemsFound' => !empty($arcade->items_found_scuba_simulator) ? $arcade->items_found_scuba_simulator : 0
                        ]
                    ],
                    'hideAndSeek' => [
                        'seekerWins' => !empty($arcade->seeker_wins_hide_and_seek) ? $arcade->seeker_wins_hide_and_seek : 0,
                        'hiderWins' => !empty($arcade->hider_wins_hide_and_seek) ? $arcade->hider_wins_hide_and_seek : 0,
                        'partyPooper' => [
                            'seekerWins' => !empty($arcade->party_pooper_seeker_wins_hide_and_seek) ? $arcade->party_pooper_seeker_wins_hide_and_seek : 0,
                            'hiderWins' => !empty($arcade->party_pooper_hider_wins_hide_and_seek) ? $arcade->party_pooper_hider_wins_hide_and_seek : 0
                        ],
                        'propHunt' => [
                            'hiderWins' => !empty($arcade->prop_hunt_hider_wins_hide_and_seek) ? $arcade->prop_hunt_hider_wins_hide_and_seek : 0
                        ]
                    ]
                ],
                'murderMystery' => [
                    'coins' => !empty($mm->coins) ? $mm->coins : 0,
                    'coinPickups' => !empty($mm->coins_pickedup) ? $mm->coins_pickedup : 0,
                    'games' => !empty($mm->games) ? $mm->games : 0,
                    'wins' => !empty($mm->wins) ? $mm->wins : 0,
                    'deaths' => !empty($mm->deaths) ? $mm->deaths : 0,
                    'kills' => !empty($mm->kills) ? $mm->kills : 0,
                    'bowKills' => !empty($mm->bow_kills) ? $mm->bow_kills : 0,
                    'knifeKills' => !empty($mm->knife_kills) ? $mm->knife_kills : 0,
                    'asMurderer' => [
                        'kills' => !empty($mm->kills_as_murderer) ? $mm->kills_as_murderer : 0
                    ],
                    'asDetective' => [
                        'wins' => !empty($mm->detective_wins) ? $mm->detective_wins : 0
                    ]
                ],
                'buildBattle' => [
                    'wins' => !empty($bb->wins) ? $bb->wins : 0,
                    'coins' => !empty($bb->coins) ? $bb->coins : 0,
                    'games' => !empty($bb->games_played) ? $bb->games_played : 0,
                    'score' => !empty($bb->score) ? $bb->score : 0,
                    'mostPointsSolo' => !empty($bb->solo_most_points) ? $bb->solo_most_points : 0,
                    'mostPointsTeams' => !empty($bb->teams_most_points) ? $bb->teams_most_points : 0,
                    'totalVotes' => !empty($bb->total_votes) ? $bb->total_votes : 0,
                    'correctGuesses' => !empty($bb->correct_guesses) ? $bb->correct_guesses : 0
                ],
                'skywars' => [
                    'overall' => [
                        'winstreak' => !empty($sw->win_streak) ? $sw->win_streak : 0,
                        'blocksBroken' => !empty($sw->blocks_broken) ? $sw->blocks_broken : 0,
                        'blocksPlaced' => !empty($sw->blocks_placed) ? $sw->blocks_placed : 0,
                        'soulsGathered' => !empty($sw->souls_gathered) ? $sw->souls_gathered : 0,
                        'coins' => !empty($sw->coins) ? $sw->coins : 0,
                        'games' => !empty($sw->games) ? $sw->games : 0,
                        'kills' => !empty($sw->kills) ? $sw->kills : 0,
                        'losses' => !empty($sw->losses) ? $sw->losses : 0,
                        'deaths' => !empty($sw->deaths) ? $sw->deaths : 0,
                        'soulsGathered' => !empty($sw->souls_gathered) ? $sw->souls_gathered : 0,
                        'arrowsHit' => !empty($sw->arrows_hit) ? $sw->arrows_hit : 0,
                        'arrowsShot' => !empty($sw->arrows_shot) ? $sw->arrows_shot : 0,
                        'pearlsThrown' => !empty($sw->enderpearls_thrown) ? $sw->enderpearls_thrown : 0,
                        'wins' => !empty($sw->wins) ? $sw->wins : 0,
                        'itemsEnchanted' => !empty($sw->items_enchanted) ? $sw->items_enchanted : 0,
                        'assists' => !empty($sw->assists) ? $sw->assists : 0,
                        'eggsThrown' => !empty($sw->egg_thrown) ? $sw->egg_thrown : 0,
                        'survivedPlayers' => !empty($sw->survived_players) ? $sw->survived_players : 0,
                        'fastestWin' => !empty($sw->fastest_win) ? $sw->fastest_win : 0
                    ],
                    'insane' => [
                        'solo' => [
                            'deaths' => !empty($sw->deaths_solo_insane) ? $sw->deaths_solo_insane : 0,
                            'losses' => !empty($sw->losses_solo_insane) ? $sw->losses_solo_insane : 0,
                            'wins' => !empty($sw->wins_solo_insane) ? $sw->wins_solo_insane : 0,
                            'kills' => !empty($sw->kills_solo_insane) ? $sw->kills_solo_insane : 0
                        ],
                        'team' => [
                            'deaths' => !empty($sw->deaths_team_insane) ? $sw->deaths_team_insane : 0,
                            'losses' => !empty($sw->losses_team_insane) ? $sw->losses_team_insane : 0,
                            'kills' => !empty($sw->kills_team_insane) ? $sw->kills_team_insane : 0,
                            'wins' => !empty($sw->wins_team_insane) ? $sw->wins_team_insane : 0
                        ]
                    ],
                    'normal' => [
                        'solo' => [
                            'deaths' => !empty($sw->deaths_solo_normal) ? $sw->deaths_solo_normal : 0,
                            'losses' => !empty($sw->losses_solo_normal) ? $sw->losses_solo_normal : 0,
                            'wins' => !empty($sw->wins_solo_normal) ? $sw->wins_solo_normal : 0,
                            'kills' => !empty($sw->kills_solo_normal) ? $sw->kills_solo_normal : 0

                        ],
                        'team' => [
                            'losses' => !empty($sw->losses_team_normal) ? $sw->losses_team_normal : 0,
                            'deaths' => !empty($sw->deaths_team_normal) ? $sw->deaths_team_normal : 0,
                            'kills' => !empty($sw->kills_team_normal) ? $sw->kills_team_normal : 0,
                            'wins' => !empty($sw->wins_team_normal) ? $sw->wins_team_normal : 0
                        ]
                    ],
                    'mega' => [
                        'losses' => !empty($sw->losses_mega) ? $sw->losses_mega : 0,
                        'survivedPlayers' => !empty($sw->survived_players_mega) ? $sw->survived_players_mega : 0,
                        'kills' => !empty($sw->kills_mega) ? $sw->kills_mega : 0,
                        'games' => !empty($sw->games_mega) ? $sw->games_mega : 0,
                        'deaths' => !empty($sw->deaths_mega) ? $sw->deaths_mega : 0,
                        'assists' => !empty($sw->assists_mega) ? $sw->assists_mega : 0,
                        'wins' => !empty($sw->wins_mega) ? $sw->wins_mega : 0
                    ]
                ],
                'warlords' => [
                    'assists' => !empty($wl->assists) ? $wl->assists : 0,
                    'currentClass' => !empty($wl->chosen_class) ? $wl->chosen_class : 0,
                    'coins' => !empty($wl->coins) ? $wl->coins : 0,
                    'damage' => !empty($wl->damage) ? $wl->damage : 0,
                    'damagePrevented' => !empty($wl->damage_prevented) ? $wl->damage_prevented : 0,
                    'damageTaken' => !empty($wl->damage_taken) ? $wl->damage_taken : 0,
                    'deaths' => !empty($wl->deaths) ? $wl->deaths : 0,
                    'heal' => !empty($wl->heal) ? $wl->heal : 0,
                    'kills' => !empty($wl->kills) ? $wl->kills : 0,
                    'lifeLeeched' => !empty($wl->life_leeched) ? $wl->life_leeched : 0,
                    'losses' => !empty($wl->losses) ? $wl->losses : 0,
                    'magicDust' => !empty($wl->magic_dust) ? $wl->magic_dust : 0,
                    'repairedWeapons' => !empty($wl->repaired) ? $wl->repaired : 0,
                    'repairedCommon' => !empty($wl->repaired_common) ? $wl->repaired_common : 0,
                    'repairedEpic' => !empty($wl->repaired_epic) ? $wl->repaired_epic : 0,
                    'repairedRare' => !empty($wl->repaired_rare) ? $wl->repaired_rare : 0,
                    'repairedLegendary' => !empty($wl->repaired_legendary) ? $wl->repaired_legendary : 0,
                    'voidShards' => !empty($wl->void_shards) ? $wl->void_shards : 0,
                    'wins' => !empty($wl->wins) ? $wl->wins : 0,
                    'winsBlue' => !empty($wl->wins_blu) ? $wl->wins_blu : 0,
                    'winsRed' => !empty($wl->wins_red) ? $wl->wins_red : 0,
                    'powerups' => !empty($wl->powerups_collected) ? $wl->powerups_collected : 0,
                    'damageDelayed' => !empty($wl->damage_delayed) ? $wl->damage_delayed : 0,
                    'warrior' => [
                        'damagePrevented' => !empty($wl->damage_prevented_warrior) ? $wl->damage_prevented_warrior : 0,
                        'damage' => !empty($wl->damage_warrior) ? $wl->damage_warrior : 0,
                        'heal' => !empty($wl->heal_warrior) ? $wl->heal_warrior : 0,
                        'lifeLeeched' => !empty($wl->life_leeched_warrior) ? $wl->life_leeched_warrior : 0,
                        'losses' => !empty($wl->losses_warrior) ? $wl->losses_warrior : 0,
                        'plays' => !empty($wl->warrior_plays) ? $wl->warrior_plays : 0,
                        'wins' => !empty($wl->wins_warrior) ? $wl->wins_warrior : 0,
                        'berserker' => [
                            'plays' => !empty($wl->berserker_plays) ? $wl->berserker_plays : 0,
                            'damage' => !empty($wl->damage_berserker) ? $wl->damage_berserker : 0,
                            'damagePrevented' => !empty($wl->damage_prevented_berserker) ? $wl->damage_prevented_berserker : 0,
                            'heal' => !empty($wl->heal_berserker) ? $wl->heal_berserker : 0,
                            'lifeLeeched' => !empty($wl->life_leeched_berserker) ? $wl->life_leeched_berserker : 0,
                            'losses' => !empty($wl->losses_berserker) ? $wl->losses_berserker : 0,
                            'wins' => !empty($wl->wins_berserker) ? $wl->wins_berserker : 0
                        ],
                        'revenant' => [
                            'damagePrevented' => !empty($wl->damage_prevented_revenant) ? $wl->damage_prevented_revenant : 0,
                            'damage' => !empty($wl->damage_revenant) ? $wl->damage_revenant : 0,
                            'heal' => !empty($wl->heal_revenant) ? $wl->heal_revenant : 0,
                            'plays' => !empty($wl->revenant_plays) ? $wl->revenant_plays : 0,
                            'wins' => !empty($wl->wins_revenant) ? $wl->wins_revenant : 0,
                            'losses' => !empty($wl->losses_revenant) ? $wl->losses_revenant : 0
                        ],
                        'defender' => [
                            'damagePrevented' => !empty($wl->damage_prevented_defender) ? $wl->damage_prevented_defender : 0,
                            'damage' => !empty($wl->damage_defender) ? $wl->damage_defender : 0,
                            'heal' => !empty($wl->heal_defender) ? $wl->heal_defender : 0,
                            'plays' => !empty($wl->defender_plays) ? $wl->defender_plays : 0,
                            'wins' => !empty($wl->wins_defender) ? $wl->wins_defender : 0,
                            'losses' => !empty($wl->losses_defender) ? $wl->losses_defender : 0
                        ]
                    ],
                    'mage' => [
                        'heal' => !empty($wl->heal_mage) ? $wl->heal_mage : 0,
                        'damagePrevented' => !empty($wl->damage_prevented_mage) ? $wl->damage_prevented_mage : 0,
                        'losses' => !empty($wl->losses_mage) ? $wl->losses_mage : 0,
                        'damage' => !empty($wl->damage_mage) ? $wl->damage_mage : 0,
                        'plays' => !empty($wl->mage_plays) ? $wl->mage_plays : 0,
                        'wins' => !empty($wl->wins_mage) ? $wl->wins_mage : 0,
                        'pyromancer' => [
                            'damage' => !empty($wl->damage_pyromancer) ? $wl->damage_pyromancer : 0,
                            'heal' => !empty($wl->heal_pyromancer) ? $wl->heal_pyromancer : 0,
                            'damagePrevented' => !empty($wl->damage_prevented_pyromancer) ? $wl->damage_prevented_pyromancer : 0,
                            'plays' => !empty($wl->pyromancer_plays) ? $wl->pyromancer_plays : 0,
                            'losses' => !empty($wl->losses_pyromancer) ? $wl->losses_pyromancer : 0,
                            'wins' => !empty($wl->wins_pyromancer) ? $wl->wins_pyromancer : 0
                        ],
                        'aquamancer' => [
                            'damagePrevented' => !empty($wl->damage_prevented_aquamancer) ? $wl->damage_prevented_aquamancer : 0,
                            'damage' => !empty($wl->damage_aquamancer) ? $wl->damage_aquamancer : 0,
                            'heal' => !empty($wl->heal_aquamancer) ? $wl->heal_aquamancer : 0,
                            'plays' => !empty($wl->aquamancer_plays) ? $wl->aquamancer_plays : 0,
                            'wins' => !empty($wl->wins_aquamancer) ? $wl->wins_aquamancer : 0,
                            'losses' => !empty($wl->losses_aquamancer) ? $wl->losses_aquamancer : 0
                        ],
                        'cryomancer' => [
                            'damagePrevented' => !empty($wl->damage_prevented_cryomancer) ? $wl->damage_prevented_cryomancer : 0,
                            'damage' => !empty($wl->damage_cryomancer) ? $wl->damage_cryomancer : 0,
                            'heal' => !empty($wl->heal_cryomancer) ? $wl->heal_cryomancer : 0,
                            'plays' => !empty($wl->cryomancer_plays) ? $wl->cryomancer_plays : 0,
                            'wins' => !empty($wl->wins_cryomancer) ? $wl->wins_cryomancer : 0,
                            'losses' => !empty($wl->losses_cryomancer) ? $wl->losses_cryomancer : 0
                        ]
                    ],
                    'shaman' => [
                        'heal' => !empty($wl->heal_shaman) ? $wl->heal_shaman : 0,
                        'damage' => !empty($wl->damage_shaman) ? $wl->damage_shaman : 0,
                        'wins' => !empty($wl->wins_shaman) ? $wl->wins_shaman : 0,
                        'plays' => !empty($wl->shaman_plays) ? $wl->shaman_plays : 0,
                        'damagePrevented' => !empty($wl->damage_prevented_shaman) ? $wl->damage_prevented_shaman : 0,
                        'losses' => !empty($wl->losses_shaman) ? $wl->losses_shaman : 0,
                        'damageDelayed' => !empty($wl->damage_delayed_shaman) ? $wl->damage_delayed_shaman : 0,
                        'thunderlord' => [
                            'heal' => !empty($wl->heal_thunderlord) ? $wl->heal_thunderlord : 0,
                            'plays' => !empty($wl->thunderlord_plays) ? $wl->thunderlord_plays : 0,
                            'wins' => !empty($wl->wins_thunderlord) ? $wl->wins_thunderlord : 0,
                            'damage' => !empty($wl->damage_thunderlord) ? $wl->damage_thunderlord : 0,
                            'damagePrevented' => !empty($wl->damage_prevented_thunderlord) ? $wl->damage_prevented_thunderlord : 0,
                            'losses' => !empty($wl->losses_thunderlord) ? $wl->losses_thunderlord : 0
                        ],
                        'earthwarden' => [
                            'damagePrevented' => !empty($wl->damage_prevented_earthwarden) ? $wl->damage_prevented_earthwarden : 0,
                            'damage' => !empty($wl->damage_earthwarden) ? $wl->damage_earthwarden : 0,
                            'heal' => !empty($wl->heal_earthwarden) ? $wl->heal_earthwarden : 0,
                            'plays' => !empty($wl->earthwarden_plays) ? $wl->earthwarden_plays : 0,
                            'wins' => !empty($wl->wins_earthwarden) ? $wl->wins_earthwarden : 0,
                            'losses' => !empty($wl->losses_earthwarden) ? $wl->losses_earthwarden : 0
                        ],
                        'spiritguard' => [
                            'damagePrevented' => !empty($wl->damage_prevented_spiritguard) ? $wl->damage_prevented_spiritguard : 0,
                            'damage' => !empty($wl->damage_spiritguard) ? $wl->damage_spiritguard : 0,
                            'heal' => !empty($wl->heal_spiritguard) ? $wl->heal_spiritguard : 0,
                            'plays' => !empty($wl->spiritguard_plays) ? $wl->spiritguard_plays : 0,
                            'wins' => !empty($wl->wins_spiritguard) ? $wl->wins_spiritguard : 0,
                            'losses' => !empty($wl->losses_spiritguard) ? $wl->losses_spiritguard : 0,
                            'damageDelayed' => !empty($wl->damage_delayed_spiritguard) ? $wl->damage_delayed_spiritguard : 0
                        ]
                    ],
                    'paladin' => [
                        'damage' => !empty($wl->damage_paladin) ? $wl->damage_paladin : 0,
                        'plays' => !empty($wl->paladin_plays) ? $wl->paladin_plays : 0,
                        'heal' => !empty($wl->heal_paladin) ? $wl->heal_paladin : 0,
                        'damagePrevented' => !empty($wl->damage_prevented_paladin) ? $wl->damage_prevented_paladin : 0,
                        'losses' => !empty($wl->losses_paladin) ? $wl->losses_paladin : 0,
                        'wins' => !empty($wl->wins_paladin) ? $wl->wins_paladin : 0,
                        'avenger' => [
                            'damagePrevented' => !empty($wl->damage_prevented_avenger) ? $wl->damage_prevented_avenger : 0,
                            'damage' => !empty($wl->damage_avenger) ? $wl->damage_avenger : 0,
                            'heal' => !empty($wl->heal_avenger) ? $wl->heal_avenger : 0,
                            'plays' => !empty($wl->avenger_plays) ? $wl->avenger_plays : 0,
                            'wins' => !empty($wl->wins_avenger) ? $wl->wins_avenger : 0,
                            'losses' => !empty($wl->losses_avenger) ? $wl->losses_avenger : 0
                        ],
                        'crusader' => [
                            'damagePrevented' => !empty($wl->damage_prevented_crusader) ? $wl->damage_prevented_crusader : 0,
                            'damage' => !empty($wl->damage_crusader) ? $wl->damage_crusader : 0,
                            'heal' => !empty($wl->heal_crusader) ? $wl->heal_crusader : 0,
                            'plays' => !empty($wl->crusader_plays) ? $wl->crusader_plays : 0,
                            'wins' => !empty($wl->wins_crusader) ? $wl->wins_crusader : 0,
                            'losses' => !empty($wl->losses_crusader) ? $wl->losses_crusader : 0
                        ],
                        'protector' => [
                            'damagePrevented' => !empty($wl->damage_prevented_protector) ? $wl->damage_prevented_protector : 0,
                            'damage' => !empty($wl->damage_protector) ? $wl->damage_protector : 0,
                            'heal' => !empty($wl->heal_protector) ? $wl->heal_protector : 0,
                            'plays' => !empty($wl->protector_plays) ? $wl->protector_plays : 0,
                            'wins' => !empty($wl->wins_protector) ? $wl->wins_protector : 0,
                            'losses' => !empty($wl->losses_protector) ? $wl->losses_protector : 0
                        ]
                    ]

                ],
                'uhc' => [
                    'coins' => !empty($uhc->coins) ? $uhc->coins : 0,
                    'score' => !empty($uhc->score) ? $uhc->score : 0,
                    'solo' => [
                        'deaths' => !empty($uhc->deaths_solo) ? $uhc->deaths_solo : 0,
                        'kills' => !empty($uhc->kills_solo) ? $uhc->kills_solo : 0,
                        'headsEaten' => !empty($uhc->heads_eaten_solo) ? $uhc->heads_eaten_solo : 0,
                        'wins' => !empty($uhc->wins_solo) ? $uhc->wins_solo : 0
                    ],
                    'team' => [
                        'deaths' => !empty($uhc->deaths) ? $uhc->deaths : 0,
                        'kills' => !empty($uhc->kills) ? $uhc->kills : 0,
                        'headsEaten' => !empty($uhc->heads_eaten) ? $uhc->heads_eaten : 0,
                        'wins' => !empty($uhc->wins) ? $uhc->wins : 0
                    ],
                    'redvsblue' => [
                        'deaths' => !empty($uhc->deaths_red_vs_blue) ? $uhc->deaths_red_vs_blue : 0,
                        'kills' => !empty($uhc->kills_red_vs_blue) ? $uhc->kills_red_vs_blue : 0,
                        'headsEaten' => !empty($uhc->heads_eaten_red_vs_blue) ? $uhc->heads_eaten_red_vs_blue : 0,
                        'wins' => !empty($uhc->wins_red_vs_blue) ? $uhc->wins_red_vs_blue : 0
                    ],
                    'nodiamonds' => [
                        'deaths' => !empty($uhc->deaths_no_diamonds) ? $uhc->deaths_no_diamonds : 0,
                        'kills' => !empty($uhc->kills_no_diamonds) ? $uhc->kills_no_diamonds : 0,
                        'headsEaten' => !empty($uhc->heads_eaten_no_diamonds) ? $uhc->heads_eaten_no_diamonds : 0,
                        'wins' => !empty($uhc->wins_no_diamonds) ? $uhc->wins_no_diamonds : 0
                    ],
                    'vanilladoubles' => [
                        'deaths' => !empty($uhc->deaths_vanilla_doubles) ? $uhc->deaths_vanilla_doubles : 0,
                        'kills' => !empty($uhc->kills_vanilla_doubles) ? $uhc->kills_vanilla_doubles : 0,
                        'headsEaten' => !empty($uhc->heads_eaten_vanilla_doubles) ? $uhc->heads_eaten_vanilla_doubles : 0,
                        'wins' => !empty($uhc->wins_vanilla_doubles) ? $uhc->wins_vanilla_doubles : 0
                    ],
                    'brawl' => [
                        'deaths' => !empty($uhc->deaths_brawl) ? $uhc->deaths_brawl : 0,
                        'kills' => !empty($uhc->kills_brawl) ? $uhc->kills_brawl : 0,
                        'headsEaten' => !empty($uhc->heads_eaten_brawl) ? $uhc->heads_eaten_brawl : 0,
                        'wins' => !empty($uhc->wins_brawl) ? $uhc->wins_brawl : 0
                    ],
                    'solobrawl' => [
                        'deaths' => !empty($uhc->deaths_solo_brawl) ? $uhc->deaths_solo_brawl : 0,
                        'kills' => !empty($uhc->kills_solo_brawl) ? $uhc->kills_solo_brawl : 0,
                        'headsEaten' => !empty($uhc->heads_eaten_solo_brawl) ? $uhc->heads_eaten_solo_brawl : 0,
                        'wins' => !empty($uhc->wins_solo_brawl) ? $uhc->wins_solo_brawl : 0
                    ],
                    'duobrawl' => [
                        'deaths' => !empty($uhc->deaths_duo_brawl) ? $uhc->deaths_duo_brawl : 0,
                        'kills' => !empty($uhc->kills_duo_brawl) ? $uhc->kills_duo_brawl : 0,
                        'headsEaten' => !empty($uhc->heads_eaten_duo_brawl) ? $uhc->heads_eaten_duo_brawl : 0,
                        'wins' => !empty($uhc->wins_duo_brawl) ? $uhc->wins_duo_brawl : 0
                    ]
                ],
                'copsandcrims' => [
                    'coins' => !empty($cac->coins) ? $cac->coins : 0,
                    'defusal' => [
                        'kills' => !empty($cac->kills) ? $cac->kills : 0,
                        'gameWins' => !empty($cac->game_wins) ? $cac->game_wins : 0,
                        'headshots' => !empty($cac->headshot_kills) ? $cac->headshot_kills : 0,
                        'copKills' => !empty($cac->cop_kills) ? $cac->cop_kills : 0,
                        'shotsFired' => !empty($cac->shots_fired) ? $cac->shots_fired : 0,
                        'roundWins' => !empty($cac->round_wins) ? $cac->round_wins : 0,
                        'deaths' => !empty($cac->deaths) ? $cac->deaths : 0,
                        'crimKills' => !empty($cac->criminal_kills) ? $cac->criminal_kills : 0,
                        'bombsPlanted' => !empty($cac->bombs_planted) ? $cac->bombs_planted : 0,
                        'bombsDefused' => !empty($cac->bombs_defused) ? $cac->bombs_defused : 0,
                    ],
                    'deathmatch' => [
                        'deaths' => !empty($cac->deaths_deathmatch) ? $cac->deaths_deathmatch : 0,
                        'gameWins' => !empty($cac->game_wins_deathmatch) ? $cac->game_wins_deathmatch : 0,
                        'crimKills' => !empty($cac->criminal_kills_deathmatch) ? $cac->criminal_kills_deathmatch : 0,
                        'copKills' => !empty($cac->cop_kills_deathmatch) ? $cac->cop_kills_deathmatch : 0,
                        'kills' => !empty($cac->kills_deathmatch) ? $cac->kills_deathmatch : 0,
                        'assists' => !empty($cac->assists_deathmatch) ? $cac->assists_deathmatch : 0
                    ]
                ],
                'murdermystery' => [
                    'coins' => !empty($mm->coins) ? $mm->coins : 0,
                    'wins' => !empty($mm->wins) ? $mm->wins : 0,
                    'games' => !empty($mm->games) ? $mm->games : 0,
                    'deaths' => !empty($mm->deaths) ? $mm->deaths : 0,
                    'coinsPickedUp' => !empty($mm->coins) ? $mm->coins_pickedup : 0,
                    'killsAsMurderer' => !empty($mm->kills_as_murderer) ? $mm->kills_as_murderer : 0,
                    'knifeKills' => !empty($mm->knife_kills) ? $mm->knife_kills : 0,
                    'kills' => !empty($mm->kills) ? $mm->kills : 0,
                    'bowKills' => !empty($mm->bow_kills) ? $mm->bow_kills : 0,
                    'killsAsSurvivor' => !empty($mm->kills_as_survivor) ? $mm->kills_as_survivor : 0,
                    'thrownKnifeKills' => !empty($mm->thrown_knife_kills) ? $mm->thrown_knife_kills : 0,
                    'detectiveWins' => !empty($mm->detective_wins) ? $mm->detective_wins : 0,
                    'wasHero' => !empty($mm->was_hero) ? $mm->was_hero : 0,
                    'classic' => [
                        'games' => !empty($mm->games_MURDER_CLASSIC) ? $mm->games_MURDER_CLASSIC : 0,
                        'wins' => !empty($mm->wins_MURDER_CLASSIC) ? $mm->wins_MURDER_CLASSIC : 0,
                        'deaths' => !empty($mm->deaths_MURDER_CLASSIC) ? $mm->deaths_MURDER_CLASSIC : 0,
                        'knifeKills' => !empty($mm->knife_kills_MURDER_CLASSIC) ? $mm->knife_kills_MURDER_CLASSIC : 0,
                        'kills' => !empty($mm->kills_MURDER_CLASSIC) ? $mm->kills_MURDER_CLASSIC : 0,
                        'bowKills' => !empty($mm->bow_kills_MURDER_CLASSIC) ? $mm->bow_kills_MURDER_CLASSIC : 0,
                        'thrownKnifeKills' => !empty($mm->thrown_knife_kills_MURDER_CLASSIC) ? $mm->thrown_knife_kills_MURDER_CLASSIC : 0
                    ],
                    'assassins' => [
                        'games' => !empty($mm->games_MURDER_ASSASSINS) ? $mm->games_MURDER_ASSASSINS : 0,
                        'wins' => !empty($mm->wins_MURDER_ASSASSINS) ? $mm->wins_MURDER_ASSASSINS : 0,
                        'deaths' => !empty($mm->deaths_MURDER_ASSASSINS) ? $mm->deaths_MURDER_ASSASSINS : 0,
                        'knifeKills' => !empty($mm->knife_kills_MURDER_ASSASSINS) ? $mm->knife_kills_MURDER_ASSASSINS : 0,
                        'kills' => !empty($mm->kills_MURDER_ASSASSINS) ? $mm->kills_MURDER_ASSASSINS : 0,
                        'bowKills' => !empty($mm->bow_kills_MURDER_ASSASSINS) ? $mm->bow_kills_MURDER_ASSASSINS : 0,
                        'thrownKnifeKills' => !empty($mm->thrown_knife_kills_MURDER_ASSASSINS) ? $mm->thrown_knife_kills_MURDER_ASSASSINS : 0
                    ],
                    'doubleup' => [
                        'games' => !empty($mm->games_MURDER_DOUBLE_UP) ? $mm->games_MURDER_DOUBLE_UP : 0,
                        'wins' => !empty($mm->wins_MURDER_DOUBLE_UP) ? $mm->wins_MURDER_DOUBLE_UP : 0,
                        'deaths' => !empty($mm->deaths_MURDER_DOUBLE_UP) ? $mm->deaths_MURDER_DOUBLE_UP : 0,
                        'knifeKills' => !empty($mm->knife_kills_MURDER_DOUBLE_UP) ? $mm->knife_kills_MURDER_DOUBLE_UP : 0,
                        'kills' => !empty($mm->kills_MURDER_DOUBLE_UP) ? $mm->kills_MURDER_DOUBLE_UP : 0,
                        'bowKills' => !empty($mm->bow_kills_MURDER_DOUBLE_UP) ? $mm->bow_kills_MURDER_DOUBLE_UP : 0,
                        'thrownKnifeKills' => !empty($mm->thrown_knife_kills_MURDER_DOUBLE_UP) ? $mm->thrown_knife_kills_MURDER_DOUBLE_UP : 0
                    ],
                    'infection' => [
                        'deaths' => !empty($mm->deaths_MURDER_INFECTION) ? $mm->deaths_MURDER_INFECTION : 0,
                        'games' => !empty($mm->games_MURDER_INFECTION) ? $mm->games_MURDER_INFECTION : 0,
                        'wins' => !empty($mm->wins_MURDER_INFECTION) ? $mm->wins_MURDER_INFECTION : 0,
                        'killsAsSurvivor' => !empty($mm->kills_as_survivor_MURDER_INFECTION) ? $mm->kills_as_survivor_MURDER_INFECTION : 0,
                        'killsAsInfected' => !empty($mm->kills_as_infected_MURDER_INFECTION) ? $mm->kills_as_infected_MURDER_INFECTION : 0
                    ]
                ],
                'buildbattle' => [
                    'teamsWins' => !empty($bb->wins_teams_normal) ? $bb->wins_teams_normal : 0,
                    'soloWins' => !empty($bb->wins_solo_normal) ? $bb->wins_solo_normal : 0,
                    'gamesPlayed' => !empty($bb->games_played) ? $bb->games_played : 0,
                    'score' => !empty($bb->score) ? $bb->score : 0,
                    'coins' => !empty($bb->coins) ? $bb->coins : 0,
                    'totalVotes' => !empty($bb->total_votes) ? $bb->total_votes : 0,
                    'guessTheBuildWins' => !empty($bb->wins_guess_the_build) ? $bb->wins_guess_the_build : 0,
                    'correctGuesses' => !empty($bb->correct_guesses) ? $bb->correct_guesses : 0,
                    'proWins' => !empty($bb->wins_solo_pro) ? $bb->wins_solo_pro : 0
                ],
                'megawalls' => [
                    'chosenClass' => !empty($mw->chosen_class) ? $mw->chosen_class : 0,
                    'coins' => !empty($mw->coins) ? $mw->coins : 0,
                    'deaths' => !empty($mw->deaths) ? $mw->deaths : 0,
                    'finalKills' => !empty($mw->finalKills) ? $mw->finalKills : 0,
                    'finalDeaths' => !empty($mw->finalDeaths) ? $mw->finalDeaths : 0,
                    'kills' => !empty($mw->kills) ? $mw->kills : 0,
                    'losses' => !empty($mw->losses) ? $mw->losses : 0,
                    'assists' => !empty($mw->assists) ? $mw->assists : 0,
                    'finalAssists' => !empty($mw->finalAssists) ? $mw->finalAssists : 0,
                    'wins' => !empty($mw->wins) ? $mw->wins : 0
                ],
                'bsg' => [
                    'coins' => !empty($bsg->coins) ? $bsg->coins : 0,
                    'deaths' => !empty($bsg->deaths) ? $bsg->deaths : 0,
                    'kills' => !empty($bsg->kills) ? $bsg->kills : 0,
                    'wins' => !empty($bsg->wins) ? $bsg->wins : 0
                ],
                'duels' => [
                    'games' => !empty($duels->games_played_duels) ? $duels->games_played_duels : 0,
                    'swings' => !empty($duels->melee_swings) ? $duels->melee_swings : 0,
                    'wins' => !empty($duels->wins) ? $duels->wins : 0,
                    'roundsPlayed' => !empty($duels->rounds_played) ? $duels->rounds_played : 0,
                    'kills' => !empty($duels->kills) ? $duels->kills : 0,
                    'bowShots' => !empty($duels->bow_shots) ? $duels->bow_shots : 0,
                    'losses' => !empty($duels->losses) ? $duels->losses : 0,
                    'deaths' => !empty($duels->deaths) ? $duels->deaths : 0
                ],
                'smash' => [
                    'coins' => !empty($smash->coins) ? $smash->coins : 0,
                    'winstreak' => !empty($smash->win_streak) ? $smash->win_streak : 0,
                    'smashLevel' => !empty($smash->smashLevel) ? $smash->smashLevel : 0,
                    'losses' => !empty($smash->losses) ? $smash->losses : 0,
                    'quits' => !empty($smash->quits) ? $smash->quits : 0,
                    'deaths' => !empty($smash->deaths) ? $smash->deaths : 0,
                    'games' => !empty($smash->games) ? $smash->games : 0,
                    'kills' => !empty($smash->kills) ? $smash->kills : 0,
                    'wins' => !empty($smash->wins) ? $smash->wins : 0
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

            return true;
        }
    }

	}

    /**
     * Gets the guild of the player using a guild name.
     *
     * @param $mongo_mng  MongoDB driver manager.
     * @param $guild      Name of the guild to check.
     * @param $API_KEY    API key to the Hypixel API.
     *
     * @return decoded_url URL of the JSON data with guild information.
     * @author ExKay <exkay61@hotmail.com>
     */
    function updateGuild($mongo_mng, $guild, $API_KEY) 
    {
        if (!$guild) {
            return false;
        } else {
            // Get guild JSON data from the Hypixel API.
            $guild_url = file_get_contents("https://api.hypixel.net/guild?key=" . $API_KEY . "&name=" . $guild);
            $guild_decoded_url = json_decode($guild_url);

            if ($guild_decoded_url->guild == null) {
                return false;
            } else {
                $stats = !empty($guild_decoded_url->guild) ? $guild_decoded_url->guild : "No Stats";

                $members = $stats->members;
                $ranks = $stats->ranks;

                $doc = [
                    'name' => $guild,
                    'created' => !empty($stats->created) ? $stats->created : 0,
                    'members' => $members,
                    'ranks' => $ranks,
                    'description' => !empty($stats->description) ? $stats->description : 0,
                    'publiclyListed' => !empty($stats->publiclyListed) ? $stats->publiclyListed : 0,
                    'exp' => !empty($stats->exp) ? $stats->exp : 0,
                    'tag' => !empty($stats->tag) ? $stats->tag : 0,
                    'tagColour' => !empty($stats->tagColor) ? $stats->tagColor : 0,
                    'expByGame' => [
                        'uhc' => !empty($stats->guildExpByGameType->UHC) ? $stats->guildExpByGameType->UHC : 0,
                        'megawalls' => !empty($stats->guildExpByGameType->WALLS3) ? $stats->guildExpByGameType->WALLS3 : 0,
                        'paintball' => !empty($stats->guildExpByGameType->PAINTBALL) ? $stats->guildExpByGameType->PAINTBALL : 0,
                        'skywars' => !empty($stats->guildExpByGameType->SKYWARS) ? $stats->guildExpByGameType->SKYWARS : 0,
                        'bedwars' => !empty($stats->guildExpByGameType->BEDWARS) ? $stats->guildExpByGameType->BEDWARS : 0,
                        'warlords' => !empty($stats->guildExpByGameType->BATTLEGROUND) ? $stats->guildExpByGameType->BATTLEGROUND : 0,
                        'vampirez' => !empty($stats->guildExpByGameType->VAMPIREZ) ? $stats->guildExpByGameType->VAMPIREZ : 0,
                        'buildbattle' => !empty($stats->guildExpByGameType->BUILD_BATTLE) ? $stats->guildExpByGameType->BUILD_BATTLE : 0,
                        'housing' => !empty($stats->guildExpByGameType->HOUSING) ? $stats->guildExpByGameType->HOUSING : 0,
                        'copsandcrims' => !empty($stats->guildExpByGameType->MCGO) ? $stats->guildExpByGameType->MCGO : 0,
                        'tnt' => !empty($stats->guildExpByGameType->TNTGAMES) ? $stats->guildExpByGameType->TNTGAMES : 0,
                        'quakecraft' => !empty($stats->guildExpByGameType->QUAKECRAFT) ? $stats->guildExpByGameType->QUAKECRAFT : 0,
                        'tkr' => !empty($stats->guildExpByGameType->GINGERBREAD) ? $stats->guildExpByGameType->GINGERBREAD : 0,
                        'pit' => !empty($stats->guildExpByGameType->PIT) ? $stats->guildExpByGameType->PIT : 0,
                        'prototype' => !empty($stats->guildExpByGameType->PROTOTYPE) ? $stats->guildExpByGameType->PROTOTYPE : 0,
                        'duels' => !empty($stats->guildExpByGameType->DUELS) ? $stats->guildExpByGameType->DUELS : 0,
                        'arcade' => !empty($stats->guildExpByGameType->ARCADE) ? $stats->guildExpByGameType->ARCADE : 0,
                        'bsg' => !empty($stats->guildExpByGameType->SURVIVAL_GAMES) ? $stats->guildExpByGameType->SURVIVAL_GAMES : 0,
                        'murdermystery' => !empty($stats->guildExpByGameType->MURDER_MYSTERY) ? $stats->guildExpByGameType->MURDER_MYSTERY : 0,
                        'walls' => !empty($stats->guildExpByGameType->WALLS) ? $stats->guildExpByGameType->WALLS : 0,
                        'arena' => !empty($stats->guildExpByGameType->ARENA) ? $stats->guildExpByGameType->ARENA : 0,
                        'smash' => !empty($stats->guildExpByGameType->SUPER_SMASH) ? $stats->guildExpByGameType->SUPER_SMASH : 0
                    ]


                ];

                $filter = ['name' => $guild]; 
                $query = new MongoDB\Driver\Query($filter);     
                
                $res = $mongo_mng->executeQuery("ayeballers.guild", $query);
                
                $player = current($res->toArray());
                
                if (!empty($player)) {
                    try {
                        $bulk = new MongoDB\Driver\BulkWrite();
                        $bulk->update(['name' => $guild], ['$set' => $doc]);
                        $result = $mongo_mng->executeBulkWrite('ayeballers.guild', $bulk); 
                    } catch (MongoDB\Driver\Exception\Exception $e) {
                        error_log($e->getMessage());
                    }
                } else {
                    try {
                        $bulk = new MongoDB\Driver\BulkWrite();
                        $bulk->insert($doc);
                        $result = $mongo_mng->executeBulkWrite('ayeballers.guild', $bulk); 
                    } catch (MongoDB\Driver\Exception\Exception $e) {
                        error_log($e->getMessage());
                    }
                }

                return true;
            }
        }
    }

    /**
     * Gets the local player object from a UUID from a MongoDB document.
     *
     * @param $mongo_mng  MongoDB driver manager.
     * @param $uuid       UUID of the player.
     *
     * @return player Mongo player object of the user.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getPlayerByUUID($mongo_mng, $uuid) 
    {
        $filter = ['uuid' => $uuid]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        $player = current($res->toArray());
        return $player;
    }

    /**
     * Gets the local player object from a username from a MongoDB document.
     *
     * @param $mongo_mng  MongoDB driver manager.
     * @param $name       Name of the player.
     *
     * @return player Mongo player object of the user.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getPlayerByName($mongo_mng, $name) 
    {
        $filter = ['name' => $name]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        $player = current($res->toArray());
        return $player;
    }

    /**
     * Checks if the player specified is stored in the database.
     *
     * @param $mongo_mng  MongoDB driver manager.
     * @param $uuid       UUID of the player.
     *
     * @return Boolean If the user is contained in the database.
     * @author ExKay <exkay61@hotmail.com>
     */
    function isPlayerStored($mongo_mng, $uuid) 
    {
        $filter = ['uuid' => $uuid]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        $player = current($res->toArray());
        if ($player) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets the guild of a player if they are in one.
     *
     * @param $mongo_mng  MongoDB driver manager.
     * @param $uuid       UUID of the player.
     *
     * @return guild Mongo guild object of the user.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getPlayersGuild($mongo_mng, $uuid) 
    {
        $filter = ['members.uuid' => $uuid]; 
        $query = new MongoDB\Driver\Query($filter);     
        $res = $mongo_mng->executeQuery("ayeballers.guild", $query);
        $guild = current($res->toArray());
        return $guild;
    }

    /**
     * Uses the experience value to calculate the network level.
     *
     * @param $exp The experience to convert.
     *
     * @return Network level value.
     * @author Plancke hypixel-php <https://github.com/Plancke/hypixel-php>
     */
    function getNetworkLevel(float $exp) 
    {
        $BASE = 10000;
        $GROWTH = 2500;
        $HALF_GROWTH = 0.5 * $GROWTH;
        $REVERSE_PQ_PREFIX = -($BASE - 0.5 * $GROWTH) / $GROWTH;
        $REVERSE_CONST = $REVERSE_PQ_PREFIX * $REVERSE_PQ_PREFIX;
        $GROWTH_DIVIDES_2 = 2 / $GROWTH;

        return $exp < 0 ? 1 : floor(1 + $REVERSE_PQ_PREFIX + sqrt($REVERSE_CONST + $GROWTH_DIVIDES_2 * $exp));
    }

    /**
     * Gets correct formatting of a players rank with their name.
     * Styling used with correct Hypixel Network colours.
     *
     * @param $name            Name of the player.
     * @param $rank            Rank of the player.
     * @param $rank_colour     Colour of the rank (if MVP+ colour used).
     *
     * @return $rank_with_name Formatting of the rank with the players name included.
     * @author ExKay <exkay61@hotmail.com>
     */
	function getRankFormatting($name, $rank, $rank_colour) 
    {
        if ($rank_colour == "BLACK") {
			$plus_colour = '<span style="color:#000000;">+</span>';
		} else if ($rank_colour == "RED") {
			$plus_colour = '<span style="color:#AA0000;">+</span>';
		} else if ($rank_colour == "DARK_GREEN") {
			$plus_colour = '<span style="color:#00AA00;">+</span>';
		} else if ($rank_colour == "None") {
			$plus_colour = '<span style="color:#FF5555;">+</span>';
		} else if ($rank_colour == "WHITE") {
			$plus_colour = '<span style="color:#FFFFFF;">+</span>';
		} else if ($rank_colour == "BLUE") {
			$plus_colour = '<span style="color:#5555FF;">+</span>';
		} else if ($rank_colour == "GREEN") {
			$plus_colour = '<span style="color:#55FF55;">+</span>';
		} else if ($rank_colour == "DARK_RED") {
			$plus_colour = '<span style="color:#AA0000;">+</span>';
		} else if ($rank_colour == "DARK_PURPLE") {
			$plus_colour = '<span style="color:#AA00AA;">+</span>';
        } else if ($rank_colour == "YELLOW") {
            $plus_colour = '<span style="color:#FFFF55;">+</span>';
        } else if ($rank_colour == "GOLD") {
            $plus_colour = '<span style="color:#FFAA00;">+</span>';
        } else if ($rank_colour == "DARK_AQUA") {
            $plus_colour = '<span style="color:#00AAAA;">+</span>';
        } else if ($rank_colour == "DARK_GRAY") {
            $plus_colour = '<span style="color:#555555;">+</span>';
        } else if ($rank_colour == "LIGHT_PURPLE") {
            $plus_colour = '<span style="color:#FF55FF;">+</span>';
        } else if ($rank_colour == "DARK_BLUE") {
            $plus_colour = '<span style="color:#5555FF;">+</span>';
		} else {
            $plus_colour = '<span style="color:#AA0000;">+</span>';
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
			$rank_with_name = '<span style="color:#ce1c1c;">' . '[YOUTUBE] ' . $name . '</span>';
		} else if ($rank == "MODERATOR") {
			$rank_with_name = '<span style="color:#238212;">' . '[MOD] ' . $name . '</span>';
        } else if ($rank == "GAME_MASTER") {
			$rank_with_name = '<span style="color:#238212;">' . '[GM] ' . $name . '</span>';
		} else if ($rank == "HELPER") {
			$rank_with_name = '<span style="color:#146594;">' . '[HELPER] ' . $name . '</span>';
		} else {
			$rank_with_name = '<span style="color:#a7aaa1;">' . $name . '</span>';
		}

		return $rank_with_name;
	}

    /**
     * Formats Minecraft colour codes.
     *
     * @param $string  String to format.
     *
     * @return $string Formatted string.
     * @author Minecrell <https://gist.github.com/Minecrell/755e53aced83ab48513f#file-minecraftcolors-css-L20>
     */
    function parseMinecraftColors($string, $name) {
        $string = utf8_decode(htmlspecialchars($string, ENT_QUOTES, "UTF-8"));
        $string = preg_replace('/\xA7([0-9a-f])/i', '<span class="mc-color mc-$1">', $string, -1, $count) . " " . $name . str_repeat("</span>", $count);
        return utf8_encode(preg_replace('/\xA7([k-or])/i', '<span class="mc-$1">', $string, -1, $count) . str_repeat("</span>", $count));
    }

    /**
     * Gets a readable name for paintball hats.
     *
     * @param $hat Hat name to translate.
     *
     * @return $hat_paintball Translated hat name.
     * @author ExKay <exkay61@hotmail.com>
     */
    function formatPaintballHat($hat) 
    {
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

    /**
     * Gets a readable name for TNT Games hats.
     *
     * @param $hat Hat name to translate.
     *
     * @return $hat_tnt Translated hat name.
     * @author ExKay <exkay61@hotmail.com>
     */
    function formatTntHat($hat) 
    {
        $hat_tnt = "No Hat Selected";

        switch ($hat) {
            case "final":
                $hat_tnt = "Final Hat";
                break;
            default:
                $hat_tnt = "No Hat Selected";
        }
        return $hat_tnt;
    }

    /**
     * Gets a readable string for recent game type.
     *
     * @param $game Game name to translate.
     *
     * @return $recent_game Translated name.
     * @author ExKay <exkay61@hotmail.com>
     */
    function formatRecentGame($game) 
    {
        $recent_game = "Unknown";

        switch ($game) {
            case "BUILD_BATTLE":
                $recent_game = "Build Battle";
                break;
            case "PAINTBALL":
                $recent_game = "Paintball";
                break;
            case "SKYWARS":
                $recent_game = "SkyWars";
                break;
            case "LEGACY":
                $recent_game = "Legacy Mode";
                break;
            case "BATTLEGROUND":
                $recent_game = "Warlords";
                break;
            case "TNTGAMES":
                $recent_game = "TNT Games";
                break;
            case "MURDER_MYSTERY":
                $recent_game = "Murder Mystery";
                break;
            case "HOUSING":
                $recent_game = "Housing";
                break;
            case "PROTOTYPE":
                $recent_game = "SkyBlock";
                break;
            case "ARCADE":
                $recent_game = "Arcade";
                break;
            case "DUELS":
                $recent_game = "Duels";
                break;
            case "QUAKECRAFT":
                $recent_game = "Quakecraft";
                break;
            case "GINGERBREAD":
                $recent_game = "Turbo Kart Racers";
                break;
            case "SURVIVAL_GAMES":
                $recent_game = "Blitz Survival Games";
                break;
            case "WALLS":
                $recent_game = "The Walls";
                break;
            case "WALLS3":
                $recent_game = "Mega Walls";
                break;
            default:
                $recent_game = "Unknown";
        }

        return $recent_game;
    }

?>