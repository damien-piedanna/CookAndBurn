<?php

/**
 * Class SearchResult
 * Résultat de recherche. Cette classe associe une recette à sa correspondance avec la recherche
 * en cours, ainsi qu'avec les mots recherchés non présents dans la recette.
 */
class SearchResult
{
    /** @var Recipe Recette trouvée */
    private $_recipe;
    /** @var int Degrès de correspondence avec la recherche */
    private $_correspondence;
    /** @var array<string> Mots de la recherche manquants dans la recette */
    private $_missingWords;

    public function __construct($recipe, $correspondence, $missingWords)
    {
        $this->_recipe = $recipe;
        $this->_correspondence = $correspondence;
        $this->_missingWords = $missingWords;
    }

    /**
     * @return float
     */
    public function getCorrespondence()
    {
        return $this->_correspondence;
    }

    /**
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->_recipe;
    }

    /**
     * @return array<string>
     */
    public function getMissingWords()
    {
        return $this->_missingWords;
    }
}