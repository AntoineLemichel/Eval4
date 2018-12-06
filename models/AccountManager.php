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

    /**
     * Remove account with ID.
     *
     * @param Account $account
     */
    public function removeAccount(Account $account)
    {
        $reqRemove = $this->getDb()->prepare('DELETE FROM accounts WHERE id = :id');
        $reqRemove->bindValue(':id', $account->getId(), PDO::PARAM_INT);
        $reqRemove->execute();
    }

    /**
     * Get account by ID.
     *
     * @param int $id
     *
     * @return new Account
     */
    public function getAccountById($id)
    {
        $reqAccountById = $this->getDb()->prepare('SELECT * FROM accounts WHERE id = :id');
        $reqAccountById->bindValue(':id', $id, PDO::PARAM_INT);
        $reqAccountById->execute();

        $dataAccount = $reqAccountById->fetch(PDO::FETCH_ASSOC);

        return new Account($dataAccount);
    }

    /**
     * Give a payment for account.
     *
     * @param Account $opponent
     */
    public function accountBalance(Account $opponent)
    {
        $reqPayment = $this->getDb()->prepare('UPDATE accounts SET balance = :balance WHERE id = :id');
        $reqPayment->bindValue(':id', $opponent->getId(), PDO::PARAM_INT);
        $reqPayment->bindValue(':balance', $opponent->getBalance(), PDO::PARAM_INT);
        $reqPayment->execute();
    }

    public function getAllName()
    {
        $arrayOfNames = [];
        $reqName = $this->getDb()->prepare('SELECT * FROM accounts');
        $reqName->execute();

        $dataNames = $reqName->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dataNames as $dataName) {
            $arrayOfNames[] = new Account($dataName);
        }

        return $arrayOfNames;
    }
}
