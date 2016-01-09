<div class="container top-spacer">
	<div class="row">
		<div class="col-md-8">
		
			<p><strong>Par <?=coalesce($N->UsualName, $N->Username)?>, <?=frdate($N->Creation)?></strong></p>
			
			<article>
				<?=$N->Content?>
			</article>
			
			<div class="fb-comments" data-href="http://aefsum.ca/nouvelles/<?=$N->ArticleID?>" data-colorscheme="light" data-numposts="8" mobile="false"></div>
		
		</div>
		<div class="col-md-4 side-news">
		
			<?php foreach($sidenews as $S): ?>
				<h4><a href="<?=base_url('nouvelles/'.$S->ArticleID)?>"><?=$S->Title?></a></h4>
				<p><img src="<?=get_upload($S->Image, 750, 375, true)?>" alt="<?=$S->Image?>" class="img-responsive" /></p>
				<p><?=coalesce($S->Lead, $S->Introduction)?></a></p>
			<?php endforeach; ?>
		
		</div>
	</div>
</div>