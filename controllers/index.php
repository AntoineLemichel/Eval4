<?php

// On enregistre notre autoload.
function chargerClasse($classname)
{
    if (file_exists('../models/'.$classname.'.php')) {
        require '../models/'.$classname.'.php';
    } else {
        require '../entities/'.$classname.'.php';
    }
}
spl_autoload_register('chargerClasse');

$db = Database::DB();

$accountManager = new AccountManager($db);
$accounts = $accountManager->getAccounts();

if (isset($_POST['new'])) {
    if ($_POST['name'] == 'name_courant') {
        $opponentAccountCourant = new Account([
            'name' => 'Compte courant',
            'balance' => 80,
        ]);
        $accountManager->addAccount($opponentAccountCourant);
    } else {
        $message = 'This account is not available.';
    }
    if ($_POST['name'] == 'name_pel') {
        $opponentAccountPel = new Account([
            'name' => 'PEL',
            'balance' => 80,
        ]);
        $accountManager->addAccount($opponentAccountPel);
    } else {
        $message = 'This account is not available.';
    }
    if ($_POST['name'] == 'name_livret') {
        $opponentAccountLivret = new Account([
            'name' => 'Livret A',
            'balance' => 80,
        ]);
        $accountManager->addAccount($opponentAccountLivret);
    } else {
        $message = 'This account is not available.';
    }
    if ($_POST['name'] == 'name_joint') {
        $opponentAccountJoint = new Account([
            'name' => 'Compte Joint',
            'balance' => 80,
        ]);
        $accountManager->addAccount($opponentAccountJoint);
    } else {
        $message = 'This account is not available.';
    }
}

if (isset($_POST['delete'])) {
    $id = (int) $_POST['id'];
    $opponentRemove = $accountManager->getAccountById($id);
    $accountManager->removeAccount($opponentRemove);
    header('Location: index.php');
}

if (isset($_POST['payment'])) {
    $id = (int) $_POST['id'];
    $balance = (int) $_POST['balance'];
    if (isset($_POST['balance']) and !empty($_POST['balance'])) {
        $balance = htmlspecialchars($balance);
        $account = $accountManager->getAccountById($id);
        $account->payment($balance);

        $payment = $accountManager->accountBalance($account);
        header('Location: index.php');
    } else {
        $message = 'You will must not send empty money';
    }
}

if (isset($_POST['debit'])) {
    $id = (int) $_POST['id'];
    $balance = (int) $_POST['balance'];
    if (isset($_POST['balance']) and !empty($_POST['balance'])) {
        $account = $accountManager->getAccountById($id);
        $balance = htmlspecialchars($balance);

        $account->debit($balance);

        $debit = $accountManager->accountBalance($account);
        header('Location: index.php');
    } else {
        $message = 'You will must not send empty money.';
    }
}

if (isset($_POST['transfer'])) {
    $idPayment = (int) $_POST['idPayment'];
    $idDebit = (int) $_POST['idDebit'];
    $balance = (int) $_POST['balance'];
    if ($idPayment != $idDebit) {
        $accountPayment = $accountManager->getAccountById($idPayment);
        $accountDebit = $accountManager->getAccountById($idDebit);

        $accountPayment->payment($balance);

        $accountDebit->debit($balance);

        $transferDebit = $accountManager->accountBalance($accountDebit);
        $transferPayment = $accountManager->accountBalance($accountPayment);
        header('Location: index.php');
    } else {
        $message = "You can't select your account.";
    }
}

include '../views/indexView.php';
