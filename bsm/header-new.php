<?php

require_once ('config.php');
require_once ('visualizationFunctions.php');
require_once ('functions.php');
?><!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Script Tutorials" />
  <title>Black Soldiers Mattered</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- attach CSS styles -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/style-v2.css" rel="stylesheet" />

  <!-- need to load jquery at top because of leaflet -->
  <script src="js/jquery.min.js"></script>
  <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
  
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script src="<?php print ROOT_FOLDER;?>leaflet/leaflet.js"></script>
    <link rel="stylesheet" href="<?php print ROOT_FOLDER;?>leaflet/leaflet.css" />
    <script src="<?php print ROOT_FOLDER;?>leaflet/leaflet-heat.js"></script>
    <!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script src="<?php print ROOT_FOLDER;?>js/d3pie.min.js"></script>

    <!-- dygraphs--> 
    <script src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.1/dygraph-combined.js"></script>


    <!-- marker cluster stuff -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.5.0/MarkerCluster.Default.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.5.0/MarkerCluster.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.5.0/leaflet.markercluster.js"></script>
    

    <link rel="stylesheet" href="leaflet-markers/leaflet.awesome-markers.css">
    <script src="leaflet-markers/leaflet.awesome-markers.js"></script>


</head>
<body data-spy="scroll" data-target=".navbar" data-offset="65">
  
  <!-- navigation panel -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-main">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Black Soldiers Mattered</a>
    </div>

    <div class="collapse navbar-collapse" id="navbar-collapse-main">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index#home">Start</a></li>
        <li><a href="index#about">About</a></li>
        <li><a href="index#explore">Explore</a></li>
        <li><a href="index#information">Information</a></li>
        <li><a href="index#contact">Contact</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
