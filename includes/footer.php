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

<footer class="bg-dark text-center text-lg-start">
  <div class="container p-4">
    <div class="row">
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase" style="color:white;">AyeBallers</h5>

        <p style="color:white;">
          Created using the Hypixel API, Mojang API and Crafatar API.
        </p>
      </div>

      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase" style="color:white;">Links</h5>

        <ul class="list-unstyled mb-0">
          <li>
            <a href="#!" class="text-light">About</a>
          </li>
          <li>
            <a href="#!" class="text-light">Admin</a>
          </li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase mb-0" style="color:white;">Social</h5>

        <ul class="list-unstyled">
          <li>
            <a href="#!" class="text-light">Discord</a>
          </li>
          <li>
            <a href="#!" class="text-light">Hypixel Forums</a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2); color:white;">
    © 2021 Copyright: AyeBallers / ExKay
  </div>
</footer>

<script>
 if (!navigator.serviceWorker.controller) {
     navigator.serviceWorker.register("../sw.js").then(function(reg) {
         console.log("Service worker has been registered for scope: " + reg.scope);
     });
 }
</script>

<?php mysqli_close($connection); ?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="../../../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
