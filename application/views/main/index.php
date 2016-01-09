<div class="container">
	
	<!-- Colonne I -->
	<div class="row">
		<div class="col-md-8">
			<div class="row">

				<div class="col-md-6">
					<?php if(count($news) > 0): ?>
						<div class="home-news">
							<h3><a href="<?=base_url('/nouvelles/'.$news[0]->ArticleID)?>"><?=$news[0]->Title?></a></h3>
							<p><img src="<?=get_upload($news[0]->Image, 750, 375, true)?>" alt="<?=$news[0]->Image?>" class="img-responsive" /></p>
							<p><?=coalesce($news[0]->Lead, $news[0]->Introduction)?></p>
						</div>
					<?php endif; ?>
					<?php if(count($news) > 1): ?>
						<div class="home-news">
							<h3><a href="<?=base_url('/nouvelles/'.$news[1]->ArticleID)?>"><?=$news[1]->Title?></a></h3>
							<p><img src="<?=get_upload($news[1]->Image, 750, 375, true)?>" alt="<?=$news[1]->Image?>" class="img-responsive" /></p>
							<p><?=coalesce($news[1]->Lead, $news[1]->Introduction)?></p>
						</div>
					<?php endif; ?>
				</div>
				
				<!-- Colonne II -->
				<div class="col-md-6">
					<?php if(count($news) > 2): ?>
						<div class="home-news">
							<h3><a href="<?=base_url('/nouvelles/'.$news[2]->ArticleID)?>"><?=$news[2]->Title?></a></h3>
							<p><img src="<?=get_upload($news[2]->Image, 750, 375, true)?>" alt="<?=$news[2]->Image?>" class="img-responsive" /></p>
							<p><?=coalesce($news[2]->Lead, $news[2]->Introduction)?></p>
						</div>
					<?php endif; ?>
					<?php if(count($news) > 3): ?>
						<div class="home-news">
							<h3><a href="<?=base_url('/nouvelles/'.$news[3]->ArticleID)?>"><?=$news[3]->Title?></a></h3>
							<p><img src="<?=get_upload($news[3]->Image, 750, 375, true)?>" alt="<?=$news[3]->Image?>" class="img-responsive" /></p>
							<p><?=coalesce($news[3]->Lead, $news[3]->Introduction)?></p>
						</div>
					<?php endif; ?>
				</div>

			</div>

			<?php if(count($news)): ?>
				<p class="text-center"><a href="<?=base_url('/nouvelles')?>" class="btn btn-default">Voir tout</a></p>
			<?php endif; ?>
		</div>
		
		<!-- Colonne III -->
		<div class="col-md-4">
			<h3>Événements</h3>

			<?php foreach($events as $E): ?>
				<h5><a href="<?=base_url('/evenements/'.$E->id)?>" /><?=$E->name?></a>
					<small><?=frdate($E->start_time, true, strpos($E->start_time, ':') === FALSE, false, true)?></small></h5>
			<?php endforeach; ?>
			<p class="text-center"><a href="<?=base_url('/evenements')?>" class="btn btn-default">Voir tout</a></p>
		</div>
	</div>

</div>