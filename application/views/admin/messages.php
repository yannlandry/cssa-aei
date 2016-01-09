<div class="row">
	<div class="col-sm-12">
		<div class="pull-right">
			<?=$pagination?>
		</div>
	</div>
</div>

<table class="table table-striped">

	<tr>
		<th>Liste des messages</th>
	</tr>
	
	<?php foreach($messages as $M): ?>
		<tr>
			<td><strong>
				<?php if(!empty($M->Email)): ?><a href="mailto:<?=$M->Email?>"><?php endif; ?>
					<?=coalesce($M->Name, $M->Email, "Anonyme")?>
				<?php if(!empty($M->Email)): ?></a><?php endif; ?>
				: <em><?=$M->Subject?></em>
			</strong>
			<br /><small><?=$M->Message?>
			<br /><span class="text-muted">Envoyé <?=frdate($M->Sent)?> depuis <?=$M->IP?></span></small></td>
		</tr>
	<?php endforeach; ?>

</table>

<div class="row">
	<div class="col-sm-12">
		<div class="pull-right">
			<?=$pagination?>
		</div>
	</div>
</div>