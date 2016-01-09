<?php foreach($slides as $S): ?>
	<p class="text-right"><img src="<?=UPLOADS_URL.'/slider/'.$S?>" alt="<?=$S?>" class="img-thumbnail" />
	<br /><a href="<?=base_url('/admin/diaporama')?>?delete=<?=$S?>&csrf_token=<?=User::csrf_token()?>" class="btn btn-danger" style="position:relative;left:-10px;top:-45px;">Supprimer</a></p>
<?php endforeach; ?>


<hr />
<h2>Ajouter une diapositive</h2>

<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="file">Fichier :</label>
		<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		<input type="file" id="file" name="file" />
	</div>
	<div class="form-group text-center">
		<?php insert_csrf_token(); ?>
		<button type="submit" class="btn btn-primary">Envoyer</button>
	</div>
</form>