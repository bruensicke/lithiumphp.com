<header>
	<div class="container">
		<div class="row">
			<div class="col-md-5 col-sm-5">
				<div class="logo">
					<a href="<?=$this->url('/'); ?>" class="pull-left">
						<?= $this->html->image('logo.png', array('style' => 'padding: 8px 5px 0 0')); ?>
					</a>

					<a href="<?=$this->url('/'); ?>" class="brand">
						<h1>lithiumphp</h1>
					</a>
					<div class="hmeta">most RAD development framework for PHP</div>
				</div>
			</div>
			<div class="col-md-5 col-md-offset-2 col-sm-6 col-sm-offset-1">

				<?= $this->_render('element', 'layout/search'); ?>

			</div>
		</div>
	</div>
</header>
