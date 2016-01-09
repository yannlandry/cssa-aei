<table class="table table-condensed table-striped">
	
	<tr>
		<th>Fichier</th>
		<th class="text-right">Actions</th>
	</tr>
	
	<?php foreach($files as $F): ?>
		<tr>
			<td><small><strong><a href="" data-toggle="modal" data-target="#infoModal" class="file-link"><?=$F?></a></strong></small></td>
			<td class="text-right">
				<a href="<?=UPLOADS_URL?>/files/<?=$F?>" class="btn btn-default btn-xs" target="_blank" title="Voir"><span class="glyphicon glyphicon-eye-open"></span></a>
				<a href="<?=base_url('/admin/fichiers/supp').'/'.$F?>" class="btn btn-danger btn-xs" title="Suprrimer"><span class="glyphicon glyphicon-remove"></span></a>
			</td>
		</tr>
	<?php endforeach; ?>
	
</table>


<hr />
<h2>Mettre un fichier en ligne</h2>

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


<div class="modal fade" id="infoModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Informations sur le fichier</h4>
			</div>
			<div class="modal-body text-center">
				<p><strong><a href="" id="modalName" target="_blank"></a></strong></p>
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
$(".file-link").click(function() {
	$("#modalName").html($(this).html());
	$("#modalName").attr('href', "<?=UPLOADS_URL.'/files/'?>"+$(this).html());
	$("#modalInput").val("<?=UPLOADS_URL.'/files/'?>"+$(this).html());
	$("#deleteButton").attr('href', "<?=base_url('/admin/fichiers/supp')?>/"+$(this).html());
});
</script>