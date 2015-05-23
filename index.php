<?php

error_reporting(0);
require_once('serve_json.php');

$fontsAll = $font->getAllFontFamily();
$cats = $font->getFontCategories();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test Google Fonts</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="js/color_picker_spectrum/spectrum.css">
	
</head>
<body>
	<div class="container">
		<div class="row margin-bottom-20 header">
			<div class="col-md-12">
				<h1 class="text-center title">Test Google Fonts</h1>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">

				<form class="form-horizontal" oninput="sizeOutput.value=fontSize.value" id="font-form" method="post">
					<div class="form-group text-holder">
						<label for="user-text" class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
							<textarea class="form-control" rows="3" id="user-text">Write Here</textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="font-category" class="col-sm-3 control-label">Font category</label>
						<div class="col-sm-9">
							<select class="form-control" id="font-category">
								<option value="all">All</option>
							<?php foreach ($cats as $cat) {
								?>
								<option value="<?= $cat ?>"><?= $cat ?></option>
								<?php
							} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="font-family" class="col-sm-3 control-label">Font family</label>
						<div class="col-sm-9">
							<select class="form-control" id="font-family">
								<option value="">Select Font</option>
							<?php foreach ($fontsAll as $font) {
								?>
								<option value="<?= $font ?>"><?= $font ?></option>
								<?php
							} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="font-variant" class="col-sm-3 control-label">Font variant</label>
						<div class="col-sm-9">
							<select class="form-control" id="font-variant">
								<option value="">Select Varient</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="color-picker" class="col-sm-3 control-label">Choose Color</label>
						<div class="col-sm-9">
							<input type="text" id="color-picker">
						</div>
					</div>

					<div class="form-group">
						<label for="font-size" class="col-sm-3 control-label">Font Size</label>
						<div class="col-sm-9">
							<input type="range" min="9" max="72" id="font-size" name="fontSize" value="48">	
							<span class="pull-right"><output name="sizeOutput" for="fontSize" class="font-size-output" >48</output> px</span>
						</div>
					</div>

					<input type="hidden" id="font-category-hidden">


					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-default form-control" id="show-code">Show Me the Code</button>
						</div>
					</div>
					<p class="col-sm-9 col-sm-offset-3"><strong>Note:</strong> You will need to be connected to internet to use this font.</p>


					<div class="output-div">
						<div class="form-group">
							<label for="output-html" class="col-sm-3 control-label">Insert this in 'Head Section' of HTML</label>
							<div class="col-sm-9">
								<textarea class="form-control" rows="3" id="output-html" readonly></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label for="output-css" class="col-sm-3 control-label">Insert this CSS with your actual element instead of 'sample-element'</label>
							<div class="col-sm-9">
								<textarea class="form-control" rows="5" id="output-css" readonly></textarea>
							</div>
						</div>
						
					</div>

				</form>
			</div>
		</div>


	</div>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/color_picker_spectrum/spectrum.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
</body>
</html>