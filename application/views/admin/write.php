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

	<div class="form-group <?php form_error('title') and print('has-error'); ?>">
		<label for="title">Titre :</label>
		<input type="text" name="title" id="title" class="form-control" value="<?=set_value('title', isset($PR['title'])?$PR['title']:"")?>" />
	</div>
	
	<?php if(isset($isPage)): ?>
		<div class="form-group <?php form_error('slug') and print('has-error'); ?>">
			<label for="slug">Adresse :</label>
			<input type="text" name="slug" id="slug" class="form-control" value="<?=set_value('slug', isset($PR['slug'])?$PR['slug']:"")?>" />
			<p class="help-block">L'adresse de la page. Par exemple, entrer <strong>informations/exemple</strong> rendra la page disponible à <strong><?=BASE_URL?>/informations/exemple</strong>.</p>
		</div>
	<?php endif; ?>
	
	<div class="form-group <?php form_error('lead') and print('has-error'); ?>">
		<label for="lead">Introduction :</label>
		<textarea name="lead" id="lead" class="form-control autosize" rows="2"><?=set_value('lead', isset($PR['lead'])?$PR['lead']:"")?></textarea>
		<p class="help-block">Le paragraphe d'introduction est placé juste après le titre, dans l'en-tête du site.</p>
	</div>
	
	<div class="form-group <?php form_error('content') and print('has-error'); ?>">
		<label for="lead">Contenu :</label>
		<textarea name="content" id="content" class="form-control autosize tinymce" rows="10"><?=set_value('content', isset($PR['content'])?$PR['content']:"")?></textarea>
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
	language_url: "<?=ASSETS_URL?>/javascript/tinymce/fr_FR.js",
	relative_urls: false,
	remove_script_host: false
});
</script>