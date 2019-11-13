<?php

/**
 * Class Recipe
 */
class Recipe
{
    /**
     * @var int
     */
    private $_id;
    /**
     * @var User
     */
    private $_author;
    /**
     * @var string
     */
    private $_name;
    /**
     * @var string
     */
    private $_img;
    /**
     * @var int
     */
    private $_nbPers;
    /**
     * @var string
     */
    private $_shortDesc;
    /**
     * @var string
     */
    private $_longDesc;
    /**
     * @var string
     */
    private $_steps;
    /**
     * @var array[Composition]
     */
    private $_compositions;
    /**
     * @var int
     */
    private $_nbBurn;
    /**
     * @var int
     */
    private $_nbFav;
    /**
     * @var string
     */
    private $_status;
    /**
     * @var string
     */
    private $_date;
    /**
     * @var bool
     */
    private $_isBurned;
    /**
     * @var bool
     */
    private $_isFav;
    /**
     * @var string
     */
    private $_annotation;

    /**
     * Recipe constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
        $this->setNbBurn($this->getId());
        $this->setNbFav($this->getId());
        $this->setStatus($data['STATUS']);
        $this->setCompositions($this->getId());
        $this->setIsBurned();
        $this->setIsFav();
        $this->setAnnotation();
    }

    /**
     * Lance tout les setters
     * @param array $data[mixed]
     */
    public function hydrate(array $data)
    {
        foreach($data as $key => $value)
        {
            if($key == "status")
                continue;
            $method = 'set' . ucfirst($key);

            if(method_exists($this, $method))
                $this->$method($value);
        }
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $id = (int) $id;
        if($id > 0)
            $this->_id = $id;
    }

    /**
     * @param $authorid
     */
    public function setAuthor($authorid)
    {
        $this->_author = RecipeManager::getAuthor($authorid);
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        if(is_string($name))
            $this->_name = $name;
    }

    /**
     * @param mixed $name
     */
    public function setImg($img)
    {
        if(is_string($img))
            $this->_img = $img;
    }

    /**
     * @param mixed $nbPers
     */
    public function setNbPers($nbPers)
    {
        $nbPers = (int) $nbPers;
        if($nbPers > 0)
            $this->_nbPers = $nbPers;
    }

    /**
     * @param mixed $shortDesc
     */
    public function setShortDesc($shortDesc)
    {
        if(is_string($shortDesc))
            $this->_shortDesc = $shortDesc;
    }

    /**
     * @param mixed $longDesc
     */
    public function setLongDesc($longDesc)
    {
        if(is_string($longDesc))
            $this->_longDesc = $longDesc;
    }

    /**
     * @param mixed $steps
     */
    public function setSteps($steps)
    {
        if(is_string($steps))
            $this->_steps = $steps;
    }

    /**
     * Définis la composition de la recette.
     * @param $id
     */
    public function setCompositions($id)
    {
        $this->_compositions = RecipeManager::getCompositions($id);
    }

    /**
     * @param mixed $id
     */
    public function setNbBurn($id)
    {
        $this->_nbBurn = RecipeManager::getBurn($id);
    }

    /**
     * @param mixed $id
     */
    public function setNbFav($id)
    {
        $this->_nbFav = RecipeManager::getFav($id);
    }

    /**
     * Défini le statut de la recette.
     * @param mixed $status
     */
    public function setStatus($status)
    {
        if($status == "public" && $this->_nbBurn < 10)
            $this->_status = "limited";
        else
            $this->_status = $status;
    }

