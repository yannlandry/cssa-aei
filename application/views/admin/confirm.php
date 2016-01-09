<p><?=$text?></p>

<form method="post" class="text-center">
	<input type="submit" name="conf-yes" value="Oui" class="btn btn-primary" />
	<input type="submit" name="conf-no" value="Non" class="btn btn-default" />
	<?php insert_csrf_token(); ?>
</form>