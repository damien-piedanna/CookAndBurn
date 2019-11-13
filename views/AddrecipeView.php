<div class="container" style="min-height: calc(100vh - 157px)">
    <!--Section: Contact v.2-->
    <section class="section">
        <!--Section heading-->
        <h2 class="h1-responsive font-weight-bold text-center my-5">Ajouter une recette</h2>
        <!--Section description-->
        <p class="text-center w-responsive mx-auto mb-5">Avant de proposer une recette, vérifiez qu'elle n'ai pas déjà proposé sur le site. <br> Soyez clair, précis et concis.</p>
        <?php include 'views/assets/alert.php'; ?>
        <div class="row">

            <!--Grid column-->
            <div class="col-md-12 mb-md-0 mb-5">
                <form id="addrecipe" name="addrecipe" method="post" enctype="multipart/form-data" action="/recipe/add/proceed">

                    <!--Grid row-->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="md-form mb-0">
                                <input type="text" id="name" name="name" class="form-control">
                                <label for="name" class="">Nom de votre recette</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="md-form mb-0">
                                <input type="number" id="nbPers" name="nbPers" class="form-control">
                                <label for="nbPers" class="">Nombre de convive</label>
                            </div>
                        </div>
                        <div style="padding-top: 40px" class="col-md-2">
                            <div class="custom-control custom-checkbox">
                                <input type="hidden" name="status" value="public">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" value="private" checked="false">
                                <label class="custom-control-label" for="status">Privée</label>
                            </div>
                        </div>
                    </div>
                    <!--Grid row-->

                    <!--Grid row-->
                    <div class="row" style="padding-top: 25px">
                        <div class="col-md-12">
                            <div class="input-group mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Photo de la recette</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="imgrecipe" id="imgrecipe" aria-describedby="inputGroupFileAddon01" accept="image/png, image/jpeg, image/jpg">
                                    <label class="custom-file-label" for="inputGroupFile01">(conseillé)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Grid row-->

                    <!--Grid row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form mb-0">
                                <input type="text" id="shortDesc" name="shortDesc" class="form-control">
                                <label for="shortDesc" class="">Courte description</label>
                            </div>
                        </div>
                    </div>
                    <!--Grid row-->

                    <!--Grid row-->
                    <div class="row">

                        <!--Grid column-->
                        <div class="col-md-12">

                            <div class="md-form">
                                <textarea type="text" id="longDesc" name="longDesc" rows="2" class="form-control md-textarea"></textarea>
                                <label for="longDesc">Description</label>
                            </div>

                        </div>
                    </div>
                    <!--Grid row-->
                    <div class="list_ing"></div>
                    <!--Grid row-->
                    <div class="row">

                        <!--Grid column-->
                        <div class="col-md-4" style="padding-right: 0px">
                            <div style="padding-top: 35px;">
                                <select style="width: 100%" class="ingredient form-control" id="ingredient">
                                    <option></option>
                                    <?php foreach ($categories as $categorie) {?>
                                    <optgroup label="<?= $categorie ?>">
                                        <?php foreach ($ingredients as $ingredient) {
                                            if($ingredient->getCategory() == $categorie) { ?>
                                                <option value="<?= $ingredient->getId() ?>" label="<?= $ingredient->getName() ?>"><?= $ingredient->getName()?></option>
                                            <?php }}}?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1" style="padding: 0px">
                            <div class="text-center text-md-left" style="padding-top: 27px; padding-right: 50px">
                                <button data-toggle="modal" data-target="#modaladdingredient" type="button" class="btn btn-outline-success waves-effect" style="padding: 5px"><i class="fa fa-plus prefix"></i></button>
                            </div>
                        </div>
                        <div class="col-md-5" style="padding-left: 0px">
                            <div class="md-form mb-0">
                                <input type="text" id="quantity" class="form-control">
                                <label for="quantity" class="">Quantité (ex: 2 kilos, 1 cuillère...)</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-center text-md-left">
                                <button type="button" class="btn btn-outline-success waves-effect" onclick="getIngredientInfo()"><i class="fa fa-plus prefix"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="list_steps"></div>
                    <!--Grid row-->
                    <div class="row">
                        <div class="col-md-10">
                            <div class="md-form mb-0">
                                <input type="text" id="step" class="form-control">
                                <label for="step" class="">Étape</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="text-center text-md-left">
                                <button type="button" class="btn btn-outline-success waves-effect" onclick="getStepInfo()"><i class="fa fa-plus prefix"></i></button>
                            </div>
                        </div>
                    </div>
                        <!--Grid row-->
                    <input type="hidden" name="ingredients" id="ingredients">
                    <input type="hidden" name="steps" id="steps">
                    <input type="hidden" name="isPublished" id="isPublished">
                    <div class="text-center text-md-center">
                        <a class="btn btn-primary" onclick="save_add()">Sauvegarder</a>
                        <a class="btn btn-primary" onclick="publish_add()">Publier</a>
                    </div>
                </form>
                <div class="status"></div>
            </div>
            <!--Grid column-->
        </div>
    </section>
    <!--Section: Contact v.2-->
</div>

<div class="modal fade" id="modaladdingredient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Proposer un ingrédient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form accept-charset="UTF-8" action="/recipe/addingredient" method="post" enctype="multipart/form-data">
                    <p>Avant de proposer un ingrédient, verifier qu'il ne se trouve pas dans la liste. Une fois proposé il se trouvera dans la catégorie "temporaire" jusqu'à la validation par la modération.</p>
                    <hr>
                    <div class="md-form mb-0">
                        <i class="fa fa-tag prefix"></i>
                        <input type="text" id="name-add" name="name-add" class="form-control">
                        <label for="name-add">Nom de l'ingrédient</label>
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
            </div>
            <div class="modal-footer d-flex justify-content-center button-modal">
                <button class="btn btn-indigo" type="submit">Proposer</button>
            </div>
            <input type="hidden" name="previousurl" id="previousurl" value="/recipe/add">
            </form>
        </div>
    </div>
</div>