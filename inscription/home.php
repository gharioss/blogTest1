<?php include_once('./global/variable.php'); ?>
<?php
if ((!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	|| !isset($_POST['pseudo']) || !isset($_POST['age']) || !isset($_POST['password'])
) {
	$errorMessage = "Vous devez rentrer des identifiants.";
} else {
	$email = $_POST['email'];
	$pseudo = $_POST['pseudo'];
	$pwd = $_POST['password'];
	$encrypt_pwd = password_hash($pwd, PASSWORD_DEFAULT);
	$age = $_POST['age'];

	$data = [
		'email' => $email,
		'pseudo' => $pseudo,
		'password' => $encrypt_pwd,
		'age' => $age,
	];

	$stmt = $mysqlClient->prepare("INSERT INTO users (email, pseudo, password, age) VALUES (:email, :pseudo, :password, :age)");
	$stmt->execute($data);
}
?>

<?php if (!isset($data)) : ?>
	<form method="POST" action="../index.php">
		<?php if (isset($errorMessage)) : ?>
			<div class="alert alert-danger" role="alert">
				<?php echo $errorMessage; ?>
			</div>
		<?php endif; ?>
		<div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input type="email" class="form-control" id="email" name="email" aria-describedly="email-help" placeholder="you@exemple.com">
		</div>
		<div class="mb-3">
			<label for="pseudo" class="form-label">Pseudo</label>
			<input type="text" class="form-control" id="pseudo" name="pseudo">
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Mot de passe</label>
			<input type="password" class="form-control" id="password" name="password">
		</div>
		<div class="mb-3">
			<label for="age" class="form-label">Âge</label>
			<input type="number" class="form-control" id="age" name="age">
		</div>
		<button type="submit" class="btn btn-primary">Envoyer</button>
	</form>
<?php else : ?>
	<div class="alert alert-success" role="alert">
		Bonjour et bienvenue sur le site !
	</div>
	<a href="../connexion/login.php" class="btn btn-primary">Continuer vers vos messages</a>
<?php endif; ?>