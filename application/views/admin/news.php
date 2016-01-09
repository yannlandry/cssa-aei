<div class="row">
	<div class="col-sm-4">
		<p><a href="<?=base_url('/admin/nouvelles/nouv')?>" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus-sign"></span> Écrire
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
		<th>Création</th>
		<th class="text-right">Actions</th>
	</tr>
	
	<?php foreach($news as $N): ?>
		<tr>
			<td>
				<strong><a href="<?=base_url('/nouvelles/'.$N->ArticleID)?>" target="_blank"><?=$N->Title?></a></strong>
				<br /><small><?=character_limiter(coalesce($N->Lead, $N->Introduction), 90)?></small>
			</td>
			<td><?=frdate($N->Creation)?></td>
			<td class="text-right">
				<a href="<?=base_url('/admin/nouvelles/'.$N->ArticleID)?>" class="btn btn-warning" title="Éditer">
					<span class="glyphicon glyphicon-edit"></span></a>
				<a href="<?=base_url('/admin/nouvelles/'.$N->ArticleID.'/supp')?>" class="btn btn-danger" title="Supprimer">
					<span class="glyphicon glyphicon-remove"></span></a>
			</td>
		</tr>
	<?php endforeach; ?>

</table>

<div class="row">
	<div class="col-sm-4">
		<p><a href="<?=base_url('/admin/nouvelles/nouv')?>" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus-sign"></span> Écrire
		</a></p>
	</div>
	<div class="col-sm-8">
		<div class="pull-right">
			<?=$pagination?>
		</div>
	</div>
</div>