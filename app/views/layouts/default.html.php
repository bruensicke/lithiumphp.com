<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
?>
<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title>Application &gt; <?php echo $this->title(); ?></title>
	<?php echo $this->html->style(array('bootstrap.min', 'lithified')); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->styles(); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<body class="lithified">
	<div class="container-narrow">

		<div class="masthead">
			<ul class="nav nav-pills pull-right">
				<li>
					<a href="http://lithify.me/docs/manual/quickstart">Overview</a>
				</li>
				<li>
					<a href="<?=$this->url('/docs'); ?>">Docs</a>
				</li>
				<li>
					<a href="http://lithify.me/docs/lithium">API</a>
				</li>
				<li>
					<a href="http://lithify.me/">More</a>
				</li>
			</ul>
			<a href="<?=$this->url('/'); ?>" class="pull-left">
				<?= $this->html->image('logo.png', array('style' => 'padding-right: 5px')); ?>
			</a>

			<a href="<?=$this->url('/'); ?>" class="brand">
				<h1>lithiumphp</h1>
			</a>
		</div>

		<hr>

		<div class="content">
			<?php echo $this->content(); ?>
		</div>

		<hr>

		<div class="footer">
			<p>&copy; Union Of RAD 2013</p>
		</div>

	</div>
</body>
</html>