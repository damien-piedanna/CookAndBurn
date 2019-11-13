<?php

/**
 * Class Ingredient
 */
class Ingredient
{
    /**
     * @var int
     */
    private $_id;
    /**
     * @var string
     */
    private $_name;
    /**
     * @var string
     */
    private $_category;
    /**
     * @var string
     */
    private $_img;

    /**
     * Ingredient constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * Lance tout les setters
     * @param array $data[mixed]
     */
    public function hydrate(array $data)
    {
        foreach($data as $key => $value)
        {
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
     * @param mixed $name
     */
    public function setName($name)
    {
        if(is_string($name))
            $this->_name = $name;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        if(is_string($category))
            $this->_category = $category;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        if(is_string($img))
            $this->_img = $img;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
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
    public function getCategory()
    {
        return $this->_category;
    }

    /**
     * @return string
     */
    public function getImg()
    {
        return $this->_img;
    }
}