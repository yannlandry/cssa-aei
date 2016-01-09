<div class="container top-spacer">

	<?php if(trim(validation_errors())): ?>
		<div class="alert alert-danger fade in">
			<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
			<h4>Il y a des erreurs dans le formulaire</h4>
			<ul>
				<?=validation_errors()?>
			</ul>
		</div>
	<?php endif; ?>

	<form role="form" method="post">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group <?php form_error('name') and print('has-error'); ?>">
					<label for="name">Nom :</label>
					<input type="text" name="name" id="name" class="form-control" value="<?=set_value('name')?>" autofocus="autofocus" />
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group <?php form_error('email') and print('has-error'); ?>">
					<label for="email">Adresse courriel :</label>
					<input type="email" name="email" id="email" class="form-control" value="<?=set_value('email')?>" />
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="form-group <?php form_error('subject') and print('has-error'); ?>">
					<label for="subject">Sujet :</label>
					<input type="text" name="subject" id="subject" class="form-control" value="<?=set_value('subject')?>" />
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="form-group <?php form_error('message') and print('has-error'); ?>">
					<label for="message">Message :</label>
					<textarea name="message" id="message" class="form-control autosize" rows="4"><?=set_value('message')?></textarea>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<div class="form-group <?php form_error('captcha') and print('has-error'); ?>">
					<label for="captcha">Captcha :</label>
					<input type="text" name="captcha" id="captcha" class="form-control" />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>&nbsp;</label>
					<div><?=$captcha?></div>
				</div>
			</div>
			<div class="col-md-3 text-right">
				<label>&nbsp;</label>
				<div><input type="submit" class="btn btn-primary" value="Envoyer" /></div>
			</div>
		</div>
	</form>

</div>