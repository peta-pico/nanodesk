<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $head['meta']['title']; ?></title>
    <meta name="description" content="<?php echo $head['meta']['description']; ?>">
    <meta name="robots" content="<?php echo $head['meta']['robots']; ?>" />
    
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="<?php echo ROOT; ?>/css/normalize.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>/css/main.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>/css/styles.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <script src="<?php echo ROOT; ?>js/vendor/modernizr-2.8.3.min.js"></script>

    <!-- add after -->
    <?php
        echo add_files($head['add_files']);
    ?>


</head>
<body>
	<!--[if lt IE 8]>
	    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->