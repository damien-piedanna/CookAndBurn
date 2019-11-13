<?php
require_once ('views/View.php');

/**
 * Class Controller
 * Classe abstraite des controllers.
 */
abstract class Controller
{
    /**
     * @var string Vue chargée par le controller.
     */
    protected $_view;

    /**
     * Redirige proprement l'utilisateur vers une page du site.
     * @param string $url Destination de la rediriction.
     * @param bool $permanent La redirection est temporaire ou non ?
     */
    public function Redirect($url, $permanent = true)
    {
        if (headers_sent() === false)
        {
            header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
        }
        exit();
    }

    /**
     * Génère un string aléatoirement.
     * @author https://stackoverflow.com/questions/4356289/php-random-string-generator
     * @param integer $length Nombre de caractère du string générer.
     * @return string
     */
    protected function RandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    /**
     * Upload une image sur noelshack et renvoie son url.
     * @param $img string Nom de l'image dans le cache.
     * @return string
     */
    protected function UploadImg($img)
    {
        $ch = curl_init();

        $file = new CURLFile($_FILES[$img]['tmp_name'], $_FILES[$img]['type'], $_FILES[$img]['name']);
        $data = array('fichier' => $file);

        curl_setopt($ch, CURLOPT_URL, 'http://www.noelshack.com/api.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $url = curl_exec($ch);

        $imgtemp = substr($url, 25, strlen($url));
        $nb = 0;
        for ($i = 1; $i <= strlen($imgtemp); $i++)
        {
            if($imgtemp[$i] == '-')
            {
                $imgtemp[$i] = '/';
                $nb++;
                if($nb == 3)
                    break;
            }
        }
        return 'http://image.noelshack.com/fichiers/' . $imgtemp;
    }
}