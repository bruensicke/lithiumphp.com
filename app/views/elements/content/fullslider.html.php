<?= $this->html->style('flexslider', array('inline' => false)); ?>
<?= $this->html->script(array('easing', 'jquery.flexslider-min.js'), array('inline' => false)); ?>

<div class="full-slider">
		<!-- Slider (Flex Slider) -->

			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="flexslider">
							<ul class="slides">

								<li>

									<!-- Slider content -->
									<div class="flex-caption">
										<!-- Left column -->
										<div class="col-l">

												<h2>What Do  Started Today</h2>

												<h6>Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Nulla vitae cursus leo. Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Nulla vitae cursus leo.</h6>


										</div>
										<!-- Right column -->
										<div class="col-r">

											<!-- Use the class "flex-back" to add background inside flex slider -->

												<h5>Nulla Vitae Rhoncus</h5>
												<p>Suspendisse potenti. Morbi ac felis nec mauris imperdiet fermentum. Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Nulla vitae cursus leo.</p>


											<!-- Button -->
											<div class="button">
												<a href="#"><i class="icon-circle-arrow-down"></i> Download Our Software Today</a>
											</div>

										</div>
									</div>

								</li>

								<li>
									<div class="flex-caption flex-center">
										<h2>Don't Miss This Theme</h2>

										<p>Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Nulla vitae cursus leo. Suspendisse potenti. Morbi ac felis nec mauris imperdiet fermentum. </p>

											<!-- Button -->
											<div class="button">
												<a href="#">Buy It Now</a>
											</div>

									</div>
								</li>


								<li>

									<!-- Slider content -->
									<div class="flex-caption">
										<!-- Left column -->
										<div class="col-l">
											<h2>Get Started Today</h2>
											<h6>Suspendisse potenti. Morbi ac felis nec mauris imperdiet fermentum. Aenean sodales augue ac lacus hendrerit.</h6>

											<!-- Button -->
											<div class="button">
												<a href="#"><i class="icon-circle-arrow-down"></i> Download</a>
											</div>

										</div>
										<!-- Right column -->
										<div class="col-r">

											<!-- Use the class "flex-back" to add background inside flex slider -->
											<div class="flex-back">
												<h5>Nulla Vitae Rhoncus</h5>
												<p>Suspendisse potenti. Nulla vitae cursus leo. Morbi ac felis nec mauris imperdiet fermentum. Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Nulla vitae cursus leo.</p>
											</div>

										</div>
									</div>

								</li>


								<li>

									<!-- Slider content -->
									<div class="flex-caption">
										<!-- Left column -->
										<div class="col-l">
											<h2>Someone Started Today</h2>
											<h6>Suspendisse potenti. Morbi ac felis nec mauris imperdiet fermentum. Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit.Vivamus vel ultricies elit.</h6>



										</div>
										<!-- Right column -->
										<div class="col-r">

											<!-- Use the class "flex-back" to add background inside flex slider -->

												<h2>Nulla Vitae Rhoncus</h2>
												<p>Suspendisse potenti. Morbi ac felis nec mauris imperdiet fermentum. Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Nulla vitae cursus leo.</p>


										</div>
									</div>

								</li>


							</ul>
						</div>
					</div>
				</div>
			</div>
</div>

<script type="text/javascript">
jQuery().ready(function($) {
	$('.flexslider').flexslider({
		easing: "easeInOutSine",
		directionNav: false,
		animationSpeed: 1500,
		slideshowSpeed: 5000
	});
});
</script>
<style type="text/css">
.full-slider i{
	margin: 0px;
}

.full-slider .button{
	margin-top: 5px;
}

.full-slider .button a{
	font-size: 15px;
	display: inline-block;
	padding: 8px 15px !important;
}

.flexslider {
	background: transparent;
	min-height: 300px;
	margin: 0 0 0px;
	border: 0px;
	border-radius: 0px;
	box-shadow: none;
	color: #fff;
}

.flex-direction-nav .flex-next {
right: 5px !important;
}

.flex-direction-nav .flex-prev {
left: 5px !important;
}

.flex-control-nav{
	bottom: 10px;
}

.flex-control-paging li a{
	background:#fff;
	box-shadow: none;
	width: 8px;
	height: 8px;
}

.flex-control-paging li a:hover{
	background: #ddd;
}

.flex-control-paging li a.flex-active{
	background: #ddd;
}

.flex-center{
	text-align: center;
}

.flex-caption{
	margin: 60px 0px 40px 0px;
}

.flex-caption h2, .flex-caption h5, .flex-caption h6{
	color: #fff;
}

.flex-caption p{
	font-size: 14px;
	line-height: 23px;
	max-width: 650px;
	margin: 0 auto;
}

.flex-back{
	padding: 10px;
}
</style>
