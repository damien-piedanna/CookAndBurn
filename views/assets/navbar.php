<header style="margin-bottom: 80px;">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark  top-nav-collapse">
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
                    <!-- Search form -->
                    <li class="nav-item">
                        <form class="form-inline ml-auto" action="/search" accept-charset="UTF-8" method="post">
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
</header>