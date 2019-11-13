<?php

/**
 * Class RecipeManager
 * Relation entre la classe Recette et la bd.
 */
class RecipeManager extends Model
{
    /**
     * @return array[Recipe]
     */
    public static function getRecipes()
    {
        return parent::getAll('RECIPES', 'Recipe');
    }

    /**
     * @param $id int
     * @return null|Recipe
     */
    public static function getRecipe($id)
    {
        $req = parent::getBdd()->prepare('SELECT * FROM RECIPES WHERE ID = :id');
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
     * Récupère l'auteur d'une recette.
     * @param $id int
     * @return null|User
     */
    public static function getAuthor($id)
    {
        $req = parent::getBdd()->prepare('SELECT * FROM USERS WHERE ID = :id');
        $req->execute([
            'id' => $id,
        ]);
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if($data)
            return new User($data);
        else
            return null;
    }

    /**
     * @param $idrecipe int
     * @return array[Ingredient, quantity]
     */
    public static function getCompositions($idrecipe)
    {
        $ingredients = [];
        $req = parent::getBdd()->prepare('SELECT * FROM INGREDIENTS WHERE ID IN (SELECT IDINGREDIENT FROM COMPOSITIONS WHERE IDRECIPE = :idrecipe)');
        $req->execute([
            'idrecipe' => $idrecipe,
        ]);
        while($data = $req->fetch(PDO::FETCH_ASSOC))
        {
            $ingredients[] = new Ingredient($data);
        }
        $req->closeCursor;

        $req = parent::getBdd()->prepare('SELECT QUANTITY FROM COMPOSITIONS WHERE IDRECIPE = :idrecipe');
        $req->execute([
            'idrecipe' => $idrecipe,
        ]);
        while($data = $req->fetch(PDO::FETCH_ASSOC))
        {
            $quantities[] = $data;
        }

        $compositions = [];

        for($i = 0; $i < sizeof($ingredients); $i++)
        {
            array_push($compositions, array('ingredient' => $ingredients[$i], 'quantity' => $quantities[$i]['QUANTITY']));
        }

        return $compositions;
    }

    /**
     * Retourne le nombre de burn d'une recette.
     * @param $id int
     * @return int
     */
    public static function getBurn($id)
    {
        $req = parent::getBdd()->prepare('SELECT COUNT(IDRECIPE) AS NBBURN FROM BURNS WHERE IDRECIPE = :id');
        $req->execute([
            'id' => $id,
        ]);
        return $req->fetch(PDO::FETCH_ASSOC)['NBBURN'];
    }

    /**
     * Retourne le nombre total de burn sur le site.
     * @return int
     */
    public static function getBurns()
    {
        $req = parent::getBdd()->prepare('SELECT COUNT(IDRECIPE) AS NBBURN FROM BURNS');
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC)['NBBURN'];
    }

    /**
     * Retourne le nombre de fav d'une recette.
     * @param $id int
     * @return int
     */
    public static function getFav($id)
    {
        $req = parent::getBdd()->prepare('SELECT COUNT(IDRECIPE) AS NBFAV FROM FAVORITES WHERE IDRECIPE = :id');
        $req->execute([
            'id' => $id,
        ]);
        return $req->fetch(PDO::FETCH_ASSOC)['NBFAV'];
    }


    /**
     * Ajoute une recette.
     * @param $recipe Recipe
     * @return int Id de la recette ajoutée
     */
    public static function add($recipe)
    {
        $req = parent::getBdd()->prepare('INSERT INTO RECIPES (AUTHOR, `NAME`, IMG, NBPERS, SHORTDESC, LONGDESC, STEPS, STATUS) VALUES (:author, :rname, :img, :nbpers, :shortdesc, :longdesc, :steps, :status)');
        $req->execute([
            'author' => $recipe->getAuthor()->getID(),
            'rname' => $recipe->getName(),
            'img' => $recipe->getImg(),
            'nbpers' => $recipe->getNbPers(),
            'shortdesc' => $recipe->getShortDesc(),
            'longdesc' => $recipe->getLongDesc(),
            'steps' => $recipe->getSteps(),
            'status' => $recipe->getStatus(),
        ]);

        return parent::getBdd()->lastInsertId();
    }

    /**
     * Modifie une recette.
     * @param $id int
     * @param $recipe Recipe
     */
    public static function edit($id, $recipe)
    {
        //Limited est défini lors de la récupération de la bd et pas à la creation d'un objet recette php.
        if($recipe->getStatus() == "limited")
            $status = "public";
        else
            $status = $recipe->getStatus();

        $req = parent::getBdd()->prepare('UPDATE RECIPES SET AUTHOR = :author , `NAME` = :rname, IMG = :img, NBPERS = :nbpers, SHORTDESC = :shortdesc, LONGDESC = :longdesc, STEPS = :steps, STATUS = :status WHERE ID = :id');
        $req->execute([
            'id' => $id,
            'author' => $recipe->getAuthor()->getID(),
            'rname' => $recipe->getName(),
            'img' => $recipe->getImg(),
            'nbpers' => $recipe->getNbPers(),
            'shortdesc' => $recipe->getShortDesc(),
            'longdesc' => $recipe->getLongDesc(),
            'steps' => $recipe->getSteps(),
            'status' => $status,
        ]);
    }

