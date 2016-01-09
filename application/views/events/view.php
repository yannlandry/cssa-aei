<div class="container">
	<div class="row">
		<div class="col-md-8">

			<?php if(isset($E->cover->source)): ?><p><img src="<?=$E->cover->source?>" alt="<?=$E->name?>" class="img-thumbnail img-responsive" /></p><?php endif; ?>
			<?php if(isset($E->description)): ?><p><?=nl2br(htmlspecialchars($E->description))?></p><?php endif; ?>

		</div>
		<?php if(isset($E->venue)): ?>
			<div class="col-md-4">

				<h4><span class="glyphicon glyphicon-map-marker"></span> Où ?</h4>

				<?php $venue = array();
				if(isset($E->venue->street)) $venue[] = $E->venue->street;
				if(isset($E->venue->city)) $venue[] = $E->venue->city;
				if(!empty($venue)): ?>
					<p>
						<?php if(isset($E->location)): ?>
							<strong><?php isset($E->venue->id) and print('<a href="https://facebook.com/'.$E->venue->id.'" target="_blank">'); ?>
								<?=$E->location?><?php isset($E->venue->id) and print('</a>'); ?></strong><br />
						<?php endif; ?>
						<?php echo implode(', ', $venue); ?>
					</p>
				<?php endif; ?>

				<?php if(isset($E->venue->latitude, $E->venue->longitude)): ?>
					<p><a href="https://google.ca/maps/search/<?=$E->venue->latitude.','.$E->venue->longitude?>" target="_blank">
						<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?=$E->venue->latitude.','.$E->venue->longitude?>&zoom=15&size=375x375&maptype=roadmap&markers=color:red|<?=$E->venue->latitude.','.$E->venue->longitude?>&sensor=false"
							alt="Endroit" class="img-responsive img-thumbnail" />
					</a></p>
				<?php endif; ?>

				<p><?php if(isset($E->ticket_uri)): ?><a href="<?=$E->ticket_uri?>" target="_blank" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-credit-card"></span> Achat de billets</a><?php endif; ?>
					<a href="https://facebook.com/events/<?=$E->id?>" target="_blank" class="btn btn-default btn-block"><span class="glyphicon glyphicon-share-alt"></span> Voir sur Facebook</a></p>

			</div>
		<?php endif; ?>
	</div>
</div>