<div class="content">
	<div class="container">

		<div class="row">
			<div class="col-md-3 col-sm-3 border-right">
				<?php
				$element = (count($sources) === 1)
					? 'docs/single'
					: 'docs/multi';
				echo $this->_render('element', $element);
				?>
			</div>
			<div class="col-md-7 col-sm-7">

			</div>
		</div>

	</div>
</div>