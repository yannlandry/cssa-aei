<div class="row">
	<div class="col-sm-4">
		<p><a href="<?=base_url('/admin/pages/nouv')?>" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus-sign"></span> Créer
		</a></p>
	</div>
	<div class="col-sm-8">
		<div class="pull-right">
			<?=$pagination?>
		</div>
	</div>
</div>

<table class="table table-striped">

	<tr>
		<th>Titre</th>
		<th>Dernière mise à jour</th>
		<th class="text-right">Actions</th>
	</tr>
	
	<?php foreach($pages as $P): ?>
		<tr>
			<td>
				<strong><a href="<?=base_url('/'.$P->Slug)?>" target="_blank"><?=$P->Title?></a></strong>
				<small class="text-muted">/<?=$P->Slug?></small>
				<br /><small><?=character_limiter($P->Lead, 90)?></small>
			</td>
			<td><?=frdate($P->LastUpdate)?></td>
			<td class="text-right">
				<a href="<?=base_url('/admin/pages/'.$P->PageID)?>" class="btn btn-warning" title="Éditer">
					<span class="glyphicon glyphicon-edit"></span></a>
				<a href="<?=base_url('/admin/pages/'.$P->PageID.'/supp')?>" class="btn btn-danger">
					<span class="glyphicon glyphicon-remove" title="Supprimer"></span></a>
			</td>
		</tr>
	<?php endforeach; ?>

</table>

<div class="row">
	<div class="col-sm-4">
		<p><a href="<?=base_url('/admin/pages/nouv')?>" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus-sign"></span> Créer
		</a></p>
	</div>
	<div class="col-sm-8">
		<div class="pull-right">
			<?=$pagination?>
		</div>
	</div>
</div>