<?php
$source = (!isset($source)) ? $sources->first() : $source;
$base = (!isset($base)) ? $this->_request->url.'/'.$source->slug : $base;
?>
<ul class="nav nav-list nav-docs">
<?php
$html = $this->html;
$iterate = function($array, $prefix = '/') use (&$iterate, $base, $html) {
	$out = '<ul class="nav nav-list nav-docs">';
	foreach($array as $key => $child) {
		if (is_array($child)) {
			$out .= '<li class="nav-header">'.$key.'</li>';
			$out .= '<li>'.$iterate($child, $prefix . $key . '/').'</li>';
		} else {
			$out .= '<li>';
			$out .= $html->link($child, $base.$prefix.$child);
			$out .= '</li>';
		}
	}
	return $out.'</ul>';
};

$files = $source->files('md', array('nested' => true, 'raw' => true));
echo $iterate($files);
?>