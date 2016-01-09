<div class="single-news">
	<h2><a href="<?=base_url('nouvelles/'.$X->ArticleID)?>"><?=$X->Title?></a></h2>
	<p><img src="<?=get_upload($X->Image, 750, 375, true)?>" alt="<?=$X->Image?>" class="img-responsive" /></p>
	<p><?=coalesce($X->Lead, $X->Introduction)?></p>
</div>