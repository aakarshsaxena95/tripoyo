<?php
session_start();
$start=$_SESSION['location'];
$days=$_SESSION['days'];
include("connection.php");
$c=count($_POST['check_list']);
$c++;
$val=array($c);
$lat=array($c);
$long=array($c);
$s="select `s.no`,`latitute`, `longitute` from indian_cities where `name`='".$start."'";
$result=mysqli_query($conn,$s);
$r=mysqli_fetch_array($result);
$val[0]=$r[0];
$la=$r[1];
$lo=$r[2];
$la=explode(" ", $la);
$lo=explode(" ", $lo);
$lat[0]=$la[0];
$long[0]=$lo[0];
echo $val[0]." ".$lat[0]." ".$long[0]."</br>";
$i=1;
if(!empty($_POST['check_list'])){
    foreach($_POST['check_list'] as $selected){

        $val[$i]=$selected;
        $s="select `latitute`, `longitute` from indian_cities where `s.no`=".$val[$i];
        $result=mysqli_query($conn,$s);
        $r=mysqli_fetch_array($result);
        $la=$r[0];
        $lo=$r[1];
        $la=explode(" ", $la);
        $lo=explode(" ", $lo);
        $lat[$i]=$la[0];
        $long[$i]=$lo[0];
        echo $val[$i]."     ".$lat[$i]."        ".$long[$i]."</br>";
        $i++;
    }
}

echo '</br>';
function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
    return array('distance' => $dist, 'time' => $time);
}
$distance2=array(array($c));
for($i=0;$i<$c;$i++){
    for($j=0;$j<$c;$j++){
        $distance2[$i][$j]=0;
    }
}
for($i=0;$i<$c;$i++){
    for($j=0;$j<$c;$j++){
        if($i==$j){
            $distance2[$i][$j]=250000;
        }
        else if($distance2[$i][$j]>0)
        {
            echo $distance2[$i][$j]."       ";
            continue;
        }
        else{
            $temp=GetDrivingDistance($lat[$i],$lat[$j],$long[$i],$long[$j]);
            $temp=$temp['distance'];
            $temp=explode(" ",$temp);
            $h=strlen($temp[0]);
            $p=$temp[0];
            if($h<=3)
            {
                $distance2[$i][$j]=$temp[0];
                $distance2[$j][$i]=$temp[0];
            }
            else
            {
                $n=$p[3]*100+$p[4]*10+$p[5]+$p[0]*1000;
                $distance2[$i][$j]=$n;
                $distance2[$j][$i]=$n;
            }
        }
        echo $distance2[$i][$j]."       ";
    }
    echo "</br>";
}
$visited=array($c);
for($j=0;$j<$c;$j++){
    $visited[$j]=0;
}
$ans=array($c);
$k=0;
$i=0;
$t=1;
$visited[$i]=1;
while($t!=$c)
{
    $min=2500000;
    $k=$i;
    for($j=0;$j<$c;$j++)
    {
        if($distance2[$i][$j]<$min && $visited[$j]==0)
        {
            $min=$distance2[$i][$j];
            $k=$j;
        }
    }
    $ans[$i]=$k;
    $t++;
    $i=$k;
    $visited[$k]=1;
}

$i=0;
$t=1;
while($t<$c)
{   $r=$i;
    echo $val[$i]."=>".$val[$ans[$i]]."   ";
    $i=$ans[$i];
    $t++;
}
$p=$ans[$r];
$ans[$p]=0;
echo $val[$ans[$r]]."=>".$val[0]."</br>";
$sequence=array($c);
$q=0;
for($i=0;$i<$c;$i++){
    $sequence[$i]=$q;
    $q=$ans[$q];
    echo $sequence[$i]." ";
}
for($i=0;$i<$c;$i++){
    $_SESSION['value'.$i]=$val[$i];
    $_SESSION['sequence'.$i]=$sequence[$i];
}
header("location: trip.php?count=".$c);

?>