<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar">
    <div class="container">

        <!-- Brand -->
        <a href="<?= URL ?>"><img src="http://image.noelshack.com/fichiers/2018/45/1/1541412836-logo.png" alt="logo" style="height: 35px;"></a>
        <a class="navbar-brand" href="<?= URL ?>" style="padding-left: 1vw">
            <strong>Cook & Burn</strong>
        </a>


        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                </li>
            </ul>

            <!-- Right -->
            <ul class="navbar-nav nav-flex-icons">
                <li class="nav-item">
                    <form class="form-inline ml-auto" action="/search" method="post">
                        <div class="md-form my-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search" name="research">
                        </div>
                    </form>
                </li>
                <?php
                if($_SESSION['logged']) {
                    ?>
                    <li class="nav-item">
                        <a style="color: white; margin-right: 10px" href="/recipe/add" class="nav-link border border-light rounded">
                            <i class="fa fa-plus"></i> Ajouter recette
                        </a>
                    </li>


                    <?php if($_SESSION['role'] == "Admin") {?>
                        <li class="nav-item">
                            <a style="color: white; margin-right: 10px" href="/account" class="nav-link border border-light rounded">
                                <i class="fa fa-user"></i> <?=$_SESSION['username']?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link border border-light rounded">
                                <i class="fa fa-cogs"></i> Dashboard
                            </a>
                        </li>
                    <?php } else {?>
                        <li class="nav-item">
                            <a href="/account" class="nav-link border border-light rounded">
                                <i class="fa fa-user"></i> <?=$_SESSION['username']?>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a href="/login/logout" class="nav-link">
                            <i class="fa fa-sign-out"></i>
                        </a>
                    </li>
                <?php } else {?>
                    <li class="nav-item">
                        <a href="/login" class="nav-link border border-light rounded">
                            <i class="fa fa-user"></i>Connexion
                        </a>
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>
</nav>
<!-- Navbar -->

<!--Carousel Wrapper-->
<div id="carousel-example-1z" class="carousel slide carousel-fade" data-ride="carousel">

    <!--Indicators-->
    <ol class="carousel-indicators">
        <li data-target="#carousel-example-1z" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-1z" data-slide-to="1"></li>
        <li data-target="#carousel-example-1z" data-slide-to="2"></li>
    </ol>
    <!--/.Indicators-->

    <!--Slides-->
    <div class="carousel-inner" role="listbox">

        <?php
        $images = array(
            'https://i.imgur.com/Coe9DfI.jpg',
            'https://i.imgur.com/da7QxD9.jpg',
            'https://i.imgur.com/qSz63WS.jpg'
        );
        $isFirst = true;

        foreach ($images as $image)
        {

            ?>
            <!--slide-->
            <div class="carousel-item <?php if($isFirst) echo 'active';?>">
                <div class="view" style="background-image: url(<?= $image ?>); background-repeat: no-repeat; background-size: cover;">

                    <!-- Mask & flexbox options-->
                    <div class="mask rgba-black-light d-flex justify-content-center align-items-center">

                        <!-- Content -->
                        <div class="text-center white-text mx-5">
                            <h1 style="text-shadow: 2px 2px 2px black; font-size:50px">
                                <strong>Goûter, partager, créer</strong>
                            </h1>
                            <p style="text-shadow: 2px 2px 2px black; font-size:20px">
                                <strong>Cook&Burn est un site communautaire permettant à ses utilisateurs de consulter, de créer des recettes et de les partager au monde entier</strong>
                            </p>
                        </div>
                        <!-- Content -->
                    </div>
                    <!-- Mask & flexbox options-->
                </div>
            </div>
            <!--/slide-->
            <?php
            $isFirst = false;
        }
        ?>
    </div>
    <!--/.Slides-->

    <!--Controls-->
    <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    <!--/.Controls-->
</div>
<!--/.Carousel Wrapper-->
</header>

<!--Main layout-->
<main>
    <?php if (file_exists ( "views/assets/theme/" . $theme . ".php")) {
        include("views/assets/theme/" . $theme . ".php");
    } ?>
    <div class="container" style="background-color: white">
        <?php

        if($toprecipe) { ?>

        <h3 style="padding-top: 20px" class="h3 text-center mb-5"><i class="fa fa-star"></i> Recette du moment <i class="fa fa-star"></i></h3>
        <!--Section: Main info-->
        <section class="mt-5">

            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-6 mb-4">
                    <div class="view view-cascade overlay" style="max-height: 250px">
                        <img height="300" width="700"  src="<?=$toprecipe->getImg()?>"
                             class="img-fluid wp-post-image">
                        <a id="thumb_54101" href="/recipe/<?=$toprecipe->getId()?>">
                            <div class="mask rgba-white-slight waves-effect waves-light"></div>
                        </a>
                    </div>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6 mb-4">

                    <!-- Main heading -->
                    <h3 class="h3 mb-3"><a style="padding-left: 0px; color: #424242 " href="/recipe/<?=$toprecipe->getId()?>" class="nav-link"><?=$toprecipe->getName()?></a></h3>
                    <p style="text-align: justify"> <?=$toprecipe->getShortDesc()?> </p>
                    <!-- Main heading -->

                    <hr>
                    <div class="container" style="padding: 0">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <p style="font-size : 17px;">
                                    <i class="fa fa-pencil"></i> <?=$toprecipe->getAuthor()->getUsername()?><br>
                                    <i class="fa fa-clock-o"></i> <?=$toprecipe->getDate()?>
                                </p>

                            </div>
                            <div class="p-2 bd-highlight">
                                <p style="font-size : 25px;"><?=$toprecipe->getNbBurn()?></p>
                            </div>
                            <div class="p-2 bd-highlight">
                                <i style="font-size : 28px;" class="fa fa-fire"></i>
                            </div>
                            <div class="p-2 bd-highlight">
                                <p style="font-size : 25px;"><?=$toprecipe->getNbFav()?></p>
                            </div>
                            <div class="p-2 bd-highlight">
                                <i style="font-size : 28px;" class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

        </section>
        <!--Section: Main info-->
        <?php } ?>

        <hr class="my-5">

        <?php

        if(!empty($recipes))
        {
            for ($i = 0; $i < sizeof($recipes); $i++)
            {

                if ($i % 2 == 0) {
                    echo '<div class="row">';
                }
                ?>
                <div class="col-md-6 mb-4">
                    <!--Card-->
                    <div class="card card-cascade narrower card-ecommerce" style="min-height: 500px;max-height: 500px">
                        <!--Card image-->
                        <div class="view view-cascade overlay" style="background-image: url(<?=$recipes[$i]->getImg()?>); background-size: cover; min-height:300px">


                            <a id="thumb_54101" href="/recipe/<?=$recipes[$i]->getId()?>">

                                <div class="mask rgba-white-slight waves-effect waves-light"></div>
                            </a>
                        </div>
                        <!--/.Card image-->

                        <!--Card content-->
                        <div class="card-body card-body-cascade text-center">
                            <!--Category & Title-->
                            <h4 class="card-title"><strong><a style="color: #424242" href="/recipe/<?=$recipes[$i]->getId() ?>"><?=$recipes[$i]->getName() ?></a></strong></h4>

                            <!--Description-->
                            <p class="card-text"></p>
                            <p><?=$recipes[$i]->getShortDesc() ?></p>
                        </div>
                        <!-- Card footer -->
                        <div style="background-color:#424242" class="rounded-bottom text-center pt-3">
                            <ul class="list-unstyled list-inline font-small">
                                <li class="list-inline-item pr-2 white-text"><i class="fa fa-pencil pr-1"></i><?=$recipes[$i]->getAuthor()->getUsername()?></li>
                                <li class="list-inline-item pr-2 white-text"><i class="fa fa-clock-o pr-1"></i><?=$recipes[$i]->getDate()?></li>
                                <?php if($recipes[$i]->getisBurned()) { ?>
                                    <li class="list-inline-item pr-2 red-text"><i class="fa fa-fire pr-1"> </i><?=$recipes[$i]->getNbBurn()?></li>
                                <?php } else { ?>
                                    <li class="list-inline-item pr-2 white-text"><i class="fa fa-fire pr-1"> </i><?=$recipes[$i]->getNbBurn()?></li>
                                <?php } if($recipes[$i]->getisFav()) { ?>
                                    <li class="list-inline-item pr-2 red-text"><i class="fa fa-star pr-1"></i><?=$recipes[$i]->getNbFav()?></li>
                                <?php } else { ?>
                                    <li class="list-inline-item pr-2 white-text"><i class="fa fa-star pr-1"></i><?=$recipes[$i]->getNbFav()?></li>
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
        ?>
    </div>

    <?php if($nbpage > 1) { ?>

    <!--Pagination -->
    <div style="background-color: white">
        <hr class="my-5">
        <nav aria-label="pagination">
            <ul  class="pagination pagination-circle pg-dark mb-0 justify-content-center">

                <!--First-->
                <li class="page-item <?php if($page == 1) echo 'disabled'?>"><a class="page-link" href="/1">Premère</a></li>

                <!--Arrow left-->
                <li class="page-item <?php if($page == 1) echo 'disabled'?>">
                    <a class="page-link" href="/<?=$page - 1?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>


                <?php if($page == 1){ ?>
                    <li class="page-item active"><a class="page-link" href="/1">1</a></li>
                    <?php if($page + 1 <= $nbpage) { ?>
                        <li class="page-item"><a class="page-link" href="/2">2</a></li>
                    <?php } if($page + 2 <= $nbpage) { ?>
                        <li class="page-item"><a class="page-link" href="/3">3</a></li>
                    <?php } if($page + 3 <= $nbpage) { ?>
                        <li class="page-item"><a class="page-link" href="/4">4</a></li>
                    <?php } if($page + 4 <= $nbpage) { ?>
                        <li class="page-item"><a class="page-link" href="/5">5</a></li>
                    <?php } ?>
                <?php } elseif($page == 2) {?>
                        <li class="page-item"><a class="page-link" href="/1">1</a></li>
                        <li class="page-item active"><a class="page-link" href="/2">2</a></li>
                    <?php if($page + 1 <= $nbpage) { ?>
                        <li class="page-item"><a class="page-link" href="/3">3</a></li>
                    <?php } if($page + 2 <= $nbpage) { ?>
                        <li class="page-item"><a class="page-link" href="/4">4</a></li>
                    <?php } if($page + 3 <= $nbpage) { ?>
                        <li class="page-item"><a class="page-link" href="/5">5</a></li>
                    <?php } ?>
                <?php } elseif($page == $nbpage - 1) {?>
                <?php if($page - 3 > 0) { ?>
                        <li class="page-item"><a class="page-link" href="/<?=$nbpage - 4?>"><?=$nbpage - 4?></a></li>
                <?php } if($page - 2 > 0) { ?>
                        <li class="page-item"><a class="page-link" href="/<?=$nbpage - 3?>"><?=$nbpage - 3?></a></li>
                <?php } if($page - 1 > 0) { ?>
                        <li class="page-item"><a class="page-link" href="/<?=$nbpage - 2?>"><?=$nbpage - 2?></a></li>
                <?php } ?>
                        <li class="page-item active"><a class="page-link" href="/<?=$nbpage - 1?>"><?=$nbpage - 1?></a></li>
                        <li class="page-item"><a class="page-link" href="/<?=$nbpage?>"><?=$nbpage?></a></li>
                <?php } elseif($page == $nbpage) {?>
                    <?php if($page - 4 > 0) { ?>
                        <li class="page-item"><a class="page-link" href="/<?=$nbpage - 4?>"><?=$nbpage - 4?></a></li>
                    <?php } if($page - 3 > 0) { ?>
                        <li class="page-item"><a class="page-link" href="/<?=$nbpage - 3?>"><?=$nbpage - 3?></a></li>
                    <?php } if($page - 2 > 0) { ?>
                        <li class="page-item"><a class="page-link" href="/<?=$nbpage - 2?>"><?=$nbpage - 2?></a></li>
                    <?php } if($page - 1 > 0) { ?>
                        <li class="page-item"><a class="page-link" href="/<?=$nbpage - 1?>"><?=$nbpage - 1?></a></li>
                    <?php } ?>
                        <li class="page-item active"><a class="page-link" href="/<?=$nbpage?>"><?=$nbpage?></a></li>
                <?php } else { ?>
                        <li class="page-item"><a class="page-link" href="/<?=$page - 2?>"><?=$page - 2?></a></li>
                        <li class="page-item"><a class="page-link" href="/<?=$page - 1?>"><?=$page - 1?></a></li>
                        <li class="page-item active"><a class="page-link" href="/<?=$page?>"><?=$page?></a></li>
                        <li class="page-item"><a class="page-link" href="/<?=$page + 1?>"><?=$page + 1?></a></li>
                        <li class="page-item"><a class="page-link" href="/<?=$page + 2?>"><?=$page + 2?></a></li>
                <?php } ?>

                <!--Arrow right-->
                <li class="page-item <?php if($page == $nbpage) echo 'disabled'?>">
                    <a class="page-link" href="/<?=$page + 1?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>

                <!--Last-->
                <li class="page-item <?php if($page == $nbpage) echo 'disabled'?>"><a class="page-link" href="/<?=$nbpage?>">Dernière</a></li>

            </ul>
        </nav>
        <?php } ?>
    </div>
</main>
<!--Main layout-->