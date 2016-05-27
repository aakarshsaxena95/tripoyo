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
<div class="tm-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-4 col-sm-3 tm-site-name-container">
                <a href="home.php" class="tm-site-name">Trip OYO</a>
            </div>
            <div class="col-lg-6 col-md-8 col-sm-9">
                <div class="mobile-menu-icon">
                    <i class="fa fa-bars"></i>
                </div>
                <nav class="tm-nav">
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">profile</a></li>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<section class="tm-white-bg section-padding-bottom">
    <div class="container">
        <div class="row">
            <div class="tm-section-header section-margin-top">
                <div class="col-lg-4 col-md-3 col-sm-3"><hr></div>
                <div class="col-lg-4 col-md-6 col-sm-6"><h2 class="tm-section-title">Your Trip Plan</h2></div>
                <div class="col-lg-4 col-md-3 col-sm-3"><hr></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
            </div>
            <div>
                <?php
                include ("connection.php");
                $ans="";
                $c=0;
                session_start();
                $c=$_GET["count"];
                $s=array($c);
                $r=array($c);
                for($i=0;$i<$c;$i++){
                    $s[$i]=$_SESSION['value'.$i];
                    $r[$i]=$_SESSION['sequence'.$i];
                }
                $ky="";
                $ko="";
                $ans.='<div class="form-control">';
                for($i=0;$i<$c;$i++){
                    $t="select `name`, `no._of_days` from indian_cities where `s.no`=".$s[$r[$i]];
                    $result=mysqli_query($conn,$t);
                    $h=mysqli_fetch_array($result);
                    if($i==0){
                        $ko=$h[0];
                        $ans.=$h[0]." ----> ".$ky;
                    }
                    else{
                        $ky=$h[1];
                        $ans.=$h[0]."  (".$ky.") ----> ";
                    }
                }
                $ans.=$ko.'</div>';
                $ans.='<br>
                <div class="col-lg-6 col-md-6 tm-contact-form-input">
                      <div class="form-group">
                          <nav class="tm-nav">
                              <ul>
                                  <li><a href="suggestion.php">Recommendations</a></li>
                              </ul>
                          </nav>
                    </div>
                </div>';
                echo $ans;
                ?>
            </div>
        </div>
    </div>
</section>
<br><br><br><br><br><br>
<?php
include("footer.php");
?>
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>      		<!-- jQuery -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>					<!-- bootstrap js -->
<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>			<!-- flexslider js -->
<script type="text/javascript" src="js/templatemo-script.js"></script>      		<!-- Templatemo Script -->
</body>
</html>
