<div class="container">

	<?php foreach($events as $E): ?>

		<h3><a href="<?=base_url('/evenements/'.$E->id)?>" /><?=$E->name?></a>
			<small><?=frdate($E->start_time, true, strpos($E->start_time, ':') === FALSE, false, true)?></small></h3>

		<p><?php property_exists($E, 'location') and print($E->location.'<br />'); ?>
			<a href="https://facebook.com/events/<?=$E->id?>">Voir sur Facebook</a></p>

	<?php endforeach; ?>

</div>