<div class="container" style="background-color: white">
    <?php include 'views/assets/alert.php'; ?>
    <div class="card card-body">
        <h4 class="card-title">Mon compte (<?=$user->getRole()?>)</h4>
        <hr>
        <form accept-charset="UTF-8" action="/account/changeinfo" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="md-form mb-0 ">
                    <i  class="fa fa-user  prefix "></i>
                    <input type="text" id="username" name="username" value="<?=$user->getUsername()?>" class="form-control">
                    <label for="username">Username</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="md-form mb-0 ">
                    <i  class="fa fa-envelope prefix"></i>
                    <input type="text" id="email" name="email" value="<?=$user->getEmail()?>" class="form-control">
                    <label for="email">Email</label>
                </div>
            </div>
        </div>
        <div class="text-center text-md-center">
            <button class="btn btn-outline-grey btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Modifier</button>
        </div>
        </form>
    </div>
    <hr>
    <div class="card card-body">
        <form accept-charset="UTF-8" action="/account/changepswd" method="post">
        <h4 class="card-title">Changer votre mot de passe</h4>
        <hr>
        <div class="md-form mb-0 ">
            <i class="fa fa-unlock prefix"></i>
            <input type="password" id="oldpassword" name="oldpassword" class="form-control">
            <label for="oldpassword" class="">Mot de passe actuel</label>
        </div>
        <div class="md-form mb-0">
            <i class="fa fa-lock prefix"></i>
            <input type="password" id="newpassword" name="newpassword" class="form-control">
            <label for="newpassword" class="">Nouveau mot de passe</label>
        </div>
        <div class="md-form mb-0">
            <i class="fa fa-lock prefix"></i>
            <input type="password" id="renewpassword" name="renewpassword" class="form-control">
            <label for="renewpassword" class="">Confirmation</label>
        </div>
        <div class="text-center text-md-center">
            <button class="btn btn-outline-grey btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Modifier</button>
        </div>
        </form>
    </div>
    <hr>
    <div class="card card-body">
        <h4 class="card-title"><i class="fa fa-cutlery"></i> Mes recettes</h4>
        <hr>
        <table id="myrecipes" class="table table-bordered table-striped">
            <thead>
            <tr>
                <td>Nom</td>
                <td>Auteur</td>
                <td><i class="fa fa-fire pr-1" aria-hidden="true"></i></td>
                <td><i class="fa fa-star pr-1" aria-hidden="true"></i></td>
                <td>Statut</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($myrecipes as $recipe) { ?>
                <tr>
                    <th>
                        <a href="/recipe/<?= $recipe->getId() ?>"><p class="m-0" style="color: #4389f7"><?= $recipe->getName() ?></p></a>
                    </th>
                    <th>
                        <?= $recipe->getAuthor()->getUsername() ?>
                    </th>
                    <th>
                        <?= $recipe->getNbBurn() ?>
                    </th>
                    <th>
                        <?= $recipe->getNbFav() ?>
                    </th>
                    <th>
                        <?php if($recipe->getStatus() == "public") {?>
                        <span class="badge green">PUBLIQUE
                        <?php } elseif($recipe->getStatus() == "limited") {  ?>
                        <span class="badge orange">LIMITÉE
                        <?php } elseif($recipe->getStatus() == "private") {  ?>
                        <span class="badge red">PRIVÉE
                        <?php } else { ?>
                        <span class="badge grey">BROUILLON
                        <?php } ?>
                    </th>
                    <th>
                        <a href="/recipe/<?= $recipe->getId() ?>/edit" class="btn btn-sm btn-primary"  style="padding: 7px"><span class="fa fa-edit"></span></a>
                        <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-<?= $recipe->getId() ?>" style="padding: 7px"><span class="fa fa-trash"></span></a>
                    </th>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
    <hr>
    <div class="card card-body">
        <h4 class="card-title"><i class="fa fa-star pr-1" aria-hidden="true"></i> Mes favoris</h4>
        <hr>
        <table id="favorites" class="table table-bordered table-striped">
            <thead>
            <tr>
                <td>Nom</td>
                <td>Auteur</td>
                <td><i class="fa fa-fire pr-1" aria-hidden="true"></i></td>
                <td><i class="fa fa-star pr-1" aria-hidden="true"></i></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($favorites as $recipe) { ?>
            <tr data-href="/recipe/<?=$recipe->getId()?>">
                <th>
                    <a href="/recipe/<?= $recipe->getId() ?>"><p class="m-0" style="color: #4389f7"><?= $recipe->getName() ?></p></a>
                </th>
                <th>
                    <?= $recipe->getAuthor()->getUsername() ?>
                </th>
                <th>
                    <?= $recipe->getNbBurn() ?>
                </th>
                <th>
                    <?= $recipe->getNbFav() ?>
                </th>
            </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal confirmation suppression recette -->
<?php foreach ($myrecipes as $recipe) { ?>
    <div class="modal fade" id="modal-<?= $recipe->getId() ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-notify modal-danger" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Supprimer la recette "<?=  $recipe->getName() ?>"</p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-trash fa-4x mb-3 animated rotateIn"></i>
                        <p>Êtes vous sûr de vouloir supprimer cette recette ?</p>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a href="/recipe/<?= $recipe->getId() ?>/delete" class="btn btn-outline-danger waves-effect">Supprimer</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
<?php } ?>
<!--/. Modal confirmation suppression recette -->
