<!DOCTYPE html>
<html>

<head>
	<title>Connexion</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" type="text/css" href="<?=ASSETS_URL?>/bootstrap/css/bootstrap_admin.css" />
	
	<style type="text/css">
	body {
		background: url('<?=ASSETS_URL?>/images/triangular.png');
	}
	form {
		max-width: 300px;
		margin: 50px auto;
		padding: 15px;
		background-color: #FFF;
		border-radius: 3px;
		box-shadow: 1px 1px 2px #666;
	}
	</style>
</head>

<body>

<form method="post">
	
	<?php # Lecture des messages flash
		readFlash(); ?>

	<h4>Connexion @AEFSUM.ca</h4>
	
	<div class="form-group">
		<label for="log_username">Nom d'utilisateur :</label>
		<input type="text" name="log_username" id="log_username" class="form-control" />
	</div>
	
	<div class="form-group">
		<label for="log_password">Mot de passe :</label>
		<input type="password" name="log_password" id="log_password" class="form-control" />
	</div>
	
	<div class="checkbox">
		<label><input type="checkbox" name="keep-me-in" /> Se souvenir de moi</label>
	</div>
	
	<div class="text-center"><button type="submit" class="btn btn-primary">Connexion</button></div>
	
</form>

<!-- jQuery -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

<!-- Plugins Bootstrap -->
<script type="text/javascript" src="<?=ASSETS_URL?>/bootstrap/js/bootstrap.min.js"></script>

</body>