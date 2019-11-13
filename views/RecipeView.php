<!-- Img + title -->
<div class="general" style="position:relative; height: 25vw; margin-top: -24px; background-image: url(<?=$recipe->getImg()?>); background-size: cover; min-height:120px">
    <div class="text-center white-text">
        <p style="text-shadow: 4px 4px 4px black; font-size:4vw; padding-top: 50px; margin-bottom: 0px;">
            <strong><?= $recipe->getName() ?></strong>
        </p>
        <p style="text-shadow: 3px 3px 3px black; font-size:3vw">
            par <?= $recipe->getAuthor()->getUsername() ?>
        </p>
    </div>
</div>
<!-- /Img + title -->
<!-- Ingredients + Desc + Steps -->
<div class="container" style="margin-top: 15px; padding: 0px">
    <!-- As a heading -->
    <div class="text-center py-2" style="background-color: orange;">
        <?php if ($recipe->getisBurned()): ?>
            <a href="/recipe/<?= $recipe->getId()?>/unburn">
                <button  type="button" class="btn btn-outline-black btn-md my-2 my-sm-0">
                    <i class="fa fa-fire  pr-1" aria-hidden="true" style="color: black"></i><?=$recipe->getNbBurn()?>
                </button>
            </a>
        <?php else: ?>
            <a href="/recipe/<?= $recipe->getId()?>/burn">
                <button  type="button" class="btn btn-outline-white btn-md my-2 my-sm-0">
                    <i class="fa fa-fire pr-1" aria-hidden="true"></i><?=$recipe->getNbBurn()?>
                </button>
            </a>
        <?php endif ?>
        <?php if ($recipe->getisFav()): ?>
            <a href="/recipe/ <?= $recipe->getId()?>/unfav">
                <button  type="button" class="btn btn-outline-black btn-md my-2 my-sm-0">
                    <i class="fa fa-star pr-1" aria-hidden="true" style="color: black"></i><?=$recipe->getNbFav()?>
                </button>
            </a>
        <?php else: ?>
            <a href="/recipe/<?= $recipe->getId()?>/fav">
                <button  type="button" class="btn btn-outline-white btn-md my-2 my-sm-0">
                    <i class="fa fa-star pr-1" aria-hidden="true"></i><?=$recipe->getNbFav()?>
                </button>
            </a>
        <?php endif ?>
        <a id="facebook">
            <button  type="button" class="btn btn-outline-white btn-md my-2 my-sm-0">
                <i class="fa fa-facebook pr-1" aria-hidden="true"></i>Partager
            </button>
        </a>
        <a id="twitter">
            <button  type="button" class="btn btn-outline-white btn-md my-2 my-sm-0">
                <i class="fa fa-twitter pr-1" aria-hidden="true"></i>Partager
            </button>
        </a>
        <?php if($recipe->getAuthor()->getId() == $_SESSION['id'] || $_SESSION['role'] == "Admin") { ?>
             <a href="/recipe/<?= $recipe->getId() ?>/edit">
                <button  type="button" class="btn btn-outline-white btn-md my-2 my-sm-0">
                    <i class="fa fa-edit pr-1" aria-hidden="true"></i>Modifier
                </button>
            </a>
            <a data-toggle="modal" data-target="#modal_delete_recipe">
                <button  type="button" class="btn btn-outline-white btn-md my-2 my-sm-0">
                    <i class="fa fa-trash pr-1" aria-hidden="true"></i>Supprimer
                </button>
            </a>
        <?php } ?>

    </div>
    <div class="row">
        <div class="col-md-4" style="margin-top: 30px;">
            <!--Ingredients-->
            <div class="card card-body" style="background-color: #f8f8f8; min-height: 100%">
                <h4 class="card-title text-center dark-text"><strong>Ingrédients</strong></h4>
                <h6 class="text-center dark-text">(pour <?=$recipe->getNbPers()?> personne<?php if ($recipe->getNbPers() > 1) echo 's'?>)</h6>
                <hr>
                <ul style="padding-left: 0px">
                    <?php foreach($recipe->getCompositions() as $composition) {?>
                    <li style="text-align: left; list-style-type:none">
                        <img src="<?= $composition['ingredient']->getImg() ?>" alt="<?=$composition['ingredient']->getName() ?>" height="48">
                        <?php if($composition['ingredient']->getCategory() == "Non vérifié") {
                            echo  "[Non vérifié] " . $composition['ingredient']->getName() . " (" . $composition['quantity'] . ")";
                        } else {
                            echo  " " . $composition['ingredient']->getName() . " (" . $composition['quantity'] . ")";
                        } ?>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <!--/Ingredients-->
        </div>
        <div class="col-md-8" style="margin-top: 30px;">
            <!--Desc-->
            <div class="card card-body" style="background-color: #f8f8f8; margin-bottom: 30px;">
                <h4 class="card-title text-center dark-text mx-5"><strong>Description</strong></h4>
                <hr>
                <p style="text-align: justify"><?=$recipe->getLongDesc() ?> </p>
            </div>
            <!--/Desc-->
            <!--Steps-->
            <div class="card card-body" style="background-color: #f8f8f8">
                <h4 class="card-title text-center dark-text mx-5"><strong>Etapes</strong></h4>
                <hr>
                <?php
                $steps = explode('@',$recipe->getSteps());
                foreach($steps as $key => $step)
                {?>
                    <p style="color: #FFA500; margin-bottom: 0px">Etape <?= $key+1 ?> :</p>
                    <p><?= $step ?></p>
                <?php } ?>
                <hr>
                <?php if (!is_null($recipe->getAnnotation())) { ?>
                    <button id="add-note-button" type="button" class="btn btn-success px-1 py-1" style="display: none" onclick="addnote()"><i class="fa fa-plus lg" aria-hidden="true"></i> Ajouter une note</button>
                    <span id="note">Note : <?= $recipe->getAnnotation() ?> <button type="button" class="btn btn-info px-1 py-1" onclick="addnote()"><i class="fa fa-edit lg" aria-hidden="true"></i></button></span>
                    <input id="note-edit" type="text" class="form-control" style="display: none">
                <?php } elseif ($_SESSION['logged']) { ?>
                    <button id="add-note-button" type="button" class="btn btn-success px-1 py-1" onclick="addnote()"><i class="fa fa-plus lg" aria-hidden="true"></i> Ajouter une note</button>
                    <input id="note-edit" type="text" class="form-control" style="display: none">
                    <span id="note" style="display:none"></span>
                <?php } ?>
                <form id="annotate" method="post" enctype="multipart/form-data" action="/recipe/<?=$recipe->getId()?>/annotate">
                    <input type="hidden" name="oldannotation" id="oldannotation" value="<?= $recipe->getAnnotation() ?>">
                    <input type="hidden" name="annotation" id="annotation">
                </form>
            </div>
            <!--/Steps-->
        </div>
    </div>
<!-- /Ingredients + Desc + Steps -->
</div>
<!-- Modal confirmation suppression recette -->
<div class="modal fade" id="modal_delete_recipe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<!--/. Modal confirmation suppression recette -->

<script type="text/javascript">
    var name = "<?= $recipe->getName() ?>";
    var url = "<?= URL . 'recipe/' . $recipe->getId() ?>";
</script>