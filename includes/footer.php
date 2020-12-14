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

<footer class="py-4 bg-dark mt-auto">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; AyeBallers / ExKay 2020</div>
            <?php if (getUsername($connection) == "None") { ?>
                <form action="../../../login.php">
                    <button data-toggle="collapse" class="btn btn-light btn-outline-success">Login</button>
                </form>
            <?php } else { ?>
                <form action="../../../logout.php">
                    <div class="card" style="background-color: #b7b5b4">
                        <div class="card-body" style="background-color: #706e6b">
                            <div class="row">
                                <?php if (getUsername($connection) == "ExKay") { ?>
                                    <img alt="Player Avatar" style="height: 50px; width: 50px;" src="https://crafatar.com/avatars/82df5a8f-a793-4e60-87d1-86d8741a1d23"/>
                                <?php } else if (getUsername($connection) == "Emilyie") { ?>
                                    <img alt="Player Avatar" style="height: 50px; width: 50px;" src="https://crafatar.com/avatars/38839c0e-43ac-4b1a-a0e6-c189ca15412f"/>
                                <?php } else if (getUsername($connection) == "PotAccuracy") { ?>
                                    <img alt="Player Avatar" style="height: 50px; width: 50px;" src="https://crafatar.com/avatars/fe101e8a-30d1-4137-b110-1bd22031bf35"/>
                                <?php } else if (getUsername($connection) == "Penderdrill") { ?>
                                    <img alt="Player Avatar" style="height: 50px; width: 50px;" src="https://crafatar.com/avatars/bb0b8eee-dc58-4ee9-bbf7-c590d5aa2319"/>
                                <?php } else { ?>
                                    <img alt="Player Avatar" style="height: 50px; width: 50px;" src="https://crafatar.com/avatars/82df5a8f-a793-4e60-87d1-86d8741a1d23"/>
                                <?php } ?>
                                <h2 style="color: #FFFFFF; padding-left: 20px; padding-right: 20px;"><?php echo getUsername($connection); ?></h2>
                                <button data-toggle="collapse" class="btn btn-light btn-outline-success">Logout</button>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } ?>
        </div>
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
