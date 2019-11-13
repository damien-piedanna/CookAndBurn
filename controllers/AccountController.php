<?php
require_once ('views/View.php');

/**
 * Class AccountController
 * S'occupe de toute la partie "Mon Compte"
 */
class AccountController extends Controller
{
    /**
     * AccountController constructor.
     * @param $url string
     * @throws Exception
     */
    public function __construct($url)
    {
        //Rédirige sur la page de connexion si l'utilisateur n'est pas connecté.
        if(!$_SESSION['logged'])
            parent::Redirect('/login');

        if (!is_null($url) && count($url) == 1)
            $this->index();
        else if (!is_null($url) && count($url) == 2 && $url[1] == 'changeinfo')
            $this->changeInfo();
        else if (!is_null($url) && count($url) == 2 && $url[1] == 'changepswd')
            $this->changePswd();
        else
            throw new Exception('Page introuvable');
    }

    /**
     * @throws Exception
     */
    private function index()
    {
        $email = $_SESSION['email'];

        $user = UserManager::getUser($email);

        $recipes = RecipeManager::getRecipes();
        $favorites = [];
        $myrecipes = [];

        foreach ($recipes as $recipe)
        {
            if($recipe->getIsFav())
            {
                array_push($favorites, $recipe);
            }
            if($recipe->getAuthor()->getId() == $_SESSION['id'])
            {
                array_push($myrecipes, $recipe);
            }
        }

        if (is_null($user))
            throw new Exception('Désolé mais votre compte a été supprimé.');
        else
            $this->_view = new View('Account', 'Cook & Burn | Mon compte', array('user' => $user, 'favorites' => $favorites, 'myrecipes' => $myrecipes));
    }

    /**
     * Modifie les informations de l'utilisateur.
     */
    private function changeInfo()
    {
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $email = $_POST['email'];

        $infochanged = false;

        if($username != $_SESSION['username'])
        {
            if(strlen($username) < 2 || strlen($username) > 30)
            {
                $_SESSION['error'] = "Votre nouveau nom de profil doit contenir 2 à 30 caractères.";
                parent::Redirect('/account');
            }
            if(UserManager::checkUsername($username))
            {
                $_SESSION['error'] = "Ce nom de compte est déjà utilisé.";
                parent::Redirect('/account');
            }
            UserManager::changeUserame($username, $_SESSION['id']);
            $_SESSION['username'] = $username;
            $infochanged = true;
        }
        if($email != $_SESSION['email'])
        {
            if(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
            {
                $_SESSION['error'] = "Votre nouvelle adresse e-mail doit être valide.";
                parent::Redirect('/account');
            }
            if(UserManager::checkEmail($email))
            {
                $_SESSION['error'] = "Cette adresse email est déjà utilisée.";
                parent::Redirect('/account');
            }
            UserManager::changeEmail($email, $_SESSION['id']);
            $_SESSION['email'] = $email;
            $infochanged = true;
        }

        if($infochanged)
            $_SESSION['success'] = 'Vos informations ont bien été mis à jour';
        $this->Redirect('/account');
    }

    /**
     * Change le mot de passe de l'utilisateur.
     */
    private function changePswd()
    {
        if(empty($_POST['oldpassword']) || empty($_POST['newpassword']) || empty($_POST['renewpassword']))
        {
            $_SESSION['error'] = "Vous devez remplir tout les champs.";
            parent::Redirect('/account');
        }

        $oldpassword = md5($_POST['oldpassword']);
        $newpassword = md5($_POST['newpassword']);
        $renewpassword = md5($_POST['renewpassword']);

        if($oldpassword != $_SESSION['password'])
        {
            $_SESSION['error'] = "Votre mot de passe actuel n'est pas correct.";
            parent::Redirect('/account');
        }
        if($newpassword != $renewpassword)
        {
            $_SESSION['error'] = "Les nouveaux mots de passes sont différents.";
            parent::Redirect('/account');
        }

        UserManager::changePassword($_SESSION['email'], $newpassword);

        $_SESSION['password'] = $newpassword;

        $_SESSION['success'] = "Votre mot de passe a bien été modifié.";
        $this->Redirect('/account');
    }
}