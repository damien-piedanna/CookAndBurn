<?php
/**
 * Class SearchController
 * Controller pour l'option de recherche.
 */
class SearchController extends Controller
{
    public function __construct($url)
    {
        if (count($url) == 1 && $url[0] == "search") {
            $research = filter_var($_POST['research'], FILTER_SANITIZE_STRING);
            $this->search($research);
        }
        else
            throw new Exception('Page introuvable');
    }

    /**
     * Créer une nouvelle vue affichant tous les résultats de la recherche.
     * @param $research string Recherche entrée par l'utilisateur
     */
    private function search ($research)
    {
        $results = $this->searchByKeywords($research);
        // Si un seul résultat l'utilisateur est directement redirigé vers celui-ci
        if(count($results) == 1)
            $this->Redirect('/recipe/' . $results[0]->getRecipe()->getId());
        else
            $this->_view = new View('Search', 'Cook & Burn | ' . $research, array('results' => $results, 'research' => $research));
    }

    /**
     * Nettoie un chaîne de caractère pour qu'elle corresponde à un URL.
     * @param $str string Chaîne à nettoyer
     * @return null|string|string[] Chaîne nettoyée
     */
    private static function stringToUrl($str) {
        $str = lcfirst($str);
        $str_find = array('á', 'à', 'â', 'ä', 'ã', 'å', 'ç', 'é', 'è', 'ê', 'ë', 'í', 'ì', 'î', 'ï', 'ñ', 'ó', 'ò', 'ô', 'ö', 'õ', 'ú', 'ù', 'û', 'ü', 'ý', 'ÿ', "'", '"', '\'', '&quot;', '&gt;', '&lt;', '»', '«', ' ');
        $str_replace = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i' ,'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', '-', '-', '-', '', '', '', '-', '-', '-');

        for($i = 0; $i < count($str_find); $i++){
            $str = preg_replace('#' . $str_find[$i] . '#isU', $str_replace[$i], $str);
        }
        $str = preg_replace("#[^a-zA-Z0-9\-]#", "", $str);
        $str = preg_replace("#-+#", "-", $str);
        return $str;
    }

