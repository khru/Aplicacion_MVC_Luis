<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $titulo ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo URL; ?>js/ajax.js"></script>

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

    <!-- CSS -->
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
</head>
<body>
    <!-- logo -->
<?php $this->insert('partials/logo')?> 

    <!-- navigation -->
<?php Session::userIsLoggedIn() ? $this->insert('partials/menuSubscriptor') : $this->insert('partials/menu')?>
<?php if(Session::userIsAdmin()) $this->insert('partials/menuAdmin')?>
    <!-- section -->
<?= $this->section('content') ?>
<?php if(Session::userIsLoggedIn()) $this->insert('partials/userLoggedIn') ?>
    <!-- jQuery, loaded in the recommended protocol-less way -->
    <!-- more http://www.paulirish.com/2010/the-protocol-relative-url/ -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- our JavaScript -->
    <script src="<?php echo URL; ?>js/application.js"></script>
    
</body>
</html>

