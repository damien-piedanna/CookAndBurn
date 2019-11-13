<?php
require_once ('views/View.php');
require_once ('Controller.php');

/**
 * Class Router
 * Relis la requête de l'utilisateur avec le bon controller.
 */
class Router
{
    /**
     * @var controller Controller chargé.
     */
    private $_controller;
    /**
     * @var view Vue généré par le router.
     */
    private $_view;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        try
        {
            //Chargement auto des classes.
            spl_autoload_register(function($class){
                if(file_exists('models/' . $class . '.php'))
                require_once('models/' . $class . '.php');
            });

            $url = null;

            // Si il y a une demande spécifique après l'url du site.
            // Cas normal : Le controller sera égal au premier mot après le / (ex : notresite.fr/salut chargera le controller salut).
            if(isset($_GET['url']))
            {
                $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));

                //Exception pour la page d'index pour avoir des url propre du genre notresite/4 pour être sur la page 4 des recettes
                if(count($url) == 1 && is_numeric($url[0]))
                {
                    if((int)$url[0] == $url[0] && $url[0] > 0)
                    {
                        require_once('controllers/IndexController.php');
                        $this->_controller = new IndexController($url);
                        exit();
                    }
                }

                $controller = ucfirst(strtolower($url[0]));
                $controllerClass =  $controller . "Controller";
                $controllerFile = "controllers/" . $controllerClass . ".php";

                if(file_exists($controllerFile))
                {
                    require_once($controllerFile);
                    $this->_controller = new $controllerClass($url);
                }
                else
                {
                    throw new Exception('Page introuvable');
                }
            }
            else //index
            {
                require_once ('controllers/IndexController.php');
                $this->_controller = new IndexController(null);
            }
        }
        catch(Exception $e)
        {
            $error = $e->getMessage();
            $this->_view = new View('Error', 'Cook & Burn | Erreur',array('error' => $error));
        }
    }
}