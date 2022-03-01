<?php session_start(); ?>
<?php
//on check si on rentre bien un pseudo et un mot de passe
if (isset($_POST['pseudo']) || isset($_POST['password'])) {
	//si ils existent, on les stocks
	$pseudo = $_POST['pseudo'];
	$pwd = $_POST['password'];


	//on met dans une variable la requête SQL
	$stmt2 = $mysqlClient->prepare("SELECT pseudo, password, id_users FROM users WHERE pseudo = :pseudo");
	//on remplace le pseudo de la requête par le pseudo que l'on a stocké
	$stmt2->bindParam(':pseudo', $pseudo);
	//on execute la requête
	$stmt2->execute();
	//on stock dans une variable les éléments de la requête (pseudo, password et id_users)
	$user = $stmt2->fetchAll();

	//si l'on a bien une valeur existante, que le pseudo de notre DB == au pseudo sauvegarder & que notre mdp de notre DB == mdp enregistré
	if (isset($user[0]) && $user[0]["password"] == password_verify($pwd, $user[0]["password"]) && $user[0]["pseudo"] == $pseudo) {
		//alors on stock l'id_users enregistré dans une variable globale
		$_SESSION['IS_LOGGED'] = $user[0]['id_users'];
		//vérification1
		$logged = $pseudo;
	} else {
		$errorMessage = "Vous vous êtes tromper d'identifiant.";
	}
}
?>

<!-- si notre vérification1 n'est pas valide on affiche le formulaire  -->
<?php if (!isset($logged)) : ?>
	<form method="POST" action="./login.php">
		<!-- si il y a un message d'erreur, alors on l'affiche -->
		<?php if (isset($errorMessage)) : ?>
			<div class="alert alert-danger" role="alert">
				<?php echo $errorMessage; ?>
			</div>
		<?php endif; ?>
		<div class="mb-3">
			<label for="pseudo" class="form-label">Pseudo</label>
			<input type="text" class="form-control" id="pseudo" name="pseudo">
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Mot de passe</label>
			<input type="password" class="form-control" id="password" name="password">
		</div>
		<button type="submit" class="btn btn-primary">Envoyer</button>
	</form>
	<!-- si il n'y a pas de message d'erreur, on affiche un message de bienvenu -->
<?php else : ?>
	<div class="alert alert-success" role="alert">
		Bonjour et bienvenue sur le site !
	</div>
	<a href="../messages/messages.php" class="btn btn-primary">Continuer vers vos messages</a>
<?php endif; ?>