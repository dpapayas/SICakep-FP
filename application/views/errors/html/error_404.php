<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>404 Page Not Found</title>
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<link href="<?= config_item('base_url'); ?>assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= config_item('base_url'); ?>assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="<?= config_item('base_url'); ?>assets/img/favicon.ico" />
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
	<div class="m-grid m-grid--hor m-grid--root m-page">
		<div class="m-grid__item m-grid__item--fluid m-grid  m-error-1" style="background-image: url(assets/bg_not_found.jpg);">
			<div class="m-error_container">
				<span class="m-error_number">
					<h1>404</h1>
				</span>
				<p class="m-error_desc">
					Not Found
				</p>
			</div>
		</div>
	</div>
	<script src="<?= config_item('base_url'); ?>assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
	<script src="<?= config_item('base_url'); ?>assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
</body>
</html>