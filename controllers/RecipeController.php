<?php

/**
 * Class RecipeController
 * S'occupe de tout ce qui concerne les recettes.
 */
class RecipeController extends Controller
{
    /**
     * RecipeController constructor.
     * @param $url string
     * @throws Exception
     */
    public function __construct($url)
    {
        if (count($url) == 2 && is_numeric($url[1]))
            $this->index(intval($url[1]));
        elseif (count($url) == 2 && $url[1] == "add")
            $this->add();
        elseif (count($url) == 3 && $url[1] == "add" && $url[2] == "proceed")
            $this->add_proceed();
        elseif (count($url) == 2 && $url[1] == "addingredient")
            $this->addingredient();
        elseif (count($url) == 3 && is_numeric($url[1]) && $url[2] == "edit")
            $this->edit(intval($url[1]));
        elseif (count($url) == 4 && is_numeric($url[1]) &&  $url[2] == "edit" && $url[3] == "proceed")
            $this->edit_proceed(intval($url[1]));
        elseif (count($url) == 3 && is_numeric($url[1]) && $url[2] == "delete")
            $this->delete_proceed(intval($url[1]));
        elseif (count($url) == 3 && is_numeric($url[1]) && $url[2] == "burn")
            $this->burn(intval($url[1]));
        elseif (count($url) == 3 && is_numeric($url[1]) && $url[2] == "fav")
            $this->fav(intval($url[1]));
        elseif (count($url) == 3 && is_numeric($url[1]) && $url[2] == "unburn")
            $this->unburn(intval($url[1]));
        elseif (count($url) == 3 && is_numeric($url[1]) && $url[2] == "unfav")
            $this->unfav(intval($url[1]));
        elseif (count($url) == 3 && is_numeric($url[1]) && $url[2] == "annotate")
            $this->annotate(intval($url[1]));
        else
            throw new Exception('Page introuvable.');
    }

    /**
     * Affiche une recette
     * @param $id int
     * @throws Exception
     */
    private function index($id)
    {
        $recipe = RecipeManager::getRecipe($id);

        //Si la recette n'existe pas.
        if(is_null($recipe))
        {
            throw new Exception('Cette recette n\'existe pas ou plus.');
        }
        //Si la recette n'est pas publique et l'utilisateur pas connecté.
        else if ($recipe->getStatus() != "public" && ($_SESSION['logged'] == null || !$_SESSION['logged']))
        {
            $_SESSION['error'] = "Vous devez être connecté pour visualiser cette recette.";
            parent::Redirect('/login/ask/' . $id);
        }
        //Si la recette est un brouillon ou privée et que l'utilisateur n'est pas l'auteur ou admin.
        else if (($recipe->getStatus() == "draft" || $recipe->getStatus() == "private") && $_SESSION['id'] != $recipe->getAuthor()->getId() && $_SESSION['role'] != "Admin")
        {
            throw new Exception('Vous n\'avez pas accès à cette recette.');
        }
        //Sinon on affiche la recette.
        else
        {
            $this->_view = new View('Recipe', 'Cook & Burn | ' . $recipe->getName(), array('recipe' => $recipe));
        }
    }

    /**
     * Affiche le formulaire d'ajout d'une recette.
     */
    private function add()
    {
        if($_SESSION['logged'])
        {
            $ingredients = IngredientManager::getIngredients();
            $categories = [];
            foreach ($ingredients as $ingredient)
            {
                if (!in_array($ingredient->getCategory(), $categories)) {
                    array_push($categories, $ingredient->getCategory());
                }
            }

            $this->_view = new View('Addrecipe', 'Cook & Burn | Ajouter une recette', array ('ingredients' => $ingredients, 'categories' => $categories));
        }
        else
        {
            $_SESSION['error'] = 'Merci de vous connecter pour ajouter une recette';
            parent::Redirect('/login/ask/addrecipe');
        }
    }

