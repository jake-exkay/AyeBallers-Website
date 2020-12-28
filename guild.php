<?php
/**
 * Guild stats page - Shows customised stats for guilds based on GET data.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/stats.php
 */

require "includes/links.php";
require "includes/connect.php";
require "includes/constants.php";
require "functions/functions.php";
require "functions/display_functions.php";
require "functions/player_functions.php";
require "error/error_messages.php";
include "admin/functions/login_functions.php";

updatePageViews($connection, 'guild_page', $DEV_IP);
   
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <?php 
            $guild_name = $_GET["guild"];
            if (!updateGuild($mongo_mng, $guild_name, $API_KEY)) {
                header("Refresh:0.01; url=error/guildnotfound.php");
            } else {
        ?>

        <title><?php echo $guild_name; ?> Guild - AyeBallers</title>

    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <?php 

                    $filter = ['name' => $guild_name]; 
                    $query = new MongoDB\Driver\Query($filter);     
                    
                    $res = $mongo_mng->executeQuery("ayeballers.guild", $query);
                    
                    $guild = current($res->toArray());
                    
                    if (!empty($guild_name)) {
                        $date_created = $guild->created;
                        $members = $guild->members;
                        $description = $guild->description;
                        $tag = $guild->tag;
                        $exp = $guild->exp;
                        $member_size = sizeof($members);
                        $date_created = date("d M Y (H:i:s)", (int)substr($date_created, 0, 10));

                        $battleground_exp = $guild->expByGame->warlords;
                        $uhc_exp = $guild->expByGame->uhc;
                        $bsg_exp = $guild->expByGame->bsg;
                        $skywars_exp = $guild->expByGame->skywars;
                        $duels_exp = $guild->expByGame->duels;
                        $paintball_exp = $guild->expByGame->paintball;
                        $arena_exp = $guild->expByGame->arena;
                        $tntgames_exp = $guild->expByGame->tnt;
                        $mcgo_exp = $guild->expByGame->copsandcrims;
                        $walls_exp = $guild->expByGame->walls;
                        $vz_exp = $guild->expByGame->vampirez;
                        $gingerbread_exp = $guild->expByGame->tkr;
                        $super_smash_exp = $guild->expByGame->smash;
                        $qc_exp = $guild->expByGame->quakecraft;
                        $bb_exp = $guild->expByGame->buildbattle;
                        $arcade_exp = $guild->expByGame->arcade;
                        $prototype_exp = $guild->expByGame->prototype;
                        $walls3_exp = $guild->expByGame->megawalls;
                        $housing_exp = $guild->expByGame->housing;
                        $mm_exp = $guild->expByGame->murdermystery;
                        $bedwars_exp = $guild->expByGame->bedwars;
                    }

                    $previous = "javascript:history.go(-1)";
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $previous = $_SERVER['HTTP_REFERER'];
                    }

                ?>

                <main>
            
                    <div class="card">

                        <div class="card-body">
                            <form style="margin-right: 10px;" action="<?= $previous ?>">
                                <button type="submit" class="btn btn-danger">< Back</button>
                            </form>

                            <h1><?php echo $guild_name; ?></h1>

                            <br>

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Guild Statistics
                                        </div>
                                        <div class="card-body">
                                            <p><b>Guild Level:</b> <?php echo getGuildLevel($exp); ?> </p>
                                            <p><b>Members:</b> <?php echo $member_size; ?></p>
                                            <p><b>Description:</b> <?php echo $description; ?></p>
                                            <p><b>Date Created:</b> <?php echo $date_created; ?></p>
                                            <p><b>Guild Tag:</b> [<?php echo $tag; ?>]</p>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Guild EXP Earned By Game
                                        </div>
                                        <div class="card-body">
                                            <canvas id="expPie"></canvas>
                                        </div>
                                    </div>

                                </div>
                    

                                <div class="col-md-8">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-list mr-1"></i>
                                            Guild Members
                                        </div>
                                        <div class="card-body">
                                            <?php

                                                foreach ($members as $member) {
                                                    $uuid = $member->uuid;
                                                    $rank = $member->rank;
                                                    $joined = $member->joined;
                                                    
                                                    if (!isPlayerStored($mongo_mng, $uuid)) {
                                                        if (apiLimitReached($API_KEY)) {
                                                            header("Refresh:0.01; url=error/api_request.php");
                                                            break;
                                                        } else {
                                                            updatePlayer($mongo_mng, $uuid, $API_KEY);
                                                        }
                                                    }

                                                    $name = getLocalName($mongo_mng, $uuid);

                                                    echo '<div class="card"><div class="card-body">';
                                                    echo '<img alt="Player Avatar" style="height: 25px; width: 25px;" src="https://crafatar.com/avatars/' . $uuid . '"/> ';
                                                    echo "[" . $rank . "] " . $name . "<br>";
                                                    echo '</div></div>';
                                                }

                                            ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </main>

                <?php require "includes/footer.php"; ?>

                <script>
                    var ctxP = document.getElementById("expPie").getContext('2d');
                    var pbPie = new Chart(ctxP, {
                        type: 'horizontalBar',
                        data: {
                            labels: ["Warlords", "UHC", "Blitz Survival Games", "SkyWars", "Duels", "Paintball", "Arena Brawl", "TNT Games", "Cops and Crims", "The Walls", "VampireZ", "Turbo Kart Racers", "Smash Heroes", "Quakecraft", "Build Battle", "Arcade", "Prototype (Includes Skyblock)", "Mega Walls", "Housing", "Murder Mystery", "Bedwars"],
                            datasets: [{
                                label: "Guild EXP By Game",
                                data: ["<?php echo $battleground_exp; ?>", "<?php echo $uhc_exp; ?>", "<?php echo $bsg_exp; ?>", "<?php echo $skywars_exp; ?>", "<?php echo $duels_exp; ?>", "<?php echo $paintball_exp; ?>", "<?php echo $arena_exp; ?>", "<?php echo $tntgames_exp; ?>", "<?php echo $mcgo_exp; ?>", "<?php echo $walls_exp; ?>", "<?php echo $vz_exp; ?>", "<?php echo $gingerbread_exp; ?>", "<?php echo $super_smash_exp; ?>", "<?php echo $qc_exp; ?>", "<?php echo $bb_exp; ?>", "<?php echo $arcade_exp; ?>", "<?php echo $prototype_exp; ?>", "<?php echo $walls3_exp; ?>", "<?php echo $housing_exp; ?>", "<?php echo $mm_exp; ?>", "<?php echo $bedwars_exp; ?>"],
                                backgroundColor: ["#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A"],
                                borderColor: ["#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A"]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                    });

                </script>

            </div>

    </body>
<?php } ?>
</html>
