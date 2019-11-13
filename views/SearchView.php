<main>
    <div class="container" style="min-height: calc(100vh - 157px); background-color: white">
        <?php
        $research = str_replace('-', ' ', $research);
        if(!empty($results)) { ?>
            <div style="text-align: center; text-shadow: 1px 1px 1px black; font-size:20px; margin-bottom: 1.5vw">
                    <?=count($results)?> résultats pour "<?=$research?>"
            </div>
                <?php
                    for ($i = 0; $i < sizeof($results); $i++)
                    {
                        $recipe = $results[$i]->getRecipe();
                        if ($i % 2 == 0) {
                            echo '<div class="row">';
                        }
                        ?>
                        <div class="col-md-6 mb-4">
                            <!--Card-->
                            <div class="card card-cascade narrower card-ecommerce"
                                 style="min-height: 525px;max-height: 525px">
                                <!--Card image-->
                                <div class="view view-cascade overlay"
                                     style="background-image: url(<?= $recipe->getImg() ?>); background-size: cover; min-height:300px">

                                    <a id="thumb_54101" href="/recipe/<?= $recipe->getId() ?>">

                                        <div class="mask rgba-white-slight waves-effect waves-light"></div>
                                    </a>
                                </div>
                                <!--/.Card image-->

                                <!--Card content-->
                                <div class="card-body card-body-cascade text-center">
                                    <!--Category & Title-->
                                    <h4 class="card-title"><strong><a style="color: #424242"
                                                                      href="/recipe/<?= $recipe->getId() ?>"><?= $recipe->getName() ?></a></strong>
                                    </h4>


                                    <!--Description-->
                                    <p class="card-text"></p>
                                    <p><?= $recipe->getShortDesc() ?></p>

                                    <?php
                                        if (count($results[$i]->getMissingWords()) > 0)
                                        {
                                            echo '<p style="margin: 0; color: #4389f7">';
                                            foreach ($results[$i]->getMissingWords() as $key=>$word)
                                            {
                                                echo "<s>". $word . "</s>";
                                                if($key != count($results[$i]->getMissingWords())-1)
                                                    echo ", ";
                                            }
                                            echo '</p>';
                                        }
                                    ?>
                                </div>
                                <!-- Card footer -->
                                <div style="background-color:#424242" class="rounded-bottom text-center pt-3">
                                    <ul class="list-unstyled list-inline font-small">
                                        <li class="list-inline-item pr-2 white-text"><i
                                                    class="fa fa-pencil pr-1"></i><?= $recipe->getAuthor()->getUsername() ?></li>
                                        <li class="list-inline-item pr-2 white-text"><i
                                                    class="fa fa-clock-o pr-1"></i><?= $recipe->getDate() ?></li>
                                        <?php if ($recipe->getisBurned()) { ?>
                                            <li class="list-inline-item pr-2 red-text"><i
                                                        class="fa fa-fire pr-1"> </i><?= $recipe->getNbBurn() ?></li>
                                        <?php } else { ?>
                                            <li class="list-inline-item pr-2 white-text"><i
                                                        class="fa fa-fire pr-1"> </i><?= $recipe->getNbBurn() ?></li>
                                        <?php }
                                        if ($recipe->getisFav()) { ?>
                                            <li class="list-inline-item pr-2 red-text"><i
                                                        class="fa fa-star pr-1"></i><?= $recipe->getNbFav() ?></li>
                                        <?php } else { ?>
                                            <li class="list-inline-item pr-2 white-text"><i
                                                        class="fa fa-star pr-1"></i><?= $recipe->getNbFav() ?></li>
                                        <?php } ?>

                                    </ul>
                                </div>
                            </div>
                            <!--/.Card-->
                        </div>
                        <?php
                        if ($i % 2 != 0) {
                            echo '</div>';
                        }
                    }
                }

        else { ?>
            <div style="padding-left: 20%; padding-right: 20%">
                <img style="width: 50vw" height="444" src="https://toppng.com/public/uploads/preview/loupe-11530931588gthfjqpmes.png" alt="aucun resultat">
                <div s1tyle="text-align: center; font-size:20px">
                    Aucun resultat pour "<?= $research ?>".<br>
                    Essayez d'utiliser des mots-clefs plus larges et de vérifier l'orthographe.
                </div>
            </div>
        <?php } ?>
    </div>
</main>