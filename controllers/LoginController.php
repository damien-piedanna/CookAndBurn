<?php

/**
 * Class LoginController
 * S'occupe de toute la partie d'authentification / recupération mot de passe
 */
class LoginController extends Controller
{
    /**
     * LoginController constructor.
     * @param $url
     * @throws Exception
     */
    public function __construct($url)
    {
        if (!is_null($url) && count($url) == 1)
            $this->login(null);
        else if (!is_null($url) && count($url) == 3 && $url[1] == "ask")
            $this->login($url[2]);
        else if (!is_null($url) && count($url) == 2 && $url[1] == "proceed")
            $this->login_proceed();
        else if (!is_null($url) && count($url) == 2 && $url[1] == "reset")
            $this->reset_proceed();
        else if (!is_null($url) && count($url) == 2 && $url[1] == "recover")
            $this->recover(null);
        else if (!is_null($url) && count($url) == 3 && $url[1] == "recover" && $url[2] != "proceed")
            $this->recover($url[2]);
        else if (!is_null($url) && count($url) == 3 && $url[1] == "recover" && $url[2] == "proceed")
            $this->recover_proceed();
        else if (!is_null($url) && count($url) == 2 && $url[1] == "logout")
            $this->logout_proceed();
        else
            throw new Exception('Page introuvable');
    }

    /**
     * Affiche la page d'authentification si l'utilisateur n'est pas connecté.
     * @param $request string Page demandé après la connexion.
     */
    private function login($request)
    {
        //Récupère l'id de la recette demandé si il y en a une.
        //Permet d'obtenir les infos de la recette demandé pour le partage sur les réseaux sociaux.
        if(!is_null($request) && $request != 'addrecipe')
            $recipe = RecipeManager::getRecipe($request);
        else
            $recipe = null;
        if($_SESSION['logged'])
            parent::Redirect('/account');
        else
            $this->_view = new View('Login','Cook & Burn | Login', array('recipe' => $recipe, 'request' => $request));
    }

    /**
     * Connecte un utilisateur.
     */
    private function login_proceed()
    {
        if(empty($_POST['email']) || empty($_POST['password']))
        {
            $_SESSION['error'] = "Vous devez remplir tout les champs.";
            parent::Redirect('/account');
        }

        $email = $_POST['email'];
        $password = md5($_POST['password']);

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
        {
            $_SESSION['error'] = "Votre adresse e-mail doit être valide.";
            parent::Redirect('/login');
        }

        $user = UserManager::checkUser ($email, $password);

        if(is_null($user))
        {
            $_SESSION['error'] = "Votre adresse e-mail ou mot de passe est incorrect.";
            parent::Redirect('/login');
        }

        $_SESSION['logged'] = true;
        $_SESSION['id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['password'] = $user->getPassword();
        $_SESSION['role'] = $user->getRole();

        // Redirige l'utilisateur vers la page ayant demander la connexion, sinon vers son compte
        if ($_POST['request'] != "" && gettype($_POST['request']) == "string")
            if($_POST['request'] == 'addrecipe')
                $redirectLink = '/recipe/add';
            else
                $redirectLink = '/recipe/' . $_POST['request'];
        else
            $redirectLink = '/account';
        parent::Redirect($redirectLink);
    }

    /**
     * Déconnecte un utilisateur.
     */
    private function logout_proceed()
    {
        if($_SESSION['logged'])
        {
            $_SESSION['logged'] = false;
            unset($_SESSION['id']);
            unset($_SESSION['username']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            unset($_SESSION['role']);
            parent::Redirect('/');
        }
    }

    /**
     * Permet à un utilisateur de demander la réinitialisation de son mot de passe.
     */
    private function reset_proceed()
    {
        $email = $_POST['email'];

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
        {
            $_SESSION['error'] = "Votre adresse e-mail doit être valide.";
            parent::Redirect('/login');
        }

        if(!UserManager::checkEmail($email))
        {
            $_SESSION['error'] = "Votre adresse e-mail n'est pas enregistrée, veuillez acheter un barbecue.";
            parent::Redirect('/login');
        }

        $token = parent::RandomString();
        //Le code devrais être renseigné en md5 pour plus de sécurité mais étant donné que les mails sont restreint...
        UserManager::createToken($email, $token);

        //$message = "Pour réinitialiser votre mot de passe : https://cooknburng4.alwaysdata.net/login/recover/" . $code;

        //Impossible d'envoyer un mail html sans mettre de cb donc on evoie que le code à mettre sur /login/recover
        mail($email, "Récupération de mot de passe - Cook & Burn", $token);

        $_SESSION['success'] = "Un mail vous a été envoyé avec les informations de réinitialisation.";
        parent::Redirect('/login');
    }

    /**
     * Changement de mot de passe à partir du code.
     * @param $code string Code de vérification
     */
    private function recover($token)
    {
        if($_SESSION['logged'])
            parent::Redirect('/account');
        else
            $this->_view = new View('Recover','Cook & Burn | Nouveau mot de passe', array('code' => $token));
    }

    /**
     * Change le mot de passe si le code et valide et supprime le token de réinitialisation.
     */
    private function recover_proceed()
    {
        $password = md5($_POST['newpassword']);
        $repassword = md5($_POST['renewpassword']);
        $code = $_POST['code'];

        $email = UserManager::getEmail($code);
        if(is_null($email))
        {
            $_SESSION['error'] = "Le token de réinitialisation n'est pas valide.";
            parent::Redirect('/login/recover');
        }
        if($password != $repassword)
        {
            $_SESSION['error'] = "Les nouveaux mots de passes sont différents.";
            parent::Redirect('/login/recover');
        }

        UserManager::changePassword($email, $password);
        UserManager::deleteToken($email);

        $_SESSION['success'] = "Votre mot de passe a bien été modifié.";
        parent::Redirect('/login');
    }
}