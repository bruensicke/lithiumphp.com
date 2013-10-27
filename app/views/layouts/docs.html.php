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
	<?php echo $this->html->style(array('bootstrap.min', 'font-awesome', 'style', 'blue', 'custom')); ?>
	<?php echo $this->html->script(array('jquery', 'bootstrap', 'app')); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->styles(); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,300,600' rel='stylesheet' type='text/css'>
</head>
<body>
	<?= $this->_render('element', 'layout/header'); ?>
	<?= $this->_render('element', 'layout/topnav'); ?>

	<?php echo $this->content(); ?>

	<?= $this->_render('element', 'layout/social'); ?>
	<?= $this->_render('element', 'layout/footer'); ?>
</body>
</html>