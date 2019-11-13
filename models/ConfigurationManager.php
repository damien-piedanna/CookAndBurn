<?php

/**
 * Class ConfigurationManager
 * Relation entre la classe Configuration et la bd.
 */
class ConfigurationManager extends Model
{
    /**
     * Récupère la configuration.
     * @return Configuration|null
     */
    public static function get()
    {
        $req = parent::getBdd()->prepare('SELECT * FROM CONFIGURATIONS WHERE NAME = "default"');
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if($data)
            return new Configuration($data);
        else
            return null;
    }

    /**
     * Met à jour la configuration.
     * @param $configuration Configuration
     */
    public static function update($configuration)
    {
        $req = parent::getBdd()->prepare('UPDATE CONFIGURATIONS SET RECIPEPERPAGE = :recipeperpage, THEME = :theme, THEMEINGREDIENT = :themeingredient WHERE NAME = "default"');
        $req->execute([
            'recipeperpage' => $configuration->getRecipeperpage(),
            'theme' => $configuration->getTheme(),
            'themeingredient' => $configuration->getThemeingredient(),
        ]);
    }
}