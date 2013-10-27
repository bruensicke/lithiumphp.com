<ul class="nav nav-list nav-docs">
<?php
foreach ($sources as $source) {
	echo sprintf('<li class="nav-header">%s</li>', $source->name);
	$files = $source->files('md');
	if (empty($files)) {
		continue;
	}
	echo '<li><ul class="nav nav-list nav-docs">';
	foreach ($files as $file) {
		if ($file->path !== '/') {
			continue;
		}
		$url = sprintf('%s/%s%s', $this->_request->url, $source->slug, $file->name);
		echo sprintf('<li>%s</li>', $this->html->link($file->filename, $url));
	}
	echo '</li></ul>';
}
?>
</ul>