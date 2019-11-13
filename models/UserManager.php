<?php

/**
 * Class UserManager
 * Relation entre la classe User et la bd.
 */
class UserManager extends Model
{
    /**
     * @return array[User]
     */
    public static function getUsers()
    {
        return parent::getAll('USERS', 'User');
    }

    /**
     * Vérifie si l'utilisateur éxiste.
     * @param $email string
     * @param $password string
     * @return null|User
     */
    public static function checkUser ($email, $password)
    {
        $req = parent::getBdd()->prepare('SELECT * FROM USERS WHERE EMAIL = :email AND PASSWORD = :password');
        $req->execute([
            'email' => $email,
            'password' => $password,
        ]);
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if($data)
            return new User($data);
        else
            return null;
    }

    /**
     * Vérifie si l'email existe dans la bd.
     * @param $email string
     * @return bool
     */
    public static function checkEmail ($email)
    {
        $req = parent::getBdd()->prepare('SELECT ID FROM USERS WHERE EMAIL = :email');
        $req->execute([
            'email' => $email,
        ]);
        if($req->rowCount() == 1)
            return true;
        return false;
    }

    /**
     * Vérifie si l'username existe dans la bd.
     * @param $username string
     * @return bool
     */
    public static function checkUsername ($username)
    {
        $req = parent::getBdd()->prepare('SELECT ID FROM USERS WHERE USERNAME = :username');
        $req->execute([
            'username' => $username,
        ]);
        if($req->rowCount() == 1)
            return true;
        return false;
    }

    /**
     * Insert le token de reset.
     * @param $email string
     * @param $code string
     */
    public static function createToken($email, $code)
    {
        $req = parent::getBdd()->prepare('UPDATE USERS SET TOKENRESET = :code WHERE EMAIL = :email');
        $req->execute([
            'email' => $email,
            'code' => $code,
        ]);
    }

    /**
     * @param $email string
     * @return null|User
     */
    public static function getUser($email)
    {
        $req = parent::getBdd()->prepare('SELECT * FROM USERS WHERE EMAIL = :email');
        $req->execute([
            'email' => $email,
        ]);
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if($data)
            return new User($data);
        else
            return null;
    }

    /**
     * Récupère l'email associé a un token de reset.
     * @param $code string
     * @return null
     */
    public static function getEmail($code)
    {
        $req = parent::getBdd()->prepare('SELECT EMAIL FROM USERS WHERE TOKENRESET = :code');
        $req->execute([
            'code' => $code,
        ]);
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if($req->rowCount() == 1)
            return $data['EMAIL'];
        return null;
    }

    /**
     * Modifie le mot de passe d'un utilisateur.
     * @param $email string
     * @param $newpassword string
     */
    public static function changePassword($newpassword, $email)
    {
        $req = parent::getBdd()->prepare('UPDATE USERS SET PASSWORD = :newpassword WHERE EMAIL = :email');
        $req->execute([
            'newpassword' => $newpassword,
            'email' => $email,
        ]);
    }

    /**
     * Modifie l'username d'un utilisateur.
     * @param $username string
     * @param $id int
     */
    public static function changeUserame($username, $id)
    {
        $req = parent::getBdd()->prepare('UPDATE USERS SET USERNAME = :username WHERE ID = :id');
        $req->execute([
            'username' => $username,
            'id' => $id,
        ]);
    }

    /**
     * Modifie l'email d'un utilisateur.
     * @param $email string
     * @param $id int
     */
    public static function changeEmail($email, $id)
    {
        $req = parent::getBdd()->prepare('UPDATE USERS SET EMAIL = :email WHERE ID = :id');
        $req->execute([
            'email' => $email,
            'id' => $id,
        ]);
    }

    /**
     * Modifie le rôle d'un utilisateur.
     * @param $role string
     * @param $id int
     */
    public static function changeRole($role, $id)
    {
        $req = parent::getBdd()->prepare('UPDATE USERS SET ROLE = :role WHERE ID = :id');
        $req->execute([
            'role' => $role,
            'id' => $id,
        ]);
    }

    /**
     * Suppression du token de reset.
     * @param $email string
     */
    public static function deleteToken($email)
    {
        $req = parent::getBdd()->prepare('UPDATE USERS SET TOKENRESET = \'\' WHERE EMAIL = :email');
        $req->execute([
            'email' => $email,
        ]);
    }

    /**
     * Ajoute une utilisateur
     * @param $username string
     * @param $email string
     * @param $role string
     */
    public static function add($username, $email, $role)
    {
        $req = parent::getBdd()->prepare('INSERT INTO USERS (USERNAME, EMAIL, ROLE) VALUES (:username, :email, :role)');
        $req->execute([
            'username' => $username,
            'email' => $email,
            'role' => $role,
        ]);
    }

    /**
     * Suppression d'un utilisateur.
     * @param $id int
     */
    public static function delete($id)
    {
        $req = parent::getBdd()->prepare('SELECT ID FROM RECIPES WHERE AUTHOR = :id');
        $req->execute([
            'id' => $id,
        ]);
        while($data = $req->fetch(PDO::FETCH_ASSOC))
        {
            RecipeManager::delete($data['ID']);
        }
        $req = parent::getBdd()->prepare('DELETE FROM BURNS WHERE IDUSER = :id');
        $req->execute([
            'id' => $id,
        ]);
        $req = parent::getBdd()->prepare('DELETE FROM FAVORITES WHERE IDUSER = :id');
        $req->execute([
            'id' => $id,
        ]);
        $req = parent::getBdd()->prepare('DELETE FROM USERS WHERE ID = :id');
        $req->execute([
            'id' => $id,
        ]);
    }
}