    /**
     * @param $post array[mixed] Valeur du formulaire
     * @param $redirect string Redirection en cas d'erreur.
     * @return array
     */
    private function getRecipeInfos($post, $redirect)
    {
        if(isset($_FILES['imgrecipe']) && $_FILES['imgrecipe']['error'] != UPLOAD_ERR_NO_FILE)
        {
            $size = getimagesize($_FILES['imgrecipe']['tmp_name']);
            if($size[0] < 700 || $size[1] < 300)
            {
                $_SESSION['error'] = "L'image de la recette doit être au format 700x300 minimum.";
                parent::Redirect($redirect);
            }
            $img = $this->UploadImg("imgrecipe");
            if(filter_var($img , FILTER_VALIDATE_URL) === false)
            {
                $_SESSION['error'] = "Le format de l'image est incorrect.";
                parent::Redirect($redirect);
            }
        }
        else
        {
            if(is_null($post['oldimg']))
                $img = "https://nsa39.casimages.com/img/2018/10/25/181025093619445545.jpg";
            else
                $img = $post['oldimg'];
        }

        $name = filter_var($post['name'], FILTER_SANITIZE_STRING);
        $nbPers = $post['nbPers'];
        $shortDesc = filter_var($post['shortDesc'], FILTER_SANITIZE_STRING);
        $longDesc = filter_var($post['longDesc'], FILTER_SANITIZE_STRING);
        $ingredients = explode('/', substr($post['ingredients'], 0, strlen($post['ingredients']) - 1)); //Est ici pour creer un tableau à partir de js
        $steps = filter_var(substr($post['steps'], 0, strlen($post['steps']) - 1), FILTER_SANITIZE_STRING);


        if (boolval($_POST['isPublished']))
            $status = $_POST['status'];
        else
            $status = "draft";

        if(strlen($name) < 5 || strlen($name) > 60)
        {
            $_SESSION['error'] = "Le nom de la recette doit contenir 5 à 60 caractères.";
            parent::Redirect($redirect);
        }
        if($status != 'draft')
        {
            if($nbPers < 1 || $nbPers > 1000)
            {
                $_SESSION['error'] = "Le nombre de convive doit être de 1 à 1000.";
                parent::Redirect($redirect);
            }
            if(strlen($shortDesc) < 10 || strlen($shortDesc) > 300)
            {
                $_SESSION['error'] = "La courte description doit contenir 10 à 300 caractères.";
                parent::Redirect($redirect);
            }
            if(strlen($longDesc) < 20 || strlen($longDesc) > 1500)
            {
                $_SESSION['error'] = "La description doit contenir 20 à 1500 caractères.";
                parent::Redirect($redirect);
            }
            if(count($ingredients,COUNT_RECURSIVE) < 1)
            {
                $_SESSION['error'] = "Votre recette doit contenir au moins 1 ingredient.";
                parent::Redirect($redirect);
            }
            if(strlen($steps) < 1)
            {
                $_SESSION['error'] = "Votre recette doit contenir au moins 1 étape.";
                parent::Redirect($redirect);
            }
        }

        $data = array('AUTHOR' => $_SESSION['id'], 'NAME' => $name, 'NBPERS' => $nbPers,  'IMG' => $img, 'SHORTDESC' => $shortDesc, 'LONGDESC' => $longDesc, 'STEPS' => $steps, 'STATUS' => $status);
        return [new Recipe($data), $ingredients];
    }

    /**
     * Ajoute une recette.
     */
    private function add_proceed()
    {
        $info = $this->getRecipeInfos($_POST, '/recipe/add');
        $idrecipe = RecipeManager::add($info[0]);

        //Ajout des ingredients sous forme de "composition"
        foreach ($info[1] as $ingredient)
        {
            $ingredient = explode(',', $ingredient);

            $data = array('IDRECIPE' => $idrecipe, 'IDINGREDIENT' => $ingredient[0], 'QUANTITY' => filter_var($ingredient[1], FILTER_SANITIZE_STRING));
            $composition = new Composition($data);

            CompositionManager::addComposition($composition);
        }

        parent::Redirect('/recipe/' . $idrecipe);
    }

    /**
     * Ajoute un ingrédient temporaire.
     */
    private function addIngredient()
    {
        $redirect = $_POST['previousurl'];

        if(isset($_FILES['imgaddingredient']) && $_FILES['imgaddingredient']['error'] != UPLOAD_ERR_NO_FILE)
        {
            $size = getimagesize($_FILES['imgaddingredient']['tmp_name']);
            if($size[0] != $size[1])
            {
                $_SESSION['error'] = "L'image de l'ingrédient doit être carrée.";
                parent::Redirect($redirect);
            }
            $img = $this->UploadImg('imgaddingredient');
            if(filter_var($img , FILTER_VALIDATE_URL) === false)
            {
                $_SESSION['error'] = "Le format de l'image est incorrect.";
                parent::Redirect($redirect);
            }
        }
        else
        {
            $img = "https://nsa39.casimages.com/img/2018/10/25/181025093618202082.png";
        }

        $name = filter_var($_POST['name-add'], FILTER_SANITIZE_STRING);
        if(strlen($name) < 3 || strlen($name) > 60)
        {
            $_SESSION['error'] = "Le nom de l'ingrédient doit contenir 3 à 60 caractères.";
            parent::Redirect($redirect);
        }

        $category = "Non vérifié";

        $ingredient = new Ingredient(array('NAME' => $name, 'CATEGORY' => $category,  'IMG' => $img));
        IngredientManager::add($ingredient);

        $_SESSION['success'] = "L'ingredient " . $name . " a été ajouté à la liste des ingrédients non vérifié.";
        parent::Redirect($redirect);
    }

