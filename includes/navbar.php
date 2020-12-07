<?php
/**
 * Contains main navigation bar for the site.
 *
 * @category Includes
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */

echo '
	<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="../../../index.php">AyeBallers</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Hypixel</div>
                        <a class="nav-link" href="../../../index.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-home"></i>
                            </div>
                            Player Statistics
                        </a>
                        <a class="nav-link" href="../../../ayeballers.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            Guild
                        </a>
                        <a class="nav-link" href="../../../event/leaderboard.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-star"></i>
                            </div>
                            Tournament
                        </a>
                        <a class="nav-link" href="../../../guildsearch.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            Guild Statistics
                        </a>
                        <div class="sb-sidenav-menu-heading">Classic Leaderboards</div>
                        <a class="nav-link" href="../../../leaderboard/overall/arena.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-th-list"></i>
                            </div>
                            Arena Brawl
                        </a>
                        <a class="nav-link" href="../../../leaderboard/overall/paintball.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-th-list"></i>
                            </div>
                            Paintball
                        </a>
                        <a class="nav-link" href="../../../leaderboard/overall/quakecraft.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-th-list"></i>
                            </div>
                            Quakecraft
                        </a>
                        <a class="nav-link" href="../../../leaderboard/overall/tkr.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-th-list"></i>
                            </div>
                            Turbo Kart Racers
                        </a>
                        <a class="nav-link" href="../../../leaderboard/overall/vampirez.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-th-list"></i>
                            </div>
                            VampireZ
                        </a>
                        <a class="nav-link" href="../../../leaderboard/overall/walls.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-th-list"></i>
                            </div>
                            The Walls
                        </a>

                        <div class="sb-sidenav-menu-heading">Other Leaderboards</div>
                        <a class="nav-link" href="../../../leaderboard/overall/tntgames.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-th-list"></i>
                            </div>
                            TNT Games
                        </a>

                        <a class="nav-link" href="../../../leaderboard/overall/bedwars.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa fa-th-list"></i>
                            </div>
                            Bedwars
                        </a>

                    </div>
                </div>
            </nav>
        </div>

';

?>