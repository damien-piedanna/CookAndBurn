<!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?= $title?></title>
        <link rel="icon" href="/ressources/img/logo.ico">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <meta name="description" content="Cook & Burn est un site web de partage de recette entre utilisateurs fan de barbecue !">
        <meta name="keywords" content="barbecue, bbq, recette, partage, cook, burn, cook&burn, cookandburn">

        <?php if($view == 'Recipe' || $view == 'Login' && !is_null($data['recipe']))
        {
            //Balises pour la prévisualtion du lien de partage sur twitter et facebook
            ?>
            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:domain" content="cooknburng4.alwaysdata.net">
            <meta name="twitter:title" content="<?= $data['recipe']->getName() ?>">
            <meta name="twitter:description" content="<?= $data['recipe']->getShortDesc() ?>">
            <meta name="twitter:image" content="<?= $data['recipe']->getImg() ?>">

            <meta property="og:type" content="article">
            <meta property="og:url" content="<?= URL . 'recipe/' . $data['recipe']->getId() ?>">
            <meta property="og:title" content="<?= $data['recipe']->getName() ?>">
            <meta property="og:description" content="<?= $data['recipe']->getShortDesc() ?>">
            <meta property="og:image" content="<?= $data['recipe']->getImg() ?>">
        <?php } ?>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/css/mdb.min.css" rel="stylesheet">
        <!-- Select 2 -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <!-- dataTable -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/datatables.min.css"/>
        <!-- Css global -->
        <link href="/ressources/css/Global.css" rel="stylesheet"/>

        <!-- Css spécifique à une page -->
        <?php  $file = "/ressources/css/" . $view . ".css";?>
        <link href="<?=$file?>" rel="stylesheet"/>
    </head>
    <body>
        <?php
            if ($view == 'Index') //Cas spécial
            {
                echo $content;
            }
            else
            {
                include 'navbar.php';
                echo $content;
            }
            include 'footbar.php';
        ?>

        <!-- SCRIPTS -->
        <!-- JQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/js/mdb.min.js"></script>
        <!-- Select 2 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <!-- dataTable -->
        <script src="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/datatables.min.js"></script>

        <!-- JS spécifique à une page -->
        <?php $file = "/ressources/js/" . $view . ".js"; ?>
        <script src="<?=$file?>"></script>
        <?php  if ($view == 'Editrecipe') { ?>
            <script src="/ressources/js/Addrecipe.js"></script>
        <?php } ?>

        <!-- JS global -->
        <script src="/ressources/js/Global.js"></script>
    </body>
</html>