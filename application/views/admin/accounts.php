<div class="row">
	<div class="col-sm-4">
		<p><a href="<?=base_url('/admin/comptes/nouv')?>" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus-sign"></span> Nouveau
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
		<th>Compte</th>
		<th>Droits</th>
		<th class="text-right">Actions</th>
	</tr>
	
	<?php foreach($accounts as $A): ?>
		<tr>
			<td>
				<strong><a href="<?=base_url('/admin/comptes/'.$A->UserID)?>"><?=coalesce($A->UsualName, $A->Username)?></a></strong>
				<?php if(!empty($A->UsualName)): ?><br /><small class="text-muted"><?=$A->Username?></small><?php endif; ?>
			</td>
			<td>
				<?php if($A->IsAdmin == 1): ?>
					<strong>Administration</strong>
				<?php else: ?>
					Rédaction
				<?php endif; ?>
			</td>
			<td class="text-right">
				<a href="<?=base_url('/admin/comptes/'.$A->UserID)?>" class="btn btn-warning" title="Modifier">
					<span class="glyphicon glyphicon-edit"></span></a>
				<a href="<?=base_url('/admin/comptes/'.$A->UserID.'/supp')?>" class="btn btn-danger" title="Supprimer">
					<span class="glyphicon glyphicon-remove"></span></a>
			</td>
		</tr>
	<?php endforeach; ?>

</table>

<div class="row">
	<div class="col-sm-4">
		<p><a href="<?=base_url('/admin/comptes/nouv')?>" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus-sign"></span> Nouveau
		</a></p>
	</div>
	<div class="col-sm-8">
		<div class="pull-right">
			<?=$pagination?>
		</div>
	</div>
</div>