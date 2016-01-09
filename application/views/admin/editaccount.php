<?php if(trim(validation_errors())): ?>
	<div class="alert alert-danger fade in">
		<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
		<h4>Il y a des erreurs dans le formulaire</h4>
		<ul>
			<?=validation_errors()?>
		</ul>
	</div>
<?php endif; ?>

<form method="post">

	<div class="form-group <?php form_error('username') and print('has-error'); ?>">
		<label for="username">Nom d'utilisateur :</label>
		<input type="text" name="username" id="username" class="form-control" value="<?=set_value('username', isset($PR['username'])?$PR['username']:"")?>" />
	</div>

	<div class="form-group <?php form_error('password') and print('has-error'); ?>">
		<label for="password">Mot de passe :</label>
		<input type="password" name="password" id="password" class="form-control" />
		<?php if($isEdit): ?><p class="help-block">Ne remplissez ce champ que si vous voulez changer le mot de passe du compte.</p><?php endif; ?>
	</div>

	<div class="form-group <?php form_error('usualname') and print('has-error'); ?>">
		<label for="usualname">Nom à afficher :</label>
		<input type="text" name="usualname" id="usualname" class="form-control" value="<?=set_value('usualname', isset($PR['usualname'])?$PR['usualname']:"")?>" />
	</div>
	
	<div class="form-group <?php form_error('usualname') and print('has-error'); ?>">
		<label>Droits :</label>
		<div>
			<div class="radio-inline">
				<label style="font-weight:normal">
					<input type="radio" name="isadmin" value="true" <?=set_radio('isadmin', 'true', isset($PR['isadmin'])&&$PR['isadmin']==1)?> />
					Administration
				</label>
			</div>
			<div class="radio-inline">
				<label style="font-weight:normal">
					<input type="radio" name="isadmin" value="false" <?=set_radio('isadmin', 'false', isset($PR['isadmin'])&&$PR['isadmin']==0)?> />
					Rédaction
				</label>
			</div>
		</div>
	</div>
	
	<?php insert_csrf_token(); ?>
	<div class="form-group text-center"><button type="submit" class="btn btn-primary">Sauvegarder</button></div>

</form>


<script src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
	selector: "textarea.tinymce",
	plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste"
	],
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	language_url: "<?=ASSETS_URL?>/javascript/tinymce/fr_FR.js"
});
</script>