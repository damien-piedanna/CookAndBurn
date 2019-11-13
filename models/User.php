<?php

/**
 * Class User
 */
class User
{
    /**
     * @var int
     */
    private $_id;
    /**
     * @var string
     */
    private $_username;
    /**
     * @var string
     */
    private $_email;
    /**
     * @var string
     */
    private $_password;
    /**
     * @var string
     */
    private $_role;

    /**
     * User constructor.
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
     * @param mixed $username
     */
    public function setUsername($username)
    {
        if(is_string($username))
            $this->_username = $username;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        if(is_string($email))
            $this->_email = $email;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        if(is_string($role))
            $this->_role = $role;
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
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->_role;
    }
}