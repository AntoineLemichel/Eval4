<?php

declare(strict_types=1);

class AccountManager
{
    // propriétés et méthodes de votre manager ici

    private $_db;

    /**
     * Construct for AccountManager.
     *
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->setDb($db);
    }

    /**
     * Getters for Database.
     *
     * @return self
     */
    public function getDb()
    {
        return $this->_db;
    }

    /**
     * Setters for Database.
     *
     * @param PDO $_db
     *
     * @return self
     */
    public function setDb(PDO $_db)
    {
        $this->_db = $_db;

        return $this;
    }

    public function getAccounts()
    {
        $arrayOfAccounts = [];
        $req_accounts = $this->getDb()->query('SELECT * FROM accounts');

        $dataAccounts = $req_accounts->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dataAccounts as $dataAccount) {
            $arrayOfAccounts[] = new Account($dataAccount);
        }

        return $arrayOfAccounts;
    }
}
