<?php
require_once('SearchController.php');
/**
 * Class IndexController
 * Controller de l'index du site.
 */
class IndexController extends Controller
{
    /**
     * IndexController constructor.
     * @param $url
     * @throws Exception
     */
    public function __construct($url)
    {
        if(!is_null($url) && $url[0] == 1 || $url[0] == 'index')
            $this->Redirect('/');
        else if(!is_null($url) && count($url) == 1)
            $this->index($url[0]);
        else if (is_null($url))
            $this->index(1);
        else
            throw new Exception('Page introuvable');
    }

    /**
     * @param $page string Numéro de la page
     */
    private function index($page)
    {
        $theme = ConfigurationManager::get()->getTheme();

        
        $RecipePerPage = ConfigurationManager::get()->getRecipeperpage();
        $allrecipe = RecipeManager::getRecipes();

        //TOP RECETTE
        if($theme != "default") //Si il y a un thème actif
        {
            //On prend la recette la plus pertinente assoscié à l'ingrédient du thème et on la met en top recette.
            $themeingredient = ConfigurationManager::get()->getThemeingredient();
            $results = SearchController::searchByKeywords($themeingredient);
            if(count($results) > 0)
                $toprecipe = $results[0]->getRecipe();
        }
        else
        {
            for ($i = 0; $i < sizeof($allrecipe); $i++)
            {
                if($allrecipe[$i]->getNbBurn() >= 15 && $allrecipe[$i]->getStatus() != "draft" && $allrecipe[$i]->getStatus() != "private")
                {
                    $toprecipe = $allrecipe[$i];
                    break;
                }
            }
        }

        if(is_null($toprecipe))
            $toprecipe = false;

        //toutes les autres recettes dont l'utilisateur a accès.
        $recipes = [];
        for ($i = 0; $i < sizeof($allrecipe); $i++)
        {
            if($allrecipe[$i] != $toprecipe)
            {
                if($_SESSION['logged'])
                {
                    if($allrecipe[$i]->getStatus() != "draft" && $allrecipe[$i]->getStatus() != "private")
                        array_push($recipes, $allrecipe[$i]);
                }
                else
                {
                    if($allrecipe[$i]->getStatus() == "public")
                    {
                        array_push($recipes, $allrecipe[$i]);
                    }
                }
            }
        }

        $nbpage = round(sizeof($recipes) / $RecipePerPage);
        if($nbpage == 0)
            $nbpage = 1;

        if(!is_null($page) && $page > $nbpage)
        {
            $this->Redirect('/' . $nbpage);
        }

        $recipes = array_splice($recipes, $page*$RecipePerPage-$RecipePerPage, $RecipePerPage);


        $this->_view = new View('Index','Cook & Burn', array('nbpage' => $nbpage, 'page' => $page, 'recipes' => $recipes, 'toprecipe' => $toprecipe, 'theme' => $theme));
    }
}