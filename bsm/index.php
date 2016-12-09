<?php

require_once ('config.php');
require_once ('visualizationFunctions.php');
//require_once ('functions.php');
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
        <li><a href="#home">Start</a></li>
        <li><a href="#about">Intro</a></li>
        <li><a href="#explore">Explore</a></li>
        <li><a href="#information">Overview</a></li>
        <li><a href="#new">About</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

  <!-- first section - Home -->
<div id="home" class="home">
  <div class="text-vcenter">
    <div class="panel background-home-primary">
      <h1 class="text-primary">Black Soldiers Mattered</h1>
      <h2><em><strong>Black North Carolinians as Soldiers in the First World War: A Microcosm of the National African American Experience</em></strong></h2>
      <h3>By Janet G. Hudson</h3>
    </div>
    <!--<div style="height:4em;"></div>-->
  </div>
</div>
<!-- /first section -->
  
  <!-- second section - About -->
<div id="about" class="pad-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <img src="images/logo.png" alt="" />
      </div>
      <div class="col-sm-9 text-left">
        <h1 class="text-header">Soldier's Journey</h1>
        <p class="lead">April 6, 1917, changed the lives of 21,609 young African American men from North Carolina. The participation of these Black North Carolinians in World War I has been mostly ignored. <strong><span class="text-highlight">Black Soldiers Mattered</span></strong> addresses that void with this interactive site. Explore the journey of Black North Carolinians (BNC)—as units and individual soldiers—from induction to demobilization. </p>
      </div>
    </div>
  </div>
</div>
<!-- /second section -->

  <!-- third section - explore -->
<div id="explore" class="pad-section">
  <div class="container">
    <h1 class="text-center text-highlight"><big>EXPLORE</big></h1> <hr />
    <div class="row text-center">
      <div class="col-sm-3 col-xs-6">
        <a href="#explorePlaces" class="explore-link text-primary-dark">
          <!--<i class="fa fa-map" aria-hidden="true"></i>-->
          <img src="<?php print ROOT_FOLDER;?>images/map.jpg" class="ia">
          <div class="background-dark">
            <h4>Places</h4>
            <p class="text-white">Explore where Black North Carolinians (BNC) lived, were inducted, and trained.</p>
          </div>
        </a>
      </div>
      <div class="col-sm-3 col-xs-6">
        <a href="#exploreSoldiers" class="explore-link text-primary-dark">
          <!--<i class="fa fa-globe" aria-hidden="true"></i>-->
          <img src="<?php print ROOT_FOLDER;?>images/world.jpg" class="ia">
          <div class="background-dark">
          <h4>Wartime Journey</h4>
          <p class="text-white">Explore when and where BNC soldiers served.</p>
          </div>
        </a>
      </div>
      <div class="col-sm-3 col-xs-6">
        <a href="#exploreDomesticService" class="explore-link text-primary-dark">
          <!--<i class="fa fa-users" aria-hidden="true"></i>-->
          <img src="<?php print ROOT_FOLDER;?>images/soldier.jpg" class="ia">
          <div class="background-dark">
          <h4>Individual Soldiers</h4>
          <p class="text-white">Explore who served and where he served.</p>
          </div>
        </a>
      </div>
      <div class="col-sm-3 col-xs-6">
        <a href="#exploreOfficers" class="explore-link text-primary-dark">
          <!--<i class="fa fa-server" aria-hidden="true"></i>-->
          <img src="<?php print ROOT_FOLDER;?>images/92nd.jpg" class="ia">
          <div class="background-dark">
          <h4>Units</h4>
          <p class="text-white">Explore domestic and overseas units that BNC soldiers served with.</p>
          </div>
        </a>
      </div>
    </div>
    <!-- collapsible panels -->
  <div class="row">
    <div class="collapse col-sm-3 col-xs-6" id="explorePlaces">
          <div class="col-xs-12">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#mapsChartsModal">Home to Army</button>
          </div>

          <div class="col-xs-12">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#campsModal">Army Camps</button>
          </div>
    </div>
  
    <div class="collapse col-sm-3 col-sm-offset-3 col-xs-6 col-xs-offset-6" id="exploreSoldiers">
          <div class="col-xs-12">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#timelinesModal">Journey Begins</button>
          </div>
          <div class="col-xs-12">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#dischargeDateModal">Journey Ends</button>
          </div>

          <div class="col-xs-12">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#allSoldiersJourneyModal">View Collective Journey</button>
          </div>
    </div>
    <div class="collapse col-sm-3 col-sm-offset-6 col-xs-6" id="exploreDomesticService">
          <div class="col-xs-12">
            <a class="btn btn-default" href="soldiers">Individual soldiers</a>
          </div>
          <div class="col-xs-12">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#officersModal">Officers</button>
          </div>
    </div>
    <div class="collapse col-sm-3 col-sm-offset-9 col-xs-6 col-xs-offset-6" id="exploreOfficers">
        <div class="col-xs-12">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#overseasStatsModal">Unit Types</button>
        </div>
        <div class="col-xs-12">
            <a class="btn btn-default" href="units">Explore individual units</a>
          </div>
    </div>

  </div>

  </div>
</div>
<!-- /third section -->

  <!-- fourth section - Information -->
<div id="information" class="pad-section">
  <div class="container">
      <h1 class="text-center text-highlight"><big>OVERVIEW</big></h1> <hr />
    <div class="row">
      <div class="col-sm-6">
        <div class="panel text-primary-dark">
          <div class="panel-heading">
            <h2 class="text-primary-dark">National Service Shaped by Racism</h2>
          </div>
          <div class="panel-body lead text-black">Military preparations for war conformed to the rules of segregated America, influencing all African American soldiers’ wartime experiences. Yet even within these limitations, Black North Carolinians made their mark. They were among the first American combat soldiers, black or white, to arrive in Europe, among the early stevedore volunteers, among the recipients of military awards and honors, and among the last returning soldiers who restored the killing fields of France for human habitation.
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel text-primary-dark">
          <div class="panel-heading">
            <h2 class="text-primary-dark">Overseas v. Domestic Service</h2>
          </div>
          <div class="panel-body lead text-black">
            Approximately half of Black North Carolinians experienced the war in France and the other half in the US. Of those who sailed abroad, approximately 20% served as combat soldiers in arms. North Carolinians served in both segregated combat divisions—92nd and 93rd. The other 80% in France served as laboring soldiers in five different types of units. The half assigned to domestic units met a wide variety of needs in a host of specialized labor units.
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /fourth section -->

  <!-- fifth section -->
<div id="contact" class="pad-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h3 class="text-primary">For more information:</h3>
        <h4>janethudson@sc.edu</h4>
      </div>
    </div>
  </div>
</div>
<!-- /fifth section -->

<!-- footer -->
<footer>
  <hr />
  <div class="container">
    <p class="text-right">Copyright &copy; 2016 - University of South Carolina - All Rights Reserved</p>
  </div>
</footer>
<!-- /footer -->
<?php require 'index2-modals.php'; ?>

  <!-- attach JavaScripts -->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/v2.js"></script>
</body>
</html>