    /**
     * Supprime une recette.
     * @param $id int
     */
    public static function delete($id)
    {
        $req = parent::getBdd()->prepare('DELETE FROM BURNS WHERE IDRECIPE = :id');
        $req->execute([
            'id' => $id,
        ]);
        $req = parent::getBdd()->prepare('DELETE FROM FAVORITES WHERE IDRECIPE = :id');
        $req->execute([
            'id' => $id,
        ]);
        $req = parent::getBdd()->prepare('DELETE FROM ANNOTATION WHERE IDRECIPE = :id');
        $req->execute([
            'id' => $id,
        ]);
        $req = parent::getBdd()->prepare('DELETE FROM COMPOSITIONS WHERE IDRECIPE = :id');
        $req->execute([
            'id' => $id,
        ]);
        $req = parent::getBdd()->prepare('DELETE FROM RECIPES WHERE ID = :id');
        $req->execute([
            'id' => $id,
        ]);
    }

    /**
     * Burn une recette.
     * @param $recipeId int
     * @param $userId int
     */
    public static function burn($recipeId, $userId)
    {
        $req = parent::getBdd()->prepare('INSERT INTO BURNS VALUES (:recipeid, :userid)');
        $req->execute([
            'recipeid' => $recipeId,
            'userid' => $userId,
        ]);
    }

    /**
     * Fav une recette.
     * @param $recipeId
     * @param $userId
     */
    public static function fav($recipeId, $userId)
    {
        $req = parent::getBdd()->prepare('INSERT INTO FAVORITES VALUES (:recipeid, :userid)');
        $req->execute([
            'recipeid' => $recipeId,
            'userid' => $userId,
        ]);
    }

    /**
     * Unburn une recette.
     * @param $recipeId int
     * @param $userId int
     */
    public static function unburn($recipeId, $userId)
    {
        $req = parent::getBdd()->prepare('DELETE FROM BURNS WHERE IDRECIPE = :recipeid AND IDUSER = :userid');
        $req->execute([
            'recipeid' => $recipeId,
            'userid' => $userId,
        ]);
    }

    /**
     * Unfav une recette.
     * @param $recipeId int
     * @param $userId int
     */
    public static function unfav($recipeId, $userId)
    {
        $req = parent::getBdd()->prepare('DELETE FROM FAVORITES WHERE IDRECIPE = :recipeid AND IDUSER = :userid');
        $req->execute([
            'recipeid' => $recipeId,
            'userid' => $userId,
        ]);
    }

    /**
     * La recette est burn par l'utilisateur ?
     * @param $recipeId int
     * @param $userId int
     * @return bool
     */
    public static function isBurned($recipeId, $userId)
    {
        $req = parent::getBdd()->prepare('SELECT COUNT(*) AS ISBURNED FROM BURNS WHERE IDRECIPE = :recipeid and IDUSER = :userid');
        $req->execute([
            'recipeid' => $recipeId,
            'userid' => $userId,
        ]);
        return boolval($req->fetch(PDO::FETCH_ASSOC)['ISBURNED']);
    }

    /**
     * La recette est fav par l'utilisateur ?
     * @param $recipeId int
     * @param $userId int
     * @return bool
     */
    public static function isFav($recipeId, $userId)
    {
        $req = parent::getBdd()->prepare('SELECT COUNT(*) AS ISFAV FROM FAVORITES WHERE IDRECIPE = :recipeid and IDUSER = :userid');
        $req->execute([
            'recipeid' => $recipeId,
            'userid' => $userId,
        ]);
        return boolval($req->fetch(PDO::FETCH_ASSOC)['ISFAV']);
    }

    /**
     * Récupère l'annotation de l'utilisateur connectée si il en a mis une.
     * @param $recipeId int
     * @param $userId int
     * @return string
     */
    public static function getAnnotation($recipeId, $userId)
    {
        $req = parent::getBdd()->prepare('SELECT TEXT FROM ANNOTATION WHERE IDRECIPE = :recipeid AND IDUSER = :userid');
        $req->execute([
            'recipeid' => $recipeId,
            'userid' => $userId,
        ]);
        return $req->fetch(PDO::FETCH_ASSOC)['TEXT'];
    }

    /**
     * Mets à jour une annotation.
     * @param $recipeId int
     * @param $userId int
     * @param $annotation string
     */
    public static function setAnnotation($recipeId, $userId, $annotation)
    {
        if(is_null(self::getAnnotation($recipeId, $userId)))
        {
            $req = parent::getBdd()->prepare('INSERT INTO ANNOTATION VALUES (:recipeid, :userid, :annotation)');
            $req->execute([
                'recipeid' => $recipeId,
                'userid' => $userId,
                'annotation' => $annotation,
            ]);
        }
        else
        {
            if($annotation != "")
            {
                $req = parent::getBdd()->prepare('UPDATE ANNOTATION SET TEXT = :annotation WHERE IDRECIPE = :recipeid AND IDUSER = :userid');
                $req->execute([
                    'recipeid' => $recipeId,
                    'userid' => $userId,
                    'annotation' => $annotation,
                ]);
            }
            else
            {
                $req = parent::getBdd()->prepare('DELETE FROM ANNOTATION WHERE IDRECIPE = :recipeid AND IDUSER = :userid');
                $req->execute([
                    'recipeid' => $recipeId,
                    'userid' => $userId,
                ]);
            }
        }
    }
}