<?php

/**
 * Class DashboardController
 * S'occupe de toute la partie "Dashboard"
 */
class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     * @param $url string
     * @throws Exception
     */
    public function __construct($url)
    {
        if($_SESSION['role'] != "Admin")
        {
            parent::Redirect('/');
        }

        if (!is_null($url) && count($url) == 1)
            $this->index();
        else if (!is_null($url) && count($url) == 2 && $url[1] == 'editconfiguration')
            $this->editConfiguration();
        else if (!is_null($url) && count($url) == 2 && $url[1] == 'addingredient')
            $this->addIngredient();
        else if (!is_null($url) && count($url) == 2 && $url[1] == 'editingredient')
            $this->editIngredient();
        else if (!is_null($url) && count($url) == 2 && $url[1] == 'deleteingredient')
            $this->deleteIngredient();
        else if (!is_null($url) && count($url) == 2 && $url[1] == 'adduser')
            $this->addUser();
        else if (!is_null($url) && count($url) == 2 && $url[1] == 'edituser')
            $this->editUser();
        else if (!is_null($url) && count($url) == 2 && $url[1] == 'deleteuser')
            $this->deleteUser();
        else
            throw new Exception('Page introuvable');
    }

    /**
     * Index du dashboard.
     */
    private function index()
    {
        $ingredients = IngredientManager::getIngredients();
        $recipes = RecipeManager::getRecipes();
        $users = UserManager::getUsers();
        $configuration = ConfigurationManager::get();
        $nbburns = RecipeManager::getBurns();

        $ingtemp = 0;
        $categories = [];
        foreach ($ingredients as $ingredient)
        {
            if (!in_array($ingredient->getCategory(), $categories))
                array_push($categories, $ingredient->getCategory());
            if($ingredient->getCategory() == "Non vérifié")
                $ingtemp++;
        }

        $roles = [];
        foreach ($users as $user)
        {
            if (!in_array($user->getRole(), $roles)) {
                array_push($roles, $user->getRole());
            }
        }

        $this->_view = new View('Dashboard','Cook & Burn | Dashboard', array('ingredients' => $ingredients, 'categories' => $categories, 'recipes' => $recipes,'users' => $users, 'roles' => $roles, 'configuration' => $configuration, 'nbburns' => $nbburns, 'ingtemp' => $ingtemp));
    }

    /**
     * Modifie la configuration.
     */
    private function editConfiguration()
    {
        $recipeperpage = filter_var($_POST['recipeperpage'], FILTER_SANITIZE_NUMBER_INT);
        $theme = filter_var($_POST['theme'], FILTER_SANITIZE_STRING);
        $themeingredient = filter_var($_POST['themeingredient'], FILTER_SANITIZE_STRING);

        if($recipeperpage < 0)
        {
            $_SESSION['error'] = "Le nombre de recette par page doit être positif.";
            parent::Redirect('/dashboard');
        }

        $configuration = new Configuration(array('RECIPEPERPAGE' => $recipeperpage, 'THEME' => $theme, "THEMEINGREDIENT" => $themeingredient));

        ConfigurationManager::update($configuration);

        $_SESSION['success'] = "La configuration du site a été modifiée.";
        parent::Redirect('/dashboard');
    }

    /**
     * Ajoute un ingrédient.
     */
    private function addIngredient()
    {
        $img = $this->getImg('imgaddingredient');

        $name = filter_var($_POST['name-add'], FILTER_SANITIZE_STRING);
        if(strlen($name) < 3 || strlen($name) > 60)
        {
            $_SESSION['error'] = "Le nom de l'ingrédient doit contenir 3 à 60 caractères.";
            parent::Redirect('/dashboard');
        }

        if(empty($_POST['type-add']))
        {
            $category = filter_var($_POST['category-add'], FILTER_SANITIZE_STRING);
        }
        else
        {
            $category = $_POST['type-add'];
        }
        if(strlen($category) < 3 || strlen($category) > 60)
        {
            $_SESSION['error'] = "Le catégorie de l'ingrédient  doit contenir 3 à 60 caractères.";
            parent::Redirect('/dashboard');
        }

        $ingredient = new Ingredient(array('NAME' => $name, 'CATEGORY' => $category,  'IMG' => $img));
        IngredientManager::add($ingredient);

        $_SESSION['success'] = "L'ingredient " . $name . " a été ajouté.";
        parent::Redirect('/dashboard');
    }

    /**
     * Modifie un ingrédient.
     */
    private function editIngredient()
    {
        if(empty($_POST['ing-edit']))
        {
            $_SESSION['error'] = "Vous devez choisir un ingrédient à modifier.";
            parent::Redirect('/dashboard');
        }
        $id = $_POST['ing-edit'];

        $ingredient = IngredientManager::getIngredient($id);

        $img = $this->getImg('imgeditingredient', $ingredient);

        $name = filter_var($_POST['name-edit'], FILTER_SANITIZE_STRING);
        if(strlen($name) < 3 || strlen($name) > 60)
        {
            $_SESSION['error'] = "Le nom de l'ingrédient doit contenir 3 à 60 caractères.";
            parent::Redirect('/dashboard');
        }
        if(!empty($_POST['category-edit']))
        {
            $category = filter_var($_POST['category-edit'], FILTER_SANITIZE_STRING);
        }
        else
        {
            $category = $_POST['type-edit'];
        }
        if(strlen($category) < 3 || strlen($category) > 60)
        {
            $_SESSION['error'] = "Le catégorie de l'ingrédient  doit contenir 3 à 60 caractères.";
            parent::Redirect('/dashboard');
        }

        $data = array('NAME' => $name, 'CATEGORY' => $category,  'IMG' => $img);
        $ingredient = new Ingredient($data);

        IngredientManager::edit($id, $ingredient);

        $_SESSION['success'] = "L'ingredient a été modifié.";
        parent::Redirect('/dashboard');
    }

    /**
     * Supprime un ingrédient.
     */
    private function deleteIngredient()
    {
        if(empty($_POST['ing-delete']))
        {
            $_SESSION['error'] = "Vous devez choisir un ingrédient à supprimer.";
            parent::Redirect('/dashboard');
        }

        IngredientManager::delete($_POST['ing-delete']);

        $_SESSION['success'] = "L'ingredient a bien été supprimé.";
        parent::Redirect('/dashboard');
    }

    /**
     * Ajoute un membre.
     */
    private function addUser()
    {
        $username = filter_var($_POST['username-add'], FILTER_SANITIZE_STRING);
        if(strlen($username) < 3 || strlen($username) > 30)
        {
            $_SESSION['error'] = "Le nom de l'utilisateur doit contenir 3 à 30 caractères.";
            parent::Redirect('/dashboard');
        }
        if(UserManager::checkUsername($username))
        {
            $_SESSION['error'] = "Ce nom de compte est déjà utilisé.";
            parent::Redirect('/dashboard');
        }

        $email = $_POST['email-add'];
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
        {
            $_SESSION['error'] = 'L\'adresse e-mail doit être valide.';
            parent::Redirect('/dashboard');
        }
        if(UserManager::checkEmail($email))
        {
            $_SESSION['error'] = "Cette adresse email est déjà utilisée.";
            parent::Redirect('/dashboard');
        }

        $role = $_POST['role-add'];
        if(empty($role))
        {
            $_SESSION['error'] ='L\'utilisateur doit avoir un rôle.';
            parent::Redirect('/dashboard');
        }

        UserManager::add($username, $email, $role);


        $code = parent::RandomString();

        //Le code devrais être renseigné en md5 pour plus de sécurité mais étant donné que les mails sont restreint...
        UserManager::createToken($email, $code);

        //Impossible d'envoyer un mail html sans mettre de cb donc on evoie que le code à mettre sur /login/recover
        mail($email, "Création de votre compte - Cook & Burn", $code);

        $_SESSION['success'] = "Un mail été envoyé au nouvel utilisateur afin qu'il définisse son mot de passe et que le compte soit utilisable.";
        parent::Redirect('/dashboard');
    }

    /**
     * Modifie un utilisateur.
     */
    private function editUser()
    {
        if(empty($_POST['user-edit']))
        {
            $_SESSION['error'] = "Vous devez choisir un utilisateur à modifier.";
            parent::Redirect('/dashboard');
        }
        $user = UserManager::getUser($_POST['user-edit']);

        $username = filter_var($_POST['username-edit'], FILTER_SANITIZE_STRING);
        $email = $_POST['email-edit'];
        $role =$_POST['role-edit'];

        $infochanged = false;

        if($username != $user->getUsername())
        {
            if(strlen($username) < 2 || strlen($username) > 30)
            {
                $_SESSION['error'] = 'Le nouveau nom de profil de '. $user->getUsername() .' doit contenir 2 à 30 caractères.';
                parent::Redirect('/dashboard');
            }
            if(UserManager::checkUsername($username))
            {
                $_SESSION['error'] = "Ce nom de compte est déjà utilisé.";
                parent::Redirect('/dashboard');
            }
            UserManager::changeUserame($username, $user->getId());
            $infochanged = true;
        }
        if($email != $user->getEmail())
        {
            if(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
            {
                $_SESSION['error'] = 'La nouvelle adresse e-mail de '. $user->getUsername() .' doit être valide.';
                parent::Redirect('/dashboard');
            }
            if(UserManager::checkEmail($email))
            {
                $_SESSION['error'] = "Cette adresse email est déjà utilisée.";
                parent::Redirect('/dashboard');
            }
            UserManager::changeEmail($email, $user->getId());
            $infochanged = true;
        }
        if($role != $user->getRole())
        {
            if(empty($role))
            {
                $_SESSION['error'] = $user->getUsername() .' doit avoir un rôle.';
                parent::Redirect('/dashboard');
            }
            UserManager::changeRole($role, $user->getId());
            $infochanged = true;
        }

        if($infochanged)
            $_SESSION['success'] = 'Les information de '. $user->getUsername() .' ont bien été mis à jour';
        $this->Redirect('/dashboard');
    }

    /**
     * Supprime un utilisateur.
     */
    private function deleteUser()
    {
        if(empty($_POST['user-delete']))
        {
            $_SESSION['error'] = "Vous devez choisir un utilisateur à supprimer.";
            parent::Redirect('/dashboard');
        }

        $user = UserManager::getUser($_POST['user-delete']);

        UserManager::delete($user->getId());

        $_SESSION['success'] = "L'utilisateur a bien été supprimé.";
        parent::Redirect('/dashboard');
    }

    /**
     * @param $file string
     * @param null $ingredient
     * @return string Url de l'image (retourne la même ou celle par defaut si non modifié, sinon l'url noelshack)
     */
    private function getImg($file, $ingredient = null)
    {
        if(isset($_FILES[$file]) && $_FILES[$file]['error'] != UPLOAD_ERR_NO_FILE)
        {
            $size = getimagesize($_FILES[$file]['tmp_name']);
            if($size[0] != $size[1])
            {
                $_SESSION['error'] = "L'image de l'ingrédient doit être carrée.";
                parent::Redirect('/dashboard');
            }
            $img = $this->UploadImg($file);
            if(filter_var($img , FILTER_VALIDATE_URL) === false)
            {
                $_SESSION['error'] = "Le format de l'image est incorrect.";
                parent::Redirect('/dashboard');
            }
            return $img;
        }
        else
        {
            if(!is_null($ingredient))
                return $ingredient->getImg();
            else
                return "https://nsa39.casimages.com/img/2018/10/25/181025093618202082.png";
        }
    }
}