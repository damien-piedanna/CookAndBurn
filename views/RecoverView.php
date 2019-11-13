<div class="container" style="padding-left: 15%; padding-right: 15%;padding-top:10% ;min-height: calc(100vh - 157px)">
    <div class="card">
        <h5 class="card-header darken-3 white-text text-center py-4" style="background-color: #424242">
            <strong>Réinitialiser mot de passe</strong>
        </h5>
        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">

            <!-- Form -->
            <form class="text-center" style="color: #757575;" accept-charset="UTF-8" action="/login/recover/proceed" method="post">
                <?php include 'views/assets/alert.php'; ?>
                <div class="md-form">
                    <input type="text" name="code" id="code" value="<?= $token ?>" class="form-control">
                    <label for="code">Code de réinitialisation</label>
                </div>
                <!-- Nouveau mot de passe -->
                <div class="md-form">
                    <input type="password" name="newpassword" id="newpassword" class="form-control">
                    <label for="newpassword">Nouveau mot de passe</label>
                </div>
                <!-- Répéter mot de passe -->
                <div class="md-form">
                    <input type="password" name="renewpassword" id="renewpassword" class="form-control">
                    <label for="renewpassword">Confirmation</label>
                </div>
                <button class="btn btn-outline-grey btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Envoyer</button>

            </form>
            <!-- Form -->

        </div>
    </div>
</div>