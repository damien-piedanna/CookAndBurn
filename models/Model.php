<?php

/**
 * Class Model
 * Classe abstraite des models.
 */
abstract class Model
{
    /**
     * @var
     */
    protected static $_bdd;

    /**
     * Instancie la connexion à la bdd
     */
    private static function setBdd()
    {
        self::$_bdd = new PDO('mysql:host=CHANGE_ME;dbname=CHANGE_ME;charset=utf8','CHANGE_ME','CHANGE_ME');
        self::$_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    /**
     * Récupère la connexion à la bdd
     * @return mixed
     */
    protected static function getBdd()
    {
        if(is_null(self::$_bdd))
            self::setBdd();
        return self::$_bdd;
    }

    /**
     * Récupère tout les tuples d'une table.
     * @param $table string
     * @param $obj string
     * @return array
     */
    protected static function getAll($table, $obj)
    {
        $tab = [];
        $req = self::getBdd()->prepare('SELECT * FROM ' . $table . ' ORDER BY ID DESC');
        $req->execute();
        while($data = $req->fetch(PDO::FETCH_ASSOC))
        {
            $tab[] = new $obj($data);
        }
        $req->closeCursor;
        return $tab;
    }
}