<?php
use radium\data\Converter;
use app\extensions\data\Sources;

$folder = Sources::folder('lithium');
$cmd = "cd $folder && git log --all --format='%aN' | sort -u";
$output = shell_exec($cmd);
$contributors = array_filter(explode("\n", $output));
?>
<div class="content">
	<div class="container">

		<h2><?=$this->title('Contributors'); ?></h2>
		<p class="big grey">lithium was made possible thanks to these people:</p>
		<hr />

		<ul class="contributors">
			<li><?php echo implode('</li><li>', $contributors); ?></li>
		</ul>

		<div class="border"></div>

	</div>
</div>
<style>
ul.contributors {
  width:760px;
  margin-bottom:20px;
  overflow:hidden;
}
ul.contributors li {
  line-height:1.5em;
  border-bottom:1px dashed #ccc;
  float:left;
  display:inline;
  width:23%;
  margin-right: 10px;
}
</style>