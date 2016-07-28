<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
ini_set("display_startup_errors", true);

require_once 'config.php';
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Black Soldiers Mattered</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php print ROOT_FOLDER;?>css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php print ROOT_FOLDER;?>css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Carousel Slider CSS -->
    <link rel="stylesheet" type="text/css" href="<?php print ROOT_FOLDER;?>slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php print ROOT_FOLDER;?>slick/slick-theme.css"/>

    <!-- Custom styles for this template -->
    <link href="<?php print ROOT_FOLDER;?>css/bsm.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script src="<?php print ROOT_FOLDER;?>js/bsm.js"></script>
    <?php 
    /*
     * jquery is being loaded here instead of the footer because leaflet is stupid
     * and won't work unless it's already loaded in the head.
     * TODO: make this conditional for only pages that have maps, otherwise load in footer
     * */
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php print ROOT_FOLDER;?>js/jquery.min.js"><\/script>')</script>
    
    <?php if ($title=='map-4'):?>
    <!-- for hexbin map 
    TODO: add local copy of these files in case cdn goes down
    -->
    <script src='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.css' rel='stylesheet' />
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="<?php print ROOT_FOLDER;?>d3/hexbin.js"></script>
    <script src="<?php print ROOT_FOLDER;?>d3/simple_statistics.js"></script>
    <?php else:?>
    <!-- leaflet
    will add cdn links later - to avoid caching issues -->
    <script src="<?php print ROOT_FOLDER;?>leaflet/leaflet.js"></script>
    <link rel="stylesheet" href="<?php print ROOT_FOLDER;?>leaflet/leaflet.css" />
    <?php endif;?>
    
    <!-- conditional loading of javascript for maps, to avoid conflicts -->
    <?php if($title=='map-1'):?><script src="<?php print ROOT_FOLDER;?>js/bsm-map1.js"></script><?php endif;?>
    <?php if($title=='map-2'):?><script src="<?php print ROOT_FOLDER;?>js/bsm-map2.js"></script><?php endif;?>
    <?php if($title=='map-3'):?>
    <script src="<?php print ROOT_FOLDER;?>js/bsm-map3.js"></script>
    <script src="<?php print ROOT_FOLDER;?>leaflet/leaflet-heat.js"></script>
    <?php endif;?>
    <?php if($title=='map-4'):?><script src="<?php print ROOT_FOLDER;?>js/bsm-map4.js"></script><?php endif;?> 

    <!-- Stuff for visualizations -->
    <?php if($title=='slide-4'): ?>
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="<?php print ROOT_FOLDER;?>js/d3pie.min.js"></script>
    <script src="<?php print ROOT_FOLDER;?>js/slide-4.js"></script>
    <style>
    </style>
    <?php endif; ?>


  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header"> 
          <a class="navbar-brand" href="<?php print ROOT_FOLDER;?>"><img src="<?php print ROOT_FOLDER;?>images/logo.png" height="150px" width="150px"></a>
          <div class="topbanner">
            <img src="<?php print ROOT_FOLDER;?>images/headersplit.png">
            <img src="<?php print ROOT_FOLDER;?>images/banner.png">
          </div>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li></li>
            <li class="active"><a href="<?php print ROOT_FOLDER;?>">Home</a></li>
            <!-- Interactive Maps -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Interactive Maps <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">North Carolina</a></li>
                <li><a href="#">United States</a></li>
                <li><a href="#">Europe</a></li>
                <li><a href="#">All Maps</a></li>
              </ul>
            </li>
            <!-- Categories -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Categories <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">How</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Where</li>
                <li><a href="#">Lived</a></li>
                <li><a href="#">Served</a></li>
              </ul>
            </li>

            <li><a href="#about">Search</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
