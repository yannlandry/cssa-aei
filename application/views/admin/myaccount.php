<?php if(trim(validation_errors())): ?>
	<div class="alert alert-danger fade in">
		<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
		<h4>Il y a des erreurs dans le formulaire</h4>
		<ul>
			<?=validation_errors()?>
		</ul>
	</div>
<?php endif; ?>

<form method="post" class="form-horizontal">

	<div class="form-group <?php form_error('newpass') and print('has-error'); ?>">
		<label for="newpass" class="col-sm-3 control-label">Nouveau mot de passe :</label>
		<div class="col-sm-7">
			<input type="password" name="newpass" id="newpass" class="form-control" />
		</div>
	</div>

	<div class="form-group <?php form_error('confpass') and print('has-error'); ?>">
		<label for="confpass" class="col-sm-3 control-label">Confirmez le mot de passe :</label>
		<div class="col-sm-7">
			<input type="password" name="confpass" id="confpass" class="form-control" />
		</div>
	</div>

	<div class="form-group <?php form_error('oldpass') and print('has-error'); ?>">
		<label for="oldpass" class="col-sm-3 control-label">Ancien mot de passe :</label>
		<div class="col-sm-7">
			<input type="password" name="oldpass" id="oldpass" class="form-control" />
		</div>
	</div>
	
	<?php insert_csrf_token(); ?>
	<p class="text-center"><button type="submit" class="btn btn-primary">Changer</button></p>

</form>