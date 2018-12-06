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

    /**
     * Getters for all accounts into database.
     *
     * @return array $arrayOfAccounts
     */
    public function getAccounts()
    {
        $arrayOfAccounts = [];
        $req_accounts = $this->getDb()->prepare('SELECT * FROM accounts');

        $req_accounts->execute();
        $dataAccounts = $req_accounts->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dataAccounts as $dataAccount) {
            $arrayOfAccounts[] = new Account($dataAccount);
        }

        return $arrayOfAccounts;
    }

    // public function getName(Account $name)
    // {
    //     $arrayOfName = [];
    //     $req_name = $this->getDb()->prepare('SELECT * FROM accounts WHERE name = :name');
    //     $req_name->bindValue(':name', $name->getName(), PDO::PARAM_STR);

    //     $req_name->execute();
    // }

    /**
     * Adding a new account into database.
     *
     * @param Account $opponent
     */
    public function addAccount(Account $opponent)
    {
        $reqAccount = $this->getDb()->prepare('INSERT INTO accounts (name, balance) VALUES (:name, :balance)');
        $reqAccount->bindValue(':name', $opponent->getName(), PDO::PARAM_STR);
        $reqAccount->bindValue(':balance', $opponent->getBalance(), PDO::PARAM_INT);

        $reqAccount->execute();
    }

    public function removeAccount(Account $account)
    {
        $reqRemove = $this->getDb()->prepare('DELETE FROM accounts WHERE id = :id');
        $reqRemove->bindValue(':id', $account->getId(), PDO::PARAM_INT);
        $reqRemove->execute();
    }

    public function getAccountById($id)
    {
        $reqAccountById = $this->getDb()->prepare('SELECT * FROM accounts WHERE id = :id');
        $reqAccountById->bindValue(':id', $id, PDO::PARAM_INT);
        $reqAccountById->execute();

        $dataAccount = $reqAccountById->fetch(PDO::FETCH_ASSOC);

        $account = new Account($dataAccount);

        return $account;
    }
}
