<div class="pictures">
	<?php foreach($pictures as $P): ?>
		<a href="" data-image="<?=$P?>" data-toggle="modal" data-target="#infoModal">
			<img src="<?=get_upload($P, 200, 200, false)?>" alt="<?=$P?>" class="img-thumbnail" />
		</a>
	<?php endforeach; ?>
</div>


<hr />
<h2>Mettre une image en ligne</h2>

<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="file">Image :</label>
		<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
		<input type="file" id="file" name="file" />
	</div>
	<div class="form-group text-center">
		<?php insert_csrf_token(); ?>
		<button type="submit" class="btn btn-primary">Envoyer</button>
	</div>
</form>


<div class="modal fade" id="infoModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Informations sur l'image</h4>
			</div>
			<div class="modal-body text-center">
				<p><a href="" id="modalFullLink" target="_blank" title="Agrandir l'image"><img src="" alt="" id="modalImage" class="img-thumbnail" /></a></p>
				<p>Adresse pour l'insertion :
				<br /><input type="text" readonly="readonly" id="modalInput" class="form-control" /></p>
			</div>
			<div class="modal-footer">
				<a href="" id="deleteButton" class="btn btn-danger">Supprimer</a>
				<a href="" class="btn btn-default" data-dismiss="modal">Fermer</a>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
$(".pictures a").click(function() {
	$("#modalFullLink").attr('href', "<?=UPLOADS_URL.'/images/'?>"+$(this).data('image'));
	$("#modalImage").attr('src', $(this).children().attr('src'));
	$("#modalInput").val("<?=UPLOADS_URL.'/images/'?>"+$(this).data('image'));
	$("#deleteButton").attr('href', "<?=base_url('/admin/images/supp')?>/"+$(this).data('image'));
});
</script>