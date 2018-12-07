<?php

include 'includes/header.php';
?>

<div class="container">

	<header class="flex">
		<p class="margin-right">Bienvenue sur l'application Comptes Bancaires</p>
	</header>

	<h1>Mon application bancaire</h1>

	<form class="newAccount" action="index.php" method="post">
		<label>Sélectionner un type de compte</label>
		<select class="" name="name" required>
			<option value="" disabled>Choisissez le type de compte à ouvrir</option>
			<?php // Listez les options possibles à choisir (compte courant, PEL, etc.)?>
			<option value="name_courant">Compte courant</option>
			<option value="name_pel">PEL</option>
			<option value="name_livret">Livret A</option>
			<option value="name_joint">Compte joint</option>
		</select>
		<input type="submit" name="new" value="Ouvrir un nouveau compte">
	</form>
<?php
if (isset($message)) {
    echo '<p>'.$message.'</p>';
}
?>
	<hr>

	<div class="main-content flex">

	<!-- Pour chaque compte enregistré en base de données, il faudra générer le code ci-dessous -->

	<?php foreach ($accounts as $account) {
    ?>

		<div class="card-container">

			<div class="card">
				<h3><strong><?= $account->getName(); ?></strong></h3>
				<div class="card-content">


					<p>Somme disponible : <?= $account->getBalance(); ?> €</p>

					<!-- Formulaire pour dépot/retrait -->
					<h4>Dépot / Retrait</h4>
					<form action="index.php" method="post">
						<input type="hidden" name="id" value=" <?= $account->getId(); ?>"  required>
						<label>Entrer une somme à débiter/créditer</label>
						<input type="number" name="balance" placeholder="Ex: 250" required>
						<input type="submit" name="payment" value="Créditer">
						<input type="submit" name="debit" value="Débiter">
					</form>


					<!-- Formulaire pour virement -->
			 		<form action="index.php" method="post">

						<h4>Transfert</h4>
						<label>Entrer une somme à transférer</label>
						<input type="number" name="balance" placeholder="Ex: 300"  required>
						<input type="hidden" name="idDebit" value="<?= $account->getId(); ?>" required>
						<label for="">Sélectionner un compte pour le virement</label>
						<select name="idPayment" required>
							<option disabled>Choisir un compte</option>
							<?php
                                foreach ($accounts as $account) {
                                    ?>
									<option value="<?= $account->getId(); ?>"><?= $account->getName(); ?></option>
									<?php
                                } ?>
						</select>
						<input type="submit" name="transfer" value="Transférer l'argent">
					</form>

					<!-- Formulaire pour suppression -->
			 		<form class="delete" action="index.php" method="post">
				 		<input type="hidden" name="id" value="<?= $account->getId(); ?>"  required>
				 		<input type="submit" name="delete" value="Supprimer le compte">
			 		</form>

				</div>
			</div>
		</div>

	<?php
}?>

	</div>

</div>

<?php

include 'includes/footer.php';

 ?>
