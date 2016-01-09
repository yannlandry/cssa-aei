<div class="container top-spacer">
	<div class="row">
		<div class="col-md-8">
		
			<div id="infscr-data">
				<?=$news?>
			</div>
			
			<p id="infscr-trigger" class="text-center"><a href="" class="btn btn-default">Charger plus</a></p>
		
		</div>
		<div class="col-md-4">
		
			<h3>Archives</h3>
			
			<p>
				<?php if($year == 0 && $month == 0): ?>
					<strong>Toutes les nouvelles</strong>
				<?php else: ?>
					<a href="<?=base_url('/nouvelles')?>">Toutes les nouvelles</a>
				<?php endif; ?>
			
			
			<?php $prevyear = 0;
			foreach($archives as $A): if($A->Y == $prevyear) echo '<br />'; else echo '</p><p>'; ?>
				<?php if($year == $A->Y && $month == $A->M): ?>
					<strong><?=fr_month($A->M)?> <?=$A->Y?></strong>
				<?php else: ?>
					<a href="<?=base_url('/nouvelles/'.$A->Y.'/'.$A->M)?>"><?=fr_month($A->M)?> <?=$A->Y?></a>
				<?php endif; ?>
			<?php $prevyear = $A->Y;
			endforeach; ?>
			
			</p>
		
		</div>
	</div>
</div>

<script type="text/javascript"><?php foreach($infscr as $var => $val) print('var '.$var.' = "'.$val.'";'."\n"); ?></script>