    /**
     * Recherche toutes les recettes qui correspondent à la recherche.
     * @param $research string Recherche entrée par l'utilisateur
     * @return array Un tableau de SearchResult
     */
    public static function searchByKeywords($research)
    {
        // Normalisation de la recherche
        $research = self::stringToUrl($research);
        // Mots à ignorer lors de la sélection des recettes
        $forbiddenWords = array('les', 'des', 'ces', 'ses', 'pas', 'aux', 'mes', 'tes', 'avec', 'sans', 'pour', 'nous', 'vous', 'elle', 'elles', 'leur',
                                'celui', 'celui-ci', 'celui-là', 'celle', 'celle-ci', 'celle-là', 'ceux', 'ceux-ci', 'ceux-là', 'celles', 'celles-ci',
                                'celles-là', 'ceci', 'cela', 'quoi', 'dont', 'est', 'lequel', 'auquel', 'duquel', 'laquelle', 'lesquels', 'auxquels',
                                'desquels', 'lesquelles', 'auxquelles', 'desquelles', 'tout', 'autres', 'autre', 'aucun', 'aucune', 'aucuns', 'aucunes',
                                'certain', 'certains', 'certaine', 'certaines', 'telle', 'tels', 'telles', 'tout', 'toute', 'tous', 'toutes', 'même',
                                'cette', 'notre', 'votre', 'leur', 'leurs');
        // Mots-clef composants la recherche
        $keywords = explode('-', $research);
        // Résultats de la recherche
        $results = [];

        $recipes = RecipeManager::getRecipes();
        foreach ($recipes as $recipe)
        {
            // Catégories d'ingrédient déjà prises en compte dans la recette courante
            $usedCategories = [];
            // Mots clef manquants dans la recette courante
            $missingWords = [];
            // Degrès de correspondance entre la recherche et la recette courante
            $correspondence = 0;

            foreach ($keywords as $i => $keyword)
            {
                /*-- Décomposition du mot clef en tous les mots composant le mot clef contenant entre 4 lettres et la taille du mot clef --*/
                // Tous les mots extraits du mot clef
                $decomposedKeyword = [];

                // Les mots de moins de 3 lettres sont ignorés
                // Les mots de 3 lettres ne sont pas décomposés
                if (strlen($keyword) == 3)
                    array_push($decomposedKeyword, $keyword);

                // Décomposition des mots de plus de 4 lettres
                else if (strlen($keyword) > 3)
                {
                    // Taille courante de décomposition des mots
                    $window = strlen($keyword);
                    // Décalage par rapport au début du mot clef
                    $offset = 0;

                    // On ne prend pas en compte les mots de moins de 3 lettres et les mots à ignorer
                    while (strlen($keyword) > 2 && !in_array($keyword, $forbiddenWords)) {
                        // Si la fenêtre dépasse du mot
                        if ($offset + $window > strlen($keywords[$i])) {
                            --$window; // On réduit la fenêtre d'un caractère
                            $offset = 0; // On revient au début du mot
                        }
                        // On ne va pas en dessous de 4 caractères dans la décomposition des mots
                        if ($window >= 4)
                            array_push($decomposedKeyword, substr($keywords[$i], $offset++, $window));
                        else
                            break;
                    }
                }

                /*-- Recherche de tous les sous mots dans la recette courante --*/
                // True si le mot clef de base n'apparait pas dans le recette
                $isMissing = true;
                // Test de tous les mots dans l'auteur de la recette courante
                foreach ($decomposedKeyword as $j=>$keywordPart)
                {
                    if (!is_bool(stripos(self::stringToUrl($recipe->getAuthor()->getUsername()), $keywordPart))) {
                        // count($keywords) - $i permet d'attribuer une importance décroissante aux mots clefs entrés
                        // (strlen($keywordPart) / strlen($keywords[$i]) permet d'attribuer une importance différente au mot selon ça différence avec le vrai mot clef
                        $correspondence += 5 + count($keywords) - $i + (strlen($keywordPart) / strlen($keywords[$i]));
                        if ($j == 0)
                            $isMissing = false;
                        break;
                    }
                }
                // Test de tous les mots dans le titre de la recette courante
                foreach ($decomposedKeyword as $j=>$keywordPart)
                {
                    if (!is_bool(stripos(self::stringToUrl($recipe->getName()), $keywordPart))) {
                        $correspondence += 2 + count($keywords) - $i + (strlen($keywordPart) / strlen($keywords[$i]));
                        if ($j == 0)
                            $isMissing = false;
                        break;
                    }
                }
                // Test de tous les mots dans la description longue de la recette courante
                foreach ($decomposedKeyword as $j=>$keywordPart)
                {
                    if (!is_bool(stripos(self::stringToUrl($recipe->getLongDesc()), $keywordPart))) {
                        $correspondence += 0.5 + count($keywords) - $i + (strlen($keywordPart) / strlen($keywords[$i]));
                        if ($j == 0)
                            $isMissing = false;
                        break;
                    }
                }
                    foreach ($recipe->getCompositions() as $composition)
                    {
                        // Test de tous les mots dans les ingredients de la recette courante
                        foreach ($decomposedKeyword as $j=>$keywordPart)
                        {
                            if (!is_bool(stripos(self::stringToUrl($composition['ingredient']->getName()), $keywordPart))) {
                                $correspondence += 1 + count($keywords) - $i + (strlen($keywordPart) / strlen($keywords[$i]));
                                if ($j == 0)
                                    $isMissing = false;
                                break;
                            }
                        }
                        // Test de tous les mots dans les catégories d'ingredient de la recette courante
                        foreach ($decomposedKeyword as $j=>$keywordPart)
                        {
                            if (!is_bool(stripos(self::stringToUrl($composition['ingredient']->getCategory()), $keywordPart)))
                            {
                                // La catégorie n'est comptée qu'une fois, peu importe le nombre d'ingrédients de la recette en faisant parti
                                if (!in_array(self::stringToUrl($composition['ingredient']->getCategory()), $usedCategories))
                                {
                                    array_push($usedCategories, self::stringToUrl($composition['ingredient']->getCategory()));
                                    $correspondence += 0.5 + count($keywords) - $i + (strlen($keywordPart) / strlen($keywords[$i]));
                                }
                                if ($j == 0)
                                    $isMissing = false;
                            }
                        }
                    } // for each composition
                if ($isMissing)
                    array_push($missingWords, $keywords[$i]);
            }

            if ($correspondence > 0)
                if (($recipe->getStatus() == "public" || ($_SESSION['logged'] != null && $_SESSION['logged'])) && (($recipe->getStatus() != "draft" && $recipe->getStatus() != "private") || ($_SESSION['id'] == $recipe->getAuthor()->getId() || $_SESSION['role'] == "Admin")))
                    array_push($results, new SearchResult($recipe, $correspondence, $missingWords));
        } // for each recipe
        /*-- Classement des résultats par nombre de burn --*/
        $i = 1;
        while ($i < count($results))
        {
            $j = $i;
            while ($j > 0 && $results[$j - 1]->getRecipe()->getNbBurn() < $results[$j]->getRecipe()->getNbBurn())
            {
                $temp = $results[$j - 1];
                $results[$j - 1] = $results[$j];
                $results[$j] = $temp;
                $j -= 1;
            }
            $i += 1;
        }

        /*-- Puis classement des résultats par correspondance --*/
        $i = 1;
        while ($i < count($results))
        {
            $j = $i;
            while ($j > 0 && $results[$j - 1]->getCorrespondence() < $results[$j]->getCorrespondence())
            {
                $temp = $results[$j - 1];
                $results[$j - 1] = $results[$j];
                $results[$j] = $temp;
                $j -= 1;
            }
            $i += 1;
        }
        return $results;
    }
}