    /**
     * Affiche le formulaire de modification d'une recette.
     * @param $id int Id de la recette
     */
    private function edit($id)
    {
        $recipe = RecipeManager::getRecipe($id);

        //Vérifie si la recette existe
        if(is_null($recipe))
        {
            parent::Redirect('/');
        }

        //Vérifie si l'utilisateur a le droit de modifier cette recette
        if($recipe->getAuthor()->getId() != $_SESSION['id'] && $_SESSION['role'] != "Admin")
        {
            parent::Redirect('/recipe/' . $id);
        }

        $ingredients = IngredientManager::getIngredients();
        $categories = [];
        foreach ($ingredients as $ingredient)
        {
            if (!in_array($ingredient->getCategory(), $categories)) {
                array_push($categories, $ingredient->getCategory());
            }
        }
        $stringredients = "";

        foreach ($recipe->getCompositions() as $composition)
        {
            $stringredients .= $composition['ingredient']->getId() . ',' . $composition['quantity'] . ',' . $composition['ingredient']->getName() . '/';
        }
        $stringredients = substr($stringredients, 0, strlen($stringredients) - 1);

        $this->_view = new View('Editrecipe', 'Cook & Burn | Modifier | ' . $recipe->getName(), array ('stringredients' => $stringredients, 'recipe' => $recipe, 'ingredients' => $ingredients, 'categories' => $categories));
    }

    /**
     * Modifie une recette.
     * @param $id int Id de la recette
     */
    private function edit_proceed($id)
    {
        $info = $this->getRecipeInfos($_POST, '/recipe/' . $id . '/edit');

        RecipeManager::edit($id, $info[0]);

        //Modification des ingredients sous forme de "composition"
        CompositionManager::deleteCompositions($id);
        foreach ($info[1] as $ingredient)
        {
            $ingredient = explode(',', $ingredient);

            $data = array('IDRECIPE' => $id, 'IDINGREDIENT' => $ingredient[0], 'QUANTITY' => filter_var($ingredient[1], FILTER_SANITIZE_STRING));
            $composition = new Composition($data);

            CompositionManager::addComposition($composition);
        }

        parent::Redirect('/recipe/' . $id);
    }

    /**
     * Supprime une recette.
     * @param $id int Id de la recette
     */
    private function delete_proceed($id)
    {
        $recipe = RecipeManager::getRecipe($id);

        if(is_null($recipe))
        {
            parent::Redirect('/');
        }

        //Vérifie si l'utilisateur a le droit de supprimer cette recette
        if($recipe->getAuthor()->getId() != $_SESSION['id'] && $_SESSION['role'] != "Admin")
        {
            parent::Redirect('/recipe/' . $id);
        }

        RecipeManager::delete($id);
        parent::Redirect('/account');
    }

    /**
     * Burn
     * @param $id int Id de la recette
     */
    private function burn($id)
    {
        if(is_null(RecipeManager::getRecipe($id)))
        {
            parent::Redirect('/');
        }
        elseif (!$_SESSION['logged'])
        {
            $_SESSION['error'] = 'Vous devez être connecté pour burn une recette.';
            parent::Redirect('/login/ask/' . $id);
        }
        else
        {
            RecipeManager::burn($id, $_SESSION['id']);
            parent::Redirect("/recipe/" . $id);
        }
    }

    /**
     * Met en favoris
     * @param $id int Id de la recette
     */
    private function fav($id)
    {
        if(is_null(RecipeManager::getRecipe($id)))
        {
            parent::Redirect('/');
        }
        elseif (!$_SESSION['logged'])
        {
            $_SESSION['error'] = 'Vous devez être connecté pour mettre une recette en favoris.';
            parent::Redirect('/login/ask/' . $id);
        }
        else
        {
            RecipeManager::fav($id, $_SESSION['id']);
            parent::Redirect("/recipe/" . $id);
        }
    }

    /**
     * Supprime le burn.
     * @param $id int Id de la recette
     */
    private function unburn($id)
    {
        if(is_null(RecipeManager::getRecipe($id)))
        {
            parent::Redirect('/');
        }
        else
        {
            if ($_SESSION['logged'])
                RecipeManager::unburn($id, $_SESSION['id']);
            parent::Redirect("/recipe/" . $id);
        }
    }

    /**
     * Supprime des favoris.
     * @param $id int Id de la recette
     */
    private function unfav($id)
    {
        if(is_null(RecipeManager::getRecipe($id)))
        {
            parent::Redirect('/');
        }
        else
        {
            if ($_SESSION['logged'])
                RecipeManager::unfav($id, $_SESSION['id']);
            parent::Redirect("/recipe/" . $id);
        }
    }

    /**
     * Annote une recette.
     * @param $id int Id de la recette
     */
    private function annotate($id)
    {
        $annotation = filter_var($_POST['annotation'], FILTER_SANITIZE_STRING);
        if($annotation == $_POST['oldannotation'])
            parent::Redirect("/recipe/" . $id);

        if(is_null(RecipeManager::getRecipe($id)))
        {
            parent::Redirect('/');
        }
        else
        {
            if ($_SESSION['logged'])
                RecipeManager::setAnnotation($id, $_SESSION['id'], $annotation);
        }
        parent::Redirect("/recipe/" . $id);
    }
}