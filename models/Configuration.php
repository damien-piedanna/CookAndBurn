<?php

/**
 * Class Configuration
 * Configuration du site web.
 */
class Configuration
{
    /**
     * @var string Theme actif sur le site
     */
    private $_theme;
    /**
     * @var int Nombre de recette par page
     */
    private $_recipeperpage;
    /**
     * @var Ingredient Ingredient que doit contenir la top recette
     */
    private $_themeingredient;

    /**
     * Configuration constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * Lance tout les setters
     * @param array $data[mixed]
     */
    public function hydrate(array $data)
    {
        foreach($data as $key => $value)
        {
            $method = 'set' . ucfirst($key);

            if(method_exists($this, $method))
                $this->$method($value);
        }
    }

    /**
     * @param mixed $theme
     */
    public function setTheme($theme)
    {
        if(is_string($theme))
            $this->_theme = $theme;
    }

    /**
     * @param mixed $recipeperpage
     */
    public function setRecipeperpage($recipeperpage)
    {
        $recipeperpage = (int) $recipeperpage;
        if($recipeperpage > 0)
            $this->_recipeperpage = $recipeperpage;
    }

    /**
     * @param Ingredient $themeingredient
     */
    public function setThemeingredient($themeingredient)
    {
        $this->_themeingredient = $themeingredient;
    }

    /**
     * @return string
     */
    public function getTheme()
    {
        return $this->_theme;
    }

    /**
     * @return int
     */
    public function getRecipeperpage()
    {
        return $this->_recipeperpage;
    }

    /**
     * @return Ingredient
     */
    public function getThemeingredient()
    {
        return $this->_themeingredient;
    }
}