    /**
     * @param mixed $date
     * @author JeremyB https://www.grafikart.fr/forum/topics/12260
     */
    public function setDate($date)
    {
        $now = time();
        $created = strtotime($date);
        // La différence est en seconde
        $diff = $now-$created;
        $m = ($diff)/(60); // on obtient des minutes
        $h = ($diff)/(60*60); // ici des heures
        $j = ($diff)/(60*60*24); // jours
        $s = ($diff)/(60*60*24*7); // et semaines
        if ($diff < 60) { // "il y a x secondes"
            $this->_date = 'Il y a '.$diff.' secondes';
        }
        elseif ($m < 60) { // "il y a x minutes"
            $minute = (floor($m) == 1) ? 'minute' : 'minutes';
            $this->_date = 'Il y a '.floor($m).' '.$minute;
        }
        elseif ($h < 24) { // " il y a x heures, x minutes"
            $heure = (floor($h) <= 1) ? 'heure' : 'heures';
            $dateFormated = 'Il y a '.floor($h).' '.$heure;
            if (floor($m-(floor($h))*60) != 0) {
                $minute = (floor($m) == 1) ? 'minute' : 'minutes';
                $dateFormated .= ', '.floor($m-(floor($h))*60).' '.$minute;
            }
            $this->_date = $dateFormated;
        }
        elseif ($j < 7) { // " il y a x jours, x heures"
            $jour = (floor($j) <= 1) ? 'jour' : 'jours';
            $dateFormated = 'Il y a '.floor($j).' '.$jour;
            if (floor($h-(floor($j))*24) != 0) {
                $heure = (floor($h) <= 1) ? 'heure' : 'heures';
                $dateFormated .= ', '.floor($h-(floor($j))*24).' '.$heure;
            }
            $this->_date = $dateFormated;
        }
        elseif ($s < 5) { // " il y a x semaines, x jours"
            $semaine = (floor($s) <= 1) ? 'semaine' : 'semaines';
            $dateFormated = 'Il y a '.floor($s).' '.$semaine;
            if (floor($j-(floor($s))*7) != 0) {
                $jour = (floor($j) <= 1) ? 'jour' : 'jours';
                $dateFormated .= ', '.floor($j-(floor($s))*7).' '.$jour;
            }
            $this->_date = $dateFormated;
        }
        else { // on affiche la date normalement
            $this->_date = strftime("%d %B %Y à %H:%M", $created);
        }
    }

    /**
     * La recette est-elle burn par l'utilisateur connecté ?
     */
    public function setIsBurned()
    {
        if ($_SESSION['logged'])
            $this->_isBurned = RecipeManager::isBurned($this->getId(), $_SESSION['id']);
        else
            $this->_isBurned = false;
    }

    /**
     * La recette est-elle fav par l'utilisateur connecté ?
     */
    public function setIsFav()
    {
        if ($_SESSION['logged'])
            $this->_isFav = RecipeManager::isFav($this->getId(), $_SESSION['id']);
        else
            $this->_isFav = false;
    }

    /**
     * Récupère l'annotation de l'utilisateur connectée si il en a mis une.
     */
    public function setAnnotation()
    {
        if ($_SESSION['logged'])
            $this->_annotation = RecipeManager::getAnnotation($this->getId(), $_SESSION['id']);
        else
            $this->_annotation = null;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->_author;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getImg()
    {
        return $this->_img;
    }

    /**
     * @return int
     */
    public function getNbPers()
    {
        return $this->_nbPers;
    }

    /**
     * @return string
     */
    public function getShortDesc()
    {
        return $this->_shortDesc;
    }

    /**
     * @return string
     */
    public function getLongDesc()
    {
        return $this->_longDesc;
    }

    /**
     * @return string
     */
    public function getSteps()
    {
        return $this->_steps;
    }

    /**
     * @return array[Ingredient, quantity]
     */
    public function getCompositions()
    {
        return $this->_compositions;
    }

    /**
     * @return int
     */
    public function getNbBurn()
    {
        return $this->_nbBurn;
    }

    /**
     * @return int
     */
    public function getNbFav()
    {
        return $this->_nbFav;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
    * @return bool
    */
    public function getisBurned()
    {
        return $this->_isBurned;
    }

    /**
     * @return bool
     */
    public function getisFav()
    {
        return $this->_isFav;
    }

    /**
     * @return string
     */
    public function getAnnotation()
    {
        return $this->_annotation;
    }
}