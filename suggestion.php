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
                <div class="col-lg-4 col-md-6 col-sm-6"><h2 class="tm-section-title">Recommendation</h2></div>
                <div class="col-lg-4 col-md-3 col-sm-3"><hr></div>
            </div>
        </div>
        <div class="row">
            <div>
                <?php
                include ('connection.php');
                function distance($lat1, $lon1, $lat2, $lon2, $unit) {

                    $theta = $lon1 - $lon2;
                    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                    $dist = acos($dist);
                    $dist = rad2deg($dist);
                    $miles = $dist * 60 * 1.1515;
                    $unit = strtoupper($unit);

                    if ($unit == "K") {
                        return ($miles * 1.609344);
                    } else if ($unit == "N") {
                        return ($miles * 0.8684);
                    } else {
                        return $miles;
                    }
                }
                session_start();
                $nod=$_SESSION['days'];
                $startcity=$_SESSION['location'];
                $s='select `latitute`, `longitute` from indian_cities WHERE `name`="'.$startcity.'"';
                $result=mysqli_query($conn,$s);
                $r=mysqli_fetch_array($result);
                $la=$r[0];
                $lo=$r[1];
                $la=explode(" ", $la);
                $lo=explode(" ", $lo);
                $slat=$la[0];
                $slog=$lo[0];
                $min=2500000;
                $f=0;
                $agid=array(9);
                $vb=0;
                $h=1;
                $j="";
                while($f==0) {
                    $min=2500000;
                    $s = "SELECT `latitute`, `longitute`, `group_id` FROM indian_cities WHERE flag=1 and group_id IS NOT NULL ORDER BY group_id";
                    $result = mysqli_query($conn, $s);
                    while ($r = mysqli_fetch_array($result)) {
                        $la = $r[0];
                        $lo = $r[1];
                        $la = explode(" ", $la);
                        $lo = explode(" ", $lo);
                        $lat = $la[0];
                        $lng = $lo[0];
                        if ($slat == $lat)
                            continue;

                        for($k=0;$k<$vb;$k++)
                        {
                            if($r[2]==$agid[$k])
                                $h=0;
                            else
                                $h=1;
                        }
                        if($h==0)
                            continue;
                        $dist = distance($slat, $slog, $lat, $lng, "K");
                        if ($dist < $min) {
                            $min = $dist;
                            $gno = $r[2];
                        }

                    }
                    $s = "select `name`,`no._of_days`,`latitute`,`longitute` from indian_cities where `group_id`=" . $gno;//also fetch count here
                    $result = mysqli_query($conn, $s);
                    $s1 = "select count(`s.no`) from indian_cities where `group_id`=" . $gno;
                    $result1 = mysqli_query($conn, $s1);
                    $r1 = mysqli_fetch_array($result1);
                    $count = $r1[0];
                    $i = 0;
                    $lat = array($count);
                    $lng = array($count);
                    $name = array($count);
                    $days = array($count);
                    $location=array($count);
                    while ($r = mysqli_fetch_array($result)) {
                        $name[$i] = $r[0];
                        $days[$i] = $r[1];
                        $i++;
                    }
                    $n = 0;
                    $i = 0;
                    $rem = $nod;

                    $t=-1;
                    while ($rem > 0 && $i < $count) {
                        if ($name[$i] == $startcity) {
                            $t = $i;
                            $i++;
                            continue;
                        }

                        if ($days[$i] <= $rem) {
                            $location[$i] = $days[$i];
                            $rem = $rem - $days[$i];
                        }
                        else {


                            $location[$i] = $rem;

                            $rem = 0;
                        }
                        $i++;

                    }



                    if ($rem == 0)
                        $f = 1;
                    else
                    {
                        $agid[$vb]=$gno;
                        $vb++;
                        $t=-1;
                    }
                }

                $ans="";
                $ans2="";
                $ans1="";
                $a='<h3>Best Recommendation</h3>';
                $a.='<br>';
                echo $a;
                $ans.='<div class="form-control">'.$startcity."---->";
                for($j=0;$j<$i;$j++){
                    if($j!=$t)
                        $ans.=$name[$j]." (".$location[$j].")"." ----> ";

                }
                $ans.=$startcity;
                $ans.='</div></br></br></br>';
                echo $ans;
                $b='<h3>Other Recommendations</h3>';
                echo $b;
                for($i=13;$i>=1;$i--)
                {
                    $rem=$nod;
                    if(($i==5)||($i==$gno)||($i==11))
                        continue;
                    else
                    {
                        $ans1="";
                        $ans1.='<div class="form-control">'.$startcity."---->";
                        $s="select `name`, `no._of_days` from indian_cities where `group_id`=".$i;
                        $result=mysqli_query($conn,$s);
                        while($r=mysqli_fetch_array($result))
                        {
                            $name=$r[0];
                            $d=$r[1];
                            if($rem>0)
                            {
                                if($d<$rem)
                                {
                                    $ans1.=$name." (".$d.")"." ----> ";
                                    $rem=$rem-$d;
                                }
                                else
                                {
                                    $ans1.=$name." (".$rem.")"." ----> ";
                                    $rem=0;
                                }
                            }

                        }
                        $ans1.=$startcity;
                        $ans1.='</div>';
                        echo $ans1;
                        echo '</br>';

                    }
                }

                ?>
            </div>

        </div>
    </div>
</section>
<?php
include("footer.php");
?>
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>      		<!-- jQuery -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>					<!-- bootstrap js -->
<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>			<!-- flexslider js -->
<script type="text/javascript" src="js/templatemo-script.js"></script>      		<!-- Templatemo Script -->
</body>
</html>

