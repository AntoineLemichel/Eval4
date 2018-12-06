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

if (isset($_POST['new'])) {
    if ($_POST['name'] == 'name_courant') {
        $opponentAccountCourant = new Account([
            'name' => 'Compte courant',
            'balance' => 80,
        ]);
        $accountManager->addAccount($opponentAccountCourant);
        header('Location: index.php');
    } elseif ($_POST['name'] == 'name_pel') {
        $opponentAccountPel = new Account([
            'name' => 'PEL',
            'balance' => 80,
        ]);
        $accountManager->addAccount($opponentAccountPel);
        header('Location: index.php');
    } elseif ($_POST['name'] == 'name_livret') {
        $opponentAccountLivret = new Account([
            'name' => 'Livret A',
            'balance' => 80,
        ]);
        $accountManager->addAccount($opponentAccountLivret);
        header('Location: index.php');
    } elseif ($_POST['name'] == 'name_joint') {
        $opponentAccountJoint = new Account([
            'name' => 'Compte Joint',
            'balance' => 80,
        ]);
        $accountManager->addAccount($opponentAccountJoint);
        header('Location: index.php');
    } else {
        $message = 'This account is not available.';
    }
}

    if (isset($_POST['delete'])) {
        echo 'toto';
        $id = (int) $_POST['id'];
        $opponentRemove = $accountManager->getAccountById($id);
        $accountManager->removeAccount($opponentRemove);
        header('Location: index.php');
    }

$accounts = $accountManager->getAccounts();

include '../views/indexView.php';
