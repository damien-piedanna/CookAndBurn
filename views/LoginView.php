<div class="container" style="padding-left: 15%; padding-right: 15%;padding-top:10% ;min-height: calc(100vh - 157px)">
    <div class="card">
        <h5 class="card-header darken-3 white-text text-center py-4" style="background-color: #424242">
            <strong>Se connecter</strong>
        </h5>
        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">

            <!-- Form -->
            <form class="text-center" accept-charset="UTF-8" action="/login/proceed" method="post">
                <?php include 'views/assets/alert.php'; ?>
                <!-- Email -->
                <div class="md-form">
                    <input type="email" name="email" id="materialLoginFormEmail" class="form-control">
                    <label for="materialLoginFormEmail">E-mail</label>
                </div>

                <!-- Password -->
                <div class="md-form ">
                    <input type="password" name="password" id="materialLoginFormPassword" class="form-control">
                    <label for="materialLoginFormPassword">Mot de passe</label>
                </div>

                <div>
                    <!-- Forgot password -->
                    <a href="" data-toggle="modal" data-target="#modalmdpoublie">Mot de passe oublié?</a>
                </div>

                <input id="request" name="request" type="hidden" value="<?= $request ?>">
                <!-- Sign in button -->
                <button class="btn btn-outline-grey btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Se connecter</button>

            </form>
            <!-- Form -->

        </div>
    </div>
</div>

<div class="modal fade" id="modalmdpoublie" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Réinitialiser votre mot de passe</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3 email-modal">
                <form id="pswdreset" name="pswdreset" method="post" action="/login/reset">
                    <div class="md-form mb-4">
                        <i class="fa fa-envelope prefix grey-text"></i>
                        <input type="email" name="email" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="email">E-mail</label>
                    </div>
            </div>
            <div class="modal-footer d-flex justify-content-center button-modal">
                <button class="btn btn-indigo" type="submit">Réinitialiser</button>
            </div>
            </form>
        </div>
    </div>
</div>
