<?php

/**
 * Class CompositionManager
 * Relation entre la classe Composition et la bd.
 */
class CompositionManager extends Model
{
    /**
     * @return array[Composition]
     */
    public static function getCompositions()
    {
        return parent::getAll('COMPOSITIONS', 'Composition');
    }

    /**
     * Ajoute une composition.
     * @param $composition Composition
     */
    public static function addComposition($composition)
    {
        $req = parent::getBdd()->prepare('INSERT INTO COMPOSITIONS VALUES (:idrecipe, :idingredient, :quantity)');
        $req->execute([
            'idrecipe' => $composition->getIdrecipe() ,
            'idingredient' => $composition->getIdingredient(),
            'quantity' => $composition->getQuantity(),
        ]);
    }

    /**
     * Supprime une composition.
     * @param $idrecipe int
     */
    public static function deleteCompositions($idrecipe)
    {
        $req = parent::getBdd()->prepare('DELETE FROM COMPOSITIONS WHERE IDRECIPE = :id');
        $req->execute([
            'id' => $idrecipe,
        ]);
    }
}