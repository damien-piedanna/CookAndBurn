<?php

/**
 * Class View
 * Génère la page.
 */
class View
{
    /**
     * @var string Fichier de la vue
     */
    private $_file;

    /**
     * @var string Nom de la vue
     */
    private $_view;

    /**
     * @var string Titre de la page
     */
    private $_title;

    /**
     * @var array[mixed]
     */
    private $_data;

    /**
     * View constructor.
     * @param $view string
     * @param $title string
     * @param null $data
     * @throws
     */
    public function __construct($view, $title, $data = null)
    {
        $this->_file = 'views/' . $view . 'View.php';
        $this->_view = $view;
        $this->_title = $title;
        $this->_data = $data;

        $this->generate();
    }

    /**
     * Génére et affiche la vue
     * @throws Exception
     */
    private function generate()
    {
        //Contenu de la page
        $content = $this->generateFile($this->_file, $this->_data);

        $view = $this->generateFile('views/assets/template.php', array('title' => $this->_title, 'content' => $content, 'view' => $this->_view, 'data' => $this->_data));

        echo $view;
    }

    /**
     * Genere un fichier vue et renvoie le resultat produit
     * @param $file
     * @param $data
     * @return false|string
     * @throws Exception
     */
    private function generateFile($file, $data)
    {
        if(file_exists($file))
        {
            if(!is_null($data))
                extract($data);

            ob_start();
            require $file;
            return ob_get_clean();
        }
        else
        {
            throw new Exception('Fichier ' . $file . ' introuvable');
        }
    }
}