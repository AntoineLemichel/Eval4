<?php

declare(strict_types=1);

class Account
{
    // Propriétés et méthodes de votre classe ici

    protected $id;
    protected $name;
    protected $balance;

    /**
     * Construct for Account.
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->hydrate($array);
    }

    /**
     * Hydrate method for setters properties Account.
     *
     * @param array $array
     *
     * @return self
     */
    public function hydrate(array $array)
    {
        foreach ($array as $key => $value) {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * GETTERS.
     */

    /**
     * Getters for Id.
     *
     * @return self
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getters for name.
     *
     * @return self
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Getters for balance.
     *
     * @return self
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * SETTERS.
     */

    /**
     * Setters for Id.
     *
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $id = (int) $id;
        if (is_int($id)) {
            $this->id = $id;

            return $this;
        }
    }

    /**
     * Setters for name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name)
    {
        $name = (string) $name;

        if (is_string($name)) {
            $this->name = $name;

            return $this;
        }
    }

    /**
     * Setters for balance.
     *
     * @param int $balance
     *
     * @return self
     */
    public function setBalance($balance)
    {
        $balance = (int) $balance;

        if (is_int($balance)) {
            $this->balance = $balance;

            return $this;
        }
    }
}
