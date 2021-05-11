<?php
/**
 * Includes file which contains footer of the site and closes MySQL database connection.
 *
 * @category Includes
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */

?>

<!-- Footer-->
<footer class="footer text-center">
    <div class="container">
        <div class="row">
            <!-- Footer Location-->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h4 class="text-uppercase mb-4">AyeBallers</h4>
                <p class="lead mb-0">
                    AyeBallers is a guild on the Hypixel Network based around the Paintball minigame. This website allows player to view game leaderboards and look up statistics.
                </p>
            </div>
            <!-- Footer Social Icons-->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h4 class="text-uppercase mb-4">Join Us</h4>
                <a class="btn btn-outline-light btn-social mx-1" href="https://discord.gg/ETz36PmR9k"><i class="fab fa-fw fa-discord"></i></a>
                <a class="btn btn-outline-light btn-social mx-1" href="https://hypixel.net/threads/%E2%9C%A9-ayeballers-pb-all-games-1-paintball-applications-open-%E2%9C%A9.2801206/"><i class="fa fa-users"></i></a>
            </div>
            <!-- Footer About Text-->
            <div class="col-lg-4">
                <h4 class="text-uppercase mb-4">Website Info</h4>
                <p class="lead mb-0">
                    Website developed by ExKay using Hypixel and Mojang API's. Free to use theme by <a href="http://startbootstrap.com">Start Bootstrap</a>.
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- Copyright Section-->
<div class="copyright py-4 text-center text-white">
    <div class="container">
        <small>
            Copyright &copy; AyeBallers / ExKay
            <!-- This script automatically adds the current year to your website footer-->
            <!-- (credit: https://updateyourfooter.com/)-->
            <script>
                document.write(new Date().getFullYear());
            </script>
        </small>
    </div>
</div>

<script>
 if (!navigator.serviceWorker.controller) {
     navigator.serviceWorker.register("../sw.js").then(function(reg) {
         console.log("Service worker has been registered for scope: " + reg.scope);
     });
 }
</script>

<?php mysqli_close($connection); ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>