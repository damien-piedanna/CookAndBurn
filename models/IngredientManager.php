<?php

/**
 * Class IngredientManager
 * Relation entre la classe Ingredient et la bd.
 */
class IngredientManager extends Model
{
    /**
     * @return array[Ingredient]
     */
    public static function getIngredients()
    {
        return parent::getAll('INGREDIENTS', 'Ingredient');
    }

    /**
     * @param $id int
     * @return null|Recipe
     */
    public static function getIngredient($id)
    {
        $req = parent::getBdd()->prepare('SELECT * FROM INGREDIENTS WHERE ID = :id');
        $req->execute([
            'id' => $id,
        ]);
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if($data)
            return new Recipe($data);
        else
            return null;
    }

    /**
     * @param $ingredient Ingredient
     */
    public static function add($ingredient)
    {
        $req = parent::getBdd()->prepare('INSERT INTO INGREDIENTS (`NAME`, CATEGORY, IMG) VALUES (:iname, :category, :img)');
        $req->execute([
            'iname' => $ingredient->getName(),
            'category' => $ingredient->getCategory(),
            'img' => $ingredient->getImg(),
        ]);
    }

    /**
     * @param $id int
     * @param $ingredient Ingredient
     */
    public static function edit($id, $ingredient)
    {
        $req = parent::getBdd()->prepare('UPDATE INGREDIENTS SET `NAME` = :iname , CATEGORY = :category , IMG = :img  WHERE ID = :id');
        $req->execute([
            'iname' => $ingredient->getName(),
            'category' => $ingredient->getCategory(),
            'img' => $ingredient->getImg(),
            'id' => $id,
        ]);
    }

    /**
     * @param $id int
     */
    public static function delete($id)
    {
        $req = parent::getBdd()->prepare('DELETE FROM COMPOSITIONS WHERE IDINGREDIENT = :id');
        $req->execute([
            'id' => $id,
        ]);
        $req = parent::getBdd()->prepare('DELETE FROM INGREDIENTS WHERE ID = :id');
        $req->execute([
            'id' => $id,
        ]);
    }
}