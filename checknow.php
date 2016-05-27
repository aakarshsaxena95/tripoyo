<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Holiday - Tours</title>
<!--
Holiday Template
http://www.templatemo.com/tm-475-holiday
-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,700' rel='stylesheet' type='text/css'>
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
  <link href="css/flexslider.css" rel="stylesheet">
  <link href="css/templatemo-style.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body class="tm-gray-bg">
  <?php
  include ("header.php");
  ?>
  <section class="tm-white-bg section-padding-bottom">
      <div class="container">
          <div class="row">
              <div class="tm-section-header section-margin-top">
                  <div class="col-lg-4 col-md-3 col-sm-3"><hr></div>
                  <div class="col-lg-4 col-md-6 col-sm-6"><h2 class="tm-section-title">Pick Destinations</h2></div>
                  <div class="col-lg-4 col-md-3 col-sm-3"><hr></div>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-6 col-md-6">
                  <div id="google-map"></div>
              </div>
              <form action="plan.php" method="post" class="boxx">
                  <?php
                  include("connection.php");
                  $s="SELECT `s.no`,`name` FROM indian_cities WHERE flag=1 ORDER BY name , name ASC";
                  $result=mysqli_query($conn, $s);
                  $ans='';
                  while($r=mysqli_fetch_array($result)){
                      $ans.='<input type="checkbox" name="check_list[]" value="'.$r[0].'"> ' . $r[1] .'<br>';
                  }
                  session_start();
                  $_SESSION['location']=$_GET["location"];
                  $_SESSION['days']=$_GET["days"];
                  echo $ans;
                  ?>
                  <div class="form-group">
                      <button class="tm-submit-btn" type="submit" name="add">ADD</button>
                  </div>
              </form>
              <center>
                  <br>
                  <div class="col-lg-6 col-md-6 tm-contact-form-input">
                      <div class="form-group">
                          <nav class="tm-nav">
                              <ul>
                                  <li><a href="suggestion.php">Recommendations</a></li>
                              </ul>
                          </nav>
                      </div>
                  </div>
              </center>
          </div>
      </div>
      <br><br><br><br>
  <?php
  include("footer.php");
  ?>
  <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>      		<!-- jQuery -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>					<!-- bootstrap js -->
  <script type="text/javascript" src="js/jquery.flexslider-min.js"></script>			<!-- flexslider js -->
  <script type="text/javascript" src="js/templatemo-script.js"></script>      		<!-- Templatemo Script -->
  <script>
      /* Google map
       ------------------------------------------------*/
      var map = '';
      var center;


      function initialize() {
          var mapOptions = {
              zoom: 6,
              center: new google.maps.LatLng(23.61,80.00),
              scrollwheel: false
          };

          map = new google.maps.Map(document.getElementById('google-map'),  mapOptions);

          google.maps.event.addDomListener(map, 'idle', function() {
              calculateCenter();
          });

          google.maps.event.addDomListener(window, 'resize', function() {
              map.setCenter(center);
          });
      }
      //My Location
//      function initMap() {
//          var myLatLng = {lat: 30.356190, lng: 76.372212};
//          var map = new google.maps.Map(document.getElementById('map'), {
//              zoom:6,
//              center: myLatLng
//          });
//          var marker = new google.maps.Marker({
//              position: myLatLng,
//              map: map,
//              title: 'You Are Here'
//          });
//      }

      function calculateCenter() {
          center = map.getCenter();
      }

      function loadGoogleMap(){
          var script = document.createElement('script');
          script.type = 'text/javascript';
          script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' + 'callback=initialize';
          document.body.appendChild(script);
      }

      // DOM is ready
      $(function() {

          // https://css-tricks.com/snippets/jquery/smooth-scrolling/
          $('a[href*=#]:not([href=#])').click(function() {
              if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                  var target = $(this.hash);
                  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                  if (target.length) {
                      $('html,body').animate({
                          scrollTop: target.offset().top
                      }, 1000);
                      return false;
                  }
              }
          });

          // Flexslider
          $('.flexslider').flexslider({
              controlNav: false,
              directionNav: false
          });

          // Google Map
          loadGoogleMap();
      });
  </script>
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>      		<!-- jQuery -->
  	<script type="text/javascript" src="js/moment.js"></script>							<!-- moment.js -->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>					<!-- bootstrap js -->
	<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>	<!-- bootstrap date time picker js, http://eonasdan.github.io/bootstrap-datetimepicker/ -->
	<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
   	<script type="text/javascript" src="js/templatemo-script.js"></script>      		<!-- Templatemo Script -->
	<script>
		// HTML document is loaded. DOM is ready.
		$(function() {

			$('#hotelCarTabs a').click(function (e) {
			  e.preventDefault()
			  $(this).tab('show')
			})

        	$('.date').datetimepicker({
            	format: 'MM/DD/YYYY'
            });
            $('.date-time').datetimepicker();

			// https://css-tricks.com/snippets/jquery/smooth-scrolling/
		  	$('a[href*=#]:not([href=#])').click(function() {
			    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			      var target = $(this.hash);
			      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			      if (target.length) {
			        $('html,body').animate({
			          scrollTop: target.offset().top
			        }, 1000);
			        return false;
			      }
			    }
		  	});
		});

		// Load Flexslider when everything is loaded.
		$(window).load(function() {
		    $('.flexslider').flexslider({
			    controlNav: false
		    });
	  	});
	</script>
 </body>
 </html>
