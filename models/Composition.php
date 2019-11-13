<?php

/**
 * Class Composition
 * Représente un ingrédient dans une recette et dans quelle quantité.
 */
class Composition
{
    /**
     * @var int
     */
    private $_idrecipe;

    /**
     * @var int
     */
    private $_idingredient;

    /**
     * @var string
     */
    private $_quantity;

    /**
     * Composition constructor.
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
     * @param mixed $idrecipe
     */
    public function setIdrecipe($idrecipe)
    {
        $idrecipe = (int) $idrecipe;
        if($idrecipe > 0)
            $this->_idrecipe = $idrecipe;
    }

    /**
     * @param mixed $idingredient
     */
    public function setIdingredient($idingredient)
    {
        $idingredient = (int) $idingredient;
        if($idingredient > 0)
            $this->_idingredient = $idingredient;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        if(is_string($quantity))
            $this->_quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getIdrecipe()
    {
        return $this->_idrecipe;
    }

    /**
     * @return int
     */
    public function getIdingredient()
    {
        return $this->_idingredient;
    }

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

}