<div style="min-height: calc(100vh - 157px)">
    <div class="container">
        <?php include 'views/assets/alert.php'; ?>
        <?php if($ingtemp > 0) { ?>
            <div class="alert alert-warning alert-dismissible fade show" style="margin-top: 10px" role="alert">
                <strong><?= $ingtemp ?></strong>  ingrédient<?php if ($ingtemp > 1) echo 's sont'; else echo ' est';?> en attente de validation.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
        <!-- STATS BOX -->
        <div class="row">
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-cutlery"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Recettes</span>
                        <span class="info-box-number"><?= count($recipes) ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Membres</span>
                        <span class="info-box-number"><?= count($users) ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fa fa-italic"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Ingrédients</span>
                        <span class="info-box-number"><?= count($ingredients) ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-heart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Burns</span>
                        <span class="info-box-number"><?= $nbburns ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- FIN STATS BOX -->
        <hr>
        <div class="card card-body">
            <h4 class="card-title"><i class="fa fa-gear"></i> Configuration</h4>
            <hr>
            <form accept-charset="UTF-8" action="/dashboard/editconfiguration" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <i class="fa fa-tag prefix"></i>
                            <input type="text" id="recipeperpage" name="recipeperpage" class="form-control" value="<?= $configuration->getRecipeperpage() ?>">
                            <label for="recipeperpage">Nombre de recette par page</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="md-form mb-0">
                            <i class="fa fa-tag prefix"></i>
                            <input type="text" id="theme" name="theme" class="form-control" value="<?= $configuration->getTheme() ?>">
                            <label for="theme">Theme (défaut -> default)</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="md-form mb-0">
                            <i class="fa fa-tag prefix"></i>
                            <input type="text" id="themeingredient" name="themeingredient" class="form-control" value="<?= $configuration->getThemeIngredient() ?>">
                            <label for="themeingredient">Ingrédient du thème</label>
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
            <h4 class="card-title"><i class="fa fa-cutlery"></i> Gestion des recettes</h4>
            <hr>
            <table id="recipes" class="table table-bordered table-striped">
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
                <?php foreach ($recipes as $recipe) { ?>
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
                            </span>
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
            <h4 class="card-title"><i class="fa fa-italic"></i> Gestion des ingrédients</h4>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="add-tab-ing" data-toggle="tab" href="#add-ing" role="tab" aria-controls="add-ing" aria-selected="true"><i class="fa fa-plus" style="color:green"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="edit-tab-ing" data-toggle="tab" href="#edit-ing" role="tab" aria-controls="edit-ing" aria-selected="false"><i class="fa fa-edit"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="delete-tab-ing" data-toggle="tab" href="#delete-ing" role="tab" aria-controls="delete-ing" aria-selected="false"><i class="fa fa-trash" style="color:red"></i></a>
                </li>
            </ul>
            <div class="tab-content" id="tab-ing">
                <div class="tab-pane fade show active" id="add-ing" role="tabpanel" aria-labelledby="add-tab-ing">
                    <form accept-charset="UTF-8" action="/dashboard/addingredient" method="post" enctype="multipart/form-data">
                        <div class="md-form mb-0">
                            <i class="fa fa-tag prefix"></i>
                            <input type="text" id="name-add" name="name-add" class="form-control">
                            <label for="name-add">Nom de l'ingrédient</label>
                        </div>
                        <div class="row">
                            <div style="padding-top: 32px;" class="col-md-6">
                                <select  style="width: 100%" class="type-add form-control" id="type-add" name="type-add">
                                    <option></option>
                                    <?php foreach ($categories as $categorie) {?>
                                        <option value="<?= $categorie ?>" label="<?= $$categorie ?>"><?= $categorie?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <i class="fa fa-folder prefix"></i>
                                    <input type="text" id="category-add" name="category-add" class="form-control">
                                    <label for="category-add">Ou créez en une nouvelle</label>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 25px;" class="input-group mb-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Icone de l'ingrédient</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imgaddingredient" id="imgaddingredient" aria-describedby="inputGroupFileAddon01" accept="image/png, image/jpeg, image/jpg">
                                <label class="custom-file-label" for="inputGroupFile01">(conseillé)</label>
                            </div>
                        </div>
                        <div class="text-center text-md-center">
                            <button class="btn btn-outline-grey btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Ajouter</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade show" id="edit-ing" role="tabpanel" aria-labelledby="edit-tab-ing">
                    <form accept-charset="UTF-8" action="/dashboard/editingredient" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div style="padding-top: 32px;" class="col-md-6">
                                <select  style="width: 100%" class="ing-edit form-control" id="ing-edit" name="ing-edit">
                                    <option></option>
                                    <?php foreach ($categories as $categorie) {?>
                                    <optgroup label="<?= $categorie ?>">
                                        <?php foreach ($ingredients as $ingredient) {
                                            if($ingredient->getCategory() == $categorie) { ?>
                                                <option value="<?= $ingredient->getId() ?>"><?= $ingredient->getName()?></option>
                                            <?php }}}?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <i class="fa fa-tag prefix"></i>
                                    <input type="text" id="name-edit" name="name-edit" class="form-control">
                                    <label for="name-edit">Nouveau nom</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div style="padding-top: 32px;" class="col-md-6">
                                <select  style="width: 100%" class="type-edit form-control" id="type-edit" name="type-edit">
                                    <option></option>
                                    <?php foreach ($categories as $categorie) {?>
                                        <option value="<?= $categorie ?>" label="<?= $$categorie ?>"><?= $categorie?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <i class="fa fa-folder prefix"></i>
                                    <input type="text" id="category-edit" name="category-edit" class="form-control">
                                    <label for="category-edit">Ou créez en une nouvelle</label>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 25px;" class="input-group mb-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon02">Icone de l'ingrédient</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imgeditingredient" id="imgeditingredient" aria-describedby="inputGroupFileAddon01" accept="image/png, image/jpeg">
                                <label class="custom-file-label" for="inputGroupFile02">(conseillé)</label>
                            </div>
                        </div>
                        <div class="text-center text-md-center">
                            <button class="btn btn-outline-grey btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Modifier</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="delete-ing" role="tabpanel" aria-labelledby="delete-tab-ing">
                    <form accept-charset="UTF-8" action="/dashboard/deleteingredient" method="post" enctype="multipart/form-data">
                        <div style="padding-top: 32px;">
                            <select  style="width: 100%" class="ing-delete form-control" id="ing-delete" name="ing-delete">
                                <option></option>
                                <?php foreach ($categories as $categorie) {?>
                                <optgroup label="<?= $categorie ?>">
                                    <?php foreach ($ingredients as $ingredient) {
                                        if($ingredient->getCategory() == $categorie) { ?>
                                            <option value="<?= $ingredient->getId() ?>"><?= $ingredient->getName()?></option>
                                        <?php }}}?>
                            </select>
                        </div>
                        <div class="text-center text-md-center">
                            <button type="button" class="btn btn-outline-grey btn-rounded btn-block my-4 waves-effect z-depth-0" data-toggle="modal" data-target="#modal-delete-ing">Supprimer</button>
                        </div>
                        <div class="modal fade" id="modal-delete-ing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-notify modal-danger" role="document">
                                <!--Content-->
                                <div class="modal-content">
                                    <!--Header-->
                                    <div class="modal-header">
                                        <p class="heading lead">Supprimer un ingrédient</p>

                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="white-text">&times;</span>
                                        </button>
                                    </div>

                                    <!--Body-->
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <i class="fa fa-trash fa-4x mb-3 animated rotateIn"></i>
                                            <p>Êtes vous sûr de vouloir supprimer cet ingrédient ?</p>
                                            <p>Il disparaitra de toutes les recettes qui l'utilisent et pourra alors les rendre obsolète.</p>
                                        </div>
                                    </div>

                                    <!--Footer-->
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" class="btn btn-outline-danger waves-effect">Supprimer</button>
                                    </div>
                                </div>
                                <!--/.Content-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <div class="card card-body">
            <h4 class="card-title"><i class="fa fa-group"></i> Gestion des utilisateurs</h4>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="add-tab-user" data-toggle="tab" href="#add-user" role="tab" aria-controls="add-user" aria-selected="true"><i class="fa fa-plus" style="color:green"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="edit-tab-user" data-toggle="tab" href="#edit-user" role="tab" aria-controls="edit-user" aria-selected="false"><i class="fa fa-edit"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="delete-tab-user" data-toggle="tab" href="#delete-user" role="tab" aria-controls="delete-user" aria-selected="false"><i class="fa fa-trash" style="color:red"></i></a>
                </li>
            </ul>
            <div class="tab-content" id="tab-user">
                <div class="tab-pane fade show active" id="add-user" role="tabpanel" aria-labelledby="add-tab-user">
                    <form accept-charset="UTF-8" action="/dashboard/adduser" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="md-form mb-0">
                                    <i class="fa fa-tag prefix"></i>
                                    <input type="text" id="username-add" name="username-add" class="form-control">
                                    <label for="username-add">Username</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-form mb-0">
                                    <i class="fa fa-envelope prefix"></i>
                                    <input type="text" id="email-add" name="email-add" class="form-control">
                                    <label for="email-add">Email</label>
                                </div>
                            </div>
                            <div style="padding-top: 32px;" class="col-md-4">
                                <select  style="width: 100%" class="role-add form-control" id="role-add" name="role-add">
                                    <option></option>
                                    <?php foreach ($roles as $role) {?>
                                        <option value="<?= $role ?>" label="<?= $role ?>"><?= $role ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="text-center text-md-center">
                            <button class="btn btn-outline-grey btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Ajouter</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade show" id="edit-user" role="tabpanel" aria-labelledby="edit-tab-user">
                    <form accept-charset="UTF-8" action="/dashboard/edituser" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div style="padding-top: 32px;" class="col-md-6">
                                <select  style="width: 100%" class="user-edit form-control" id="user-edit" name="user-edit">
                                    <option></option>
                                    <?php foreach ($roles as $role) {?>
                                    <optgroup label="<?= $role ?>">
                                        <?php foreach ($users as $user) {
                                            if($user->getRole() == $role) { ?>
                                                <option value="<?= $user->getEmail() ?>"><?= $user->getUsername()?></option>
                                            <?php }}}?>
                                </select>
                            </div>
                            <div style="padding-top: 32px;" class="col-md-6">
                                <select style="width: 100%" class="role-edit form-control" id="role-edit" name="role-edit">
                                    <option></option>
                                    <?php foreach ($roles as $role) {?>
                                        <option value="<?= $role ?>" label="<?= $role ?>"><?= $role ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <i class="fa fa-tag prefix"></i>
                                    <input type="text" id="username-edit" name="username-edit" class="form-control">
                                    <label for="username-edit">Username</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <i class="fa fa-envelope prefix"></i>
                                    <input type="text" id="email-edit" name="email-edit" class="form-control">
                                    <label for="email-edit">Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center text-md-center">
                            <button class="btn btn-outline-grey btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Modifier</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="delete-user" role="tabpanel" aria-labelledby="delete-tab-user">
                    <form accept-charset="UTF-8" action="/dashboard/deleteuser" method="post" enctype="multipart/form-data">
                        <div style="padding-top: 32px;">
                            <select  style="width: 100%" class="user-delete form-control" id="user-delete" name="user-delete">
                                <option></option>
                                <?php foreach ($roles as $role) {?>
                                <optgroup label="<?= $role ?>">
                                    <?php foreach ($users as $user) {
                                        if($user->getRole() == $role) { ?>
                                            <option value="<?= $user->getEmail() ?>"><?= $user->getUsername()?></option>
                                        <?php }}}?>
                            </select>
                        </div>
                        <div class="text-center text-md-center">
                            <button type="button" class="btn btn-outline-grey btn-rounded btn-block my-4 waves-effect z-depth-0" data-toggle="modal" data-target="#modal-delete-user">Supprimer</button>
                        </div>
                        <div class="modal fade" id="modal-delete-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-notify modal-danger" role="document">
                                <!--Content-->
                                <div class="modal-content">
                                    <!--Header-->
                                    <div class="modal-header">
                                        <p class="heading lead">Supprimer un utilisateur</p>

                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="white-text">&times;</span>
                                        </button>
                                    </div>

                                    <!--Body-->
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <i class="fa fa-trash fa-4x mb-3 animated rotateIn"></i>
                                            <p>Êtes vous sûr de vouloir supprimer cet utilisateur ?</p>
                                            <p>Toutes ses recettes seront supprimées, tout comme ses burns et favoris.</p>
                                        </div>
                                    </div>

                                    <!--Footer-->
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" class="btn btn-outline-danger waves-effect">Supprimer</button>
                                    </div>
                                </div>
                                <!--/.Content-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal confirmation suppression recette -->
<?php foreach ($recipes as $recipe) { ?>
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