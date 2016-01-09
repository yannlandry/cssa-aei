<form method="post">
	<table class="table table-striped">

		<tr>
			<th>Titre à afficher</th>
			<th>Lien</th>
			<th>Position</th>
			<th class="text-center">Supprimer</th>
		</tr>
		
		<?php foreach($menu as $M): ?>
			<tr>
				<td>
					<input type="text" name="menu[<?=$M->MenuItemID?>][Text]" class="form-control" value="<?=$M->Text?>" />
				</td>
				<td>
					<input type="text" name="menu[<?=$M->MenuItemID?>][Link]" class="form-control" value="<?=$M->Link?>" />
				</td>
				<td style="max-width:40px;">
					<input type="text" name="menu[<?=$M->MenuItemID?>][Position]" class="form-control" value="<?=$M->Position?>" />
				</td>
				<td style="max-width:40px;" class="text-center">
					<input type="checkbox" name="menu[<?=$M->MenuItemID?>][Delete]" />
				</td>
			</tr>
		<?php endforeach; ?>
		
		<tr>
			<td>
				<input type="text" name="menu[new][Text]" class="form-control" placeholder="Nouvel élément..." />
			</td>
			<td>
				<input type="text" name="menu[new][Link]" class="form-control" placeholder="Lien..." />
			</td>
			<td style="max-width:40px;">
				<input type="text" name="menu[new][Position]" class="form-control" placeholder="0" />
			</td>
			<td style="max-width:40px;"></td>
		</tr>

	</table>
	
	<?php insert_csrf_token(); ?>
	<p class="text-center"><button type="submit" class="btn btn-primary">Sauvegarder</button></p>
</form>