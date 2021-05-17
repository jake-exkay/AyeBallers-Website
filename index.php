<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            require "includes/links.php"; 
            require "functions/backend_functions.php";
            require "functions/player_functions.php";
            require "error/error_messages.php";
            include "admin/functions/login_functions.php";
        ?>
        <title>AyeBallers Hypixel Statistics</title>

        <script>
            function loadLeaderboard(str) {
                if (str == "") {
                    document.getElementById("leaderboard-result").innerHTML = "";
                    return;
                } else {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("leaderboard-result").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "ajax_lb.php?q=" + str, true);
                    xmlhttp.send();
                }
            }

            function loadStats() {
                var player = document.getElementById("player-search").value;

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("stats-result").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "ajax_stats.php?q=" + player, true);
                xmlhttp.send();
            }

            function loadButtons(str) {
                if (str == "") {
                    document.getElementById("leaderboard-result").innerHTML = "";
                    return;
                }
                if (str == "TNT") {
                    document.getElementById("leaderboard-result").innerHTML = '<center><br><h2>Select Game Mode</h2>' + 
                    '<a href="#leaderboards" title="TNT Run" style="padding-left:5px" onclick="loadLeaderboard(\'TNTRun\')"><button class="btn btn-primary btn-xl">TNT Run</button></a>' +
                    '<a href="#leaderboards" title="TNT Tag" style="padding-left:5px" onclick="loadLeaderboard(\'TNTTag\')"><button class="btn btn-primary btn-xl">TNT Tag</button></a>' +
                    '<a href="#leaderboards" title="Bow Spleef" style="padding-left:5px" onclick="loadLeaderboard(\'BowSpleef\')"><button class="btn btn-primary btn-xl">Bow Spleef</button></a>' +
                    '<a href="#leaderboards" title="PVP Run" style="padding-left:5px" onclick="loadLeaderboard(\'PVPRun\')"><button class="btn btn-primary btn-xl">PVP Run</button></a>' +
                    '<a href="#leaderboards" title="Wizards" style="padding-left:5px" onclick="loadLeaderboard(\'Wizards\')"><button class="btn btn-primary btn-xl">Wizards</button></a></center>';
                }
                if (str == "Arcade") {
                    document.getElementById("leaderboard-result").innerHTML = '<center><br><h2>Select Game Mode</h2>' + 
                    '<a href="#leaderboards" title="Bounty Hunters" style="padding-left:5px" onclick="loadLeaderboard(\'BountyHunters\')"><button class="btn btn-primary btn-xl">Bounty Hunters</button></a>' +
                    '<a href="#leaderboards" title="Throw Out" style="padding-left:5px" onclick="loadLeaderboard(\'ThrowOut\')"><button class="btn btn-primary btn-xl">Throw Out</button></a>' +
                    '<a href="#leaderboards" title="Blocking Dead" style="padding-left:5px" onclick="loadLeaderboard(\'BlockingDead\')"><button class="btn btn-primary btn-xl">Blocking Dead</button></a>' +
                    '<a href="#leaderboards" title="Dragon Wars" style="padding-left:5px" onclick="loadLeaderboard(\'DragonWars\')"><button class="btn btn-primary btn-xl">Dragon Wars</button></a>' +
                    '<a href="#leaderboards" title="Creeper Attack" style="padding-left:5px" onclick="loadLeaderboard(\'CreeperAttack\')"><button class="btn btn-primary btn-xl">Creeper Attack</button></a>' +
                    '<a href="#leaderboards" title="Farm Hunt" style="padding-left:5px" onclick="loadLeaderboard(\'FarmHunt\')"><button class="btn btn-primary btn-xl">Farm Hunt</button></a>' +
                    '<a href="#leaderboards" title="Ender Spleef" style="padding-left:5px" onclick="loadLeaderboard(\'EnderSpleef\')"><button class="btn btn-primary btn-xl">Ender Spleef</button></a>' +
                    '<a href="#leaderboards" title="Party Games" style="padding-left:5px" onclick="loadLeaderboard(\'PartyGames\')"><button class="btn btn-primary btn-xl">Party Games</button></a>' +
                    '<a href="#leaderboards" title="Galaxy Wars" style="padding-left:5px" onclick="loadLeaderboard(\'GalaxyWars\')"><button class="btn btn-primary btn-xl">Galaxy Wars</button></a>' +
                    '<a href="#leaderboards" title="Hole In The Wall" style="padding-left:5px" onclick="loadLeaderboard(\'HoleInTheWall\')"><button class="btn btn-primary btn-xl">Hole In The Wall</button></a>' +
                    '<a href="#leaderboards" title="Hypixel Says" style="padding-left:5px" onclick="loadLeaderboard(\'HypixelSays\')"><button class="btn btn-primary btn-xl">Hypixel Says</button></a>' +
                    '<a href="#leaderboards" title="MiniWalls" style="padding-left:5px" onclick="loadLeaderboard(\'MiniWalls\')"><button class="btn btn-primary btn-xl">Mini Walls</button></a>' +
                    '<a href="#leaderboards" title="Football" style="padding-left:5px" onclick="loadLeaderboard(\'Football\')"><button class="btn btn-primary btn-xl">Football</button></a>' +
                    '<a href="#leaderboards" title="Zombies" style="padding-left:5px" onclick="loadLeaderboard(\'Zombies\')"><button class="btn btn-primary btn-xl">Zombies</button></a>' +
                    '<a href="#leaderboards" title="Hide And Seek" style="padding-left:5px" onclick="loadLeaderboard(\'HideAndSeek\')"><button class="btn btn-primary btn-xl">Hide And Seek</button></a></center>';
                }
                if (str == "UHC") {
                    document.getElementById("leaderboard-result").innerHTML = '<center><br><h2>Select Game Mode</h2>' + 
                    '<a href="#leaderboards" title="Solo" style="padding-left:5px" onclick="loadLeaderboard(\'UHCSolo\')"><button class="btn btn-primary btn-xl">Solo</button></a>' +
                    '<a href="#leaderboards" title="Teams" style="padding-left:5px" onclick="loadLeaderboard(\'UHCTeams\')"><button class="btn btn-primary btn-xl">Teams</button></a>' +
                    '<a href="#leaderboards" title="Brawl" style="padding-left:5px" onclick="loadLeaderboard(\'UHCBrawl\')"><button class="btn btn-primary btn-xl">Brawl</button></a>' +
                    '<a href="#leaderboards" title="Solo Brawl" style="padding-left:5px" onclick="loadLeaderboard(\'UHCSoloBrawl\')"><button class="btn btn-primary btn-xl">Solo Brawl</button></a>' +
                    '<a href="#leaderboards" title="Duo Brawl" style="padding-left:5px" onclick="loadLeaderboard(\'UHCDuoBrawl\')"><button class="btn btn-primary btn-xl">Duo Brawl</button></a></center>';
                }
                if (str == "MurderMystery") {
                    document.getElementById("leaderboard-result").innerHTML = '<center><br><h2>Select Game Mode</h2>' + 
                    '<a href="#leaderboards" title="Overall" style="padding-left:5px" onclick="loadLeaderboard(\'MMOverall\')"><button class="btn btn-primary btn-xl">Overall</button></a>' +
                    '<a href="#leaderboards" title="Classic" style="padding-left:5px" onclick="loadLeaderboard(\'MMClassic\')"><button class="btn btn-primary btn-xl">Classic</button></a>' +
                    '<a href="#leaderboards" title="Assassins" style="padding-left:5px" onclick="loadLeaderboard(\'MMAssassins\')"><button class="btn btn-primary btn-xl">Assassins</button></a>' +
                    '<a href="#leaderboards" title="Double Up" style="padding-left:5px" onclick="loadLeaderboard(\'MMDoubleUp\')"><button class="btn btn-primary btn-xl">Double Up</button></a>' +
                    '<a href="#leaderboards" title="Infection" style="padding-left:5px" onclick="loadLeaderboard(\'MMInfection\')"><button class="btn btn-primary btn-xl">Infection</button></a></center>';
                }
            }
        </script>
    </head>
    <body id="page-top">

        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">AyeBallers</a>
                <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#statistics">Statistics</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#leaderboards">Leaderboards</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Masthead-->
        <header style="background-image: url('assets/img/background-2.jpg'); background-repeat: no-repeat; background-attachment: fixed; background-size: cover;" class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <!-- Masthead Avatar Image-->
                <img class="masthead-avatar mb-5" src="assets/img/hypixel-logo.png" alt="Hypixel Logo" />
                <!-- Masthead Heading-->
                <h1 class="masthead-heading text-uppercase mb-0">Hypixel Statistics</h1>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-icon"><i class="fas fa-circle"></i></div>
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-circle"></i></div>
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-circle"></i></div>
                </div>
                <!-- Masthead Subheading-->
                <p class="masthead-subheading font-weight-light mb-0">Lookup your Hypixel statistics and track your positions on overall leaderboards.</p>
            </div>
        </header>

        <!-- Statistics Section-->
        <section class="page-section portfolio" id="statistics">
            <div class="container">
                <!-- Portfolio Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Statistics Lookup</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <center>
                            <form id="lookupPlayer" name="playerForm" novalidate="novalidate" action="stats.php" method="GET" enctype="multipart/form-data">
                                <div class="control-group">
                                    <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                        <label>Player Lookup</label>
                                        <input class="form-control" name="player" type="text" placeholder="Player Name" required="required" data-validation-required-message="Please enter a player name." />
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                
                                <br />
                                <div id="success"></div>
                                <div class="form-group"><button class="btn btn-primary btn-xl" id="sendMessageButton" type="submit">Search Player</button></div>
                            </form>

                            <form id="lookupGuild" name="guildForm" novalidate="novalidate" action="guild.php" method="GET" enctype="multipart/form-data">
                                <div class="control-group">
                                    <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                        <label>Guild Lookup</label>
                                        <input class="form-control" name="guild" type="text" placeholder="Guild Name" required="required" data-validation-required-message="Please enter a guild name." />
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                
                                <br />
                                <div id="success"></div>
                                <div class="form-group"><button class="btn btn-primary btn-xl" id="sendMessageButton" type="submit">Search Guild</button></div>
                            </form>

                            
                        </center>
                    </div>
                </div>
                
            </div>
            <div id="stats-result" style="padding-left: 150px; padding-right: 150px; width: 100%; margin: 0 auto;"></div>
        </section>

        <!-- Leaderboard Section-->
        <section class="page-section" id="leaderboards">
            <div class="container">
                <!-- Contact Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Leaderboards</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- Contact Section Form-->
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <center>
                            <a href="#leaderboards" title="First Login" onclick="loadLeaderboard('FirstLogin')"><button class="btn btn-primary btn-xl">First Login</button></a>
                            <a href="#leaderboards" title="Achievement Points" onclick="loadLeaderboard('AchievementPoints')"><button class="btn btn-primary btn-xl">Achievements</button></a>
                            <a href="#leaderboards" title="Network Level" onclick="loadLeaderboard('NetworkLevel')"><button class="btn btn-primary btn-xl">Network Level</button></a>
                            <a href="#leaderboards" title="Karma" onclick="loadLeaderboard('Karma')"><button class="btn btn-primary btn-xl">Karma</button></a>
                        </center>

                        <br />

                        <center>
                            <a href="#leaderboards" title="Paintball" onclick="loadLeaderboard('Paintball')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/paintball-img.png"/></a>
                            <a href="#leaderboards" title="Quakecraft" onclick="loadLeaderboard('Quakecraft')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/quakecraft-img.png"/></a>
                            <a href="#leaderboards" title="The Walls" onclick="loadLeaderboard('Walls')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/walls-img.png"/></a>
                            <a href="#leaderboards" title="VampireZ" onclick="loadLeaderboard('VampireZ')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/vampirez-img.png"/></a>
                            <a href="#leaderboards" title="Turbo Kart Racers" onclick="loadLeaderboard('Tkr')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/tkr-img.png"/></a>
                            <a href="#leaderboards" title="Arena Brawl" onclick="loadLeaderboard('Arena')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/arena-img.png"/></a>
                            <a href="#leaderboards" title="Warlords" onclick="loadLeaderboard('Warlords')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/warlords-img.png"/></a>
                            <a href="#leaderboards" title="TNT Games" onclick="loadButtons('TNT')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/tnt-img.png"/></a>
                            <a href="#leaderboards" title="Bedwars" onclick="loadLeaderboard('Bedwars')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/bedwars-img.png"/></a>
                            <a href="#leaderboards" title="Skywars" onclick="loadLeaderboard('Skywars')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/skywars-img.png"/></a>
                            <a href="#leaderboards" title="Murder Mystery" onclick="loadButtons('MurderMystery')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/murdermystery-img.png"/></a>
                            <a href="#leaderboards" title="Arcade Games" onclick="loadButtons('Arcade')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/arcade-img.png"/></a>
                            <a href="#leaderboards" title="UHC Champions" onclick="loadButtons('UHC')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/uhc-img.png"/></a>
                            <a href="#leaderboards" title="Build Battle" onclick="loadLeaderboard('BuildBattle')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/buildbattle-img.png"/></a>
                            <a href="#leaderboards" title="Cops and Crims" onclick="loadLeaderboard('CopsAndCrims')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/cac-img.png"/></a>
                            <a href="#leaderboards" title="Duels" onclick="loadLeaderboard('Duels')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/duels-img.png"/></a>
                            <a href="#leaderboards" title="Mega Walls" onclick="loadLeaderboard('MegaWalls')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/megawalls-img.png"/></a>
                            <a href="#leaderboards" title="Blitz Survival Games" onclick="loadLeaderboard('BSG')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/bsg-img.png"/></a>
                            <a href="#leaderboards" title="Smash Heroes" onclick="loadLeaderboard('Smash')"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/smash-img.png"/></a>
                        </center>

                        <br/>

                    </div>
                    
                    <div id="leaderboard-result" style="width: 100%; margin: 0 auto;"></div>
                </div>
            </div>
        </section>

        <!--<input class="form-control" id="player-search" name="player-search" type="text" placeholder="Player Name" required="required" data-validation-required-message="Please enter a player name." />
        <a title="Player Search" onclick="loadStats()"><button data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-xl">Search</button></a>-->

        <?php require "includes/footer.php"; ?>

        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
        <div class="scroll-to-top d-lg-none position-fixed">
            <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a>
        </div>

    </body>
    

</html>
