
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
		function loadMinJQuery()
		{
			window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>');
		}
	</script>
    <script src="js/bootstrap.min.js"></script>

    <!--Slick Carousel-->
    <script type="text/javascript" src="js/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery/1.2.1/jquery-migrate.min.js"></script>
    <script type="text/javascript" src="slick/slick.min.js"></script>
    <script type="text/javascript" src="js/carousel.js"></script>
    <script src="js/fade.js" type="text/javascript"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			$("#search").click(function(){
				$("#pagecontainer").load("search.html");
			});
		});
	</script>
  </body>